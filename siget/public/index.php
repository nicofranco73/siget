<?php
// public/index.php - Front controller con autenticación y roles completos

date_default_timezone_set('America/Argentina/Buenos_Aires');

// 1. INICIAR SESIÓN Y MOSTRAR ERRORES
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. CARGA DE CONFIGURACIÓN Y MODELOS BASE
$pdo = require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/BaseModel.php';

// Modelos y Controladores existentes
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../controllers/PacienteController.php';

require_once __DIR__ . '/../models/Profesional.php';
require_once __DIR__ . '/../controllers/ProfesionalController.php';

require_once __DIR__ . '/../models/Turno.php';
require_once __DIR__ . '/../controllers/TurnoController.php';

require_once __DIR__ . '/../models/especialidad.php';
require_once __DIR__ . '/../controllers/especialidadController.php';

// 3. DEFINICIÓN DE RUTAS Y SEGURIDAD
$rutasPublicas = ['login', 'authenticate', 'logout'];
$route = $_GET['r'] ?? 'login';

// Validar si el usuario está logueado
if (!isset($_SESSION['usuario_autenticado']) && !in_array($route, $rutasPublicas)) {
    header('Location: ?r=login');
    exit();
}

// Redirigir al home si ya está logueado e intenta ir al login
if (isset($_SESSION['usuario_autenticado']) && $route === 'login') {
    header('Location: ?r=home');
    exit();
}

// --- BLOQUEO DE SEGURIDAD POR ROL ---
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';

// Definir rutas que el Paciente NO puede tocar
$rutasProhibidasPaciente = [
    'pacientes_create', 'pacientes_store', 'pacientes_delete',
    'profesionales', 'profesionales_create', 'profesionales_store',
    'especialidades', 'especialidades_guardar',
    'turnos_agenda_diaria', 'turnos_agenda_semanal'
];

if ($userRol === 'paciente' && in_array($route, $rutasProhibidasPaciente)) {
    die("Acceso Denegado: Su rol de Paciente no permite realizar esta acción.");
}

// Solo el ADMIN puede borrar
if ($route === 'pacientes_delete' && $userRol !== 'admin') {
    die("Acceso Denegado: Solo el Administrador puede eliminar registros.");
}
// ------------------------------------

// 4. PROCESAR AUTENTICACIÓN
if ($route === 'authenticate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $_SESSION['error_login'] = "Por favor, rellene todos los campos.";
        header('Location: ?r=login');
        exit();
    }

    try {
        $query = "SELECT id, username, password_hash, nombre, rol, activo FROM usuarios WHERE username = ? AND activo = 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$username]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password_hash'])) {
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario'] = $usuario['username'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            header('Location: ?r=home');
            exit();
        } else {
            $_SESSION['error_login'] = "Usuario o contraseña incorrectos.";
            header('Location: ?r=login');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_login'] = "Error en el sistema.";
        header('Location: ?r=login');
        exit();
    }
}

// 5. INSTANCIAR CONTROLADORES ESTÁNDAR
$pc = new PacienteController();
$prc = new ProfesionalController();
$tc = new TurnoController();
$ec = new EspecialidadController($pdo);

// 6. SWITCH DE ENRUTAMIENTO
switch ($route) {
    case 'login':
        require __DIR__ . '/../views/login_view.php';
        break;
    
    case 'logout':
        session_destroy();
        header('Location: ?r=login');
        exit();

    case 'pacientes':
        $pc->index();
        break;
    case 'pacientes_create':
        $pc->createForm();
        break;
    case 'pacientes_store':
        $pc->store();
        break;
    case 'pacientes_delete':
        $pc->delete();
        break;

    case 'historial':
        require_once __DIR__ . '/../models/historial.php';
        require_once __DIR__ . '/../controllers/historial_controller.php';
        $hc = new historial_controller();
        $hc->index();
        break;

    case 'profesionales':
        $prc->index();
        break;
    case 'profesionales_create':
        $prc->createForm();
        break;
    case 'profesionales_store':
        $prc->store();
        break;

    case 'turnos':
        $tc->index();
        break;
    case 'turnos_create':
        $tc->createForm();
        break;
    case 'turnos_store':
        $tc->store();
        break;
    case 'turnos_cancel':
        $tc->cancel();
        break;
    case 'turnos_agenda_diaria':
        $tc->agendaDiaria();
        break;
    case 'turnos_agenda_semanal':
        $tc->agendaSemanal();
        break;

    case 'especialidades':
        $ec->index();
        break;
    case 'especialidades_guardar':
        $ec->guardar();
        break;

    case 'home':
    default:
        $pacModel = new Paciente();
        $proModel = new Profesional();
        $turnoModel = new Turno();

        $pacientesAll = $pacModel->all();
        $profesionalesAll = $proModel->all();
        $turnosAll = $turnoModel->all();

        $pacientesCount = is_array($pacientesAll) ? count($pacientesAll) : 0;
        $profesionalesCount = is_array($profesionalesAll) ? count($profesionalesAll) : 0;
        $turnosCount = is_array($turnosAll) ? count($turnosAll) : 0;
        $recentTurnos = array_slice($turnosAll ?: [], 0, 5);

        require __DIR__ . '/../views/home.php';
        break;
}