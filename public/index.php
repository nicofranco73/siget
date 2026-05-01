<?php
// public/index.php - Front controller con HELPERS para SIGET

date_default_timezone_set('America/Argentina/Buenos_Aires');

session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// --- FUNCIONES HELPERS (Para que ver.php no de pantalla en blanco) ---
function h($text) {
    return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
}

function url($route, $action = null, $params = []) {
    $url = "?r=" . $route;
    if ($action) $url .= "_" . $action;
    if (!empty($params)) {
        foreach ($params as $key => $val) {
            $url .= "&$key=$val";
        }
    }
    return $url;
}

function fecha($fecha) {
    return $fecha ? date('d/m/Y', strtotime($fecha)) : '—';
}

function fechaHora($fechahora) {
    return $fechahora ? date('d/m/Y H:i', strtotime($fechahora)) : '—';
}

function estadoBadge($estado) {
    $clases = [
        'pendiente' => 'bg-warning text-dark',
        'confirmado' => 'bg-success',
        'cancelado' => 'bg-danger',
        'atendido' => 'bg-info'
    ];
    $clase = $clases[strtolower($estado)] ?? 'bg-secondary';
    return '<span class="badge ' . $clase . '">' . ucfirst($estado) . '</span>';
}
// --- FIN HELPERS ---

$pdo = require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/BaseModel.php';

// Modelos y Controladores
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../controllers/PacienteController.php';
require_once __DIR__ . '/../models/Profesional.php';
require_once __DIR__ . '/../controllers/ProfesionalController.php';
require_once __DIR__ . '/../models/Turno.php';
require_once __DIR__ . '/../controllers/TurnoController.php';
require_once __DIR__ . '/../models/especialidad.php';
require_once __DIR__ . '/../controllers/especialidadController.php';

$rutasPublicas = ['login', 'authenticate', 'logout'];
$route = $_GET['r'] ?? 'login';

if (!isset($_SESSION['usuario_autenticado']) && !in_array($route, $rutasPublicas)) {
    header('Location: ?r=login');
    exit();
}

if (isset($_SESSION['usuario_autenticado']) && $route === 'login') {
    header('Location: ?r=home');
    exit();
}

$userRol = $_SESSION['usuario_rol'] ?? 'paciente';

// --- RUTAS PROTEGIDAS ---
$rutasProhibidasPaciente = [
    'pacientes_create', 'pacientes_store', 'pacientes_delete', 
    'pacientes_edit', 'pacientes_view', 
    'profesionales', 'profesionales_create', 'profesionales_store',
    'especialidades', 'especialidades_guardar',
    'turnos_agenda_diaria', 'turnos_agenda_semanal'
];

if ($userRol === 'paciente' && in_array($route, $rutasProhibidasPaciente)) {
    die("Acceso Denegado: Su rol de Paciente no permite realizar esta acción.");
}

if ($route === 'pacientes_delete' && $userRol !== 'admin') {
    die("Acceso Denegado: Solo el Administrador puede eliminar registros.");
}

// Lógica de Autenticación
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

$pc = new PacienteController();
$prc = new ProfesionalController();
$tc = new TurnoController();
$ec = new EspecialidadController($pdo);

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
    case 'pacientes_edit':
        $pc->editForm();
        break;
    case 'pacientes_view': 
        $pc->view();
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