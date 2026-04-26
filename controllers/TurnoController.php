<?php
// controllers/TurnoController.php
require_once __DIR__ . '/../models/Turno.php';
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../models/Profesional.php';

class TurnoController {
    protected $model;
    protected $pacModel;
    protected $proModel;

    public function __construct() {
        $this->model = new Turno();
        $this->pacModel = new Paciente();
        $this->proModel = new Profesional();
    }

    public function index() {
        $rol = $_SESSION['usuario_rol'] ?? 'paciente';
        $userId = $_SESSION['usuario_id'];

        if ($rol === 'paciente') {
            $todos = $this->model->all();
            $turnos = array_filter($todos, function($t) use ($userId) {
                return $t['paciente_id'] == $userId;
            });
        } else {
            $turnos = $this->model->all();
        }

        $profesionales = $this->proModel->all();
        $pacModel = $this->pacModel;
        $proModel = $this->proModel;

        require __DIR__ . '/../views/turnos/index.php';
    }

    public function createForm() {
        $error = null;
        $rol = $_SESSION['usuario_rol'] ?? 'paciente';
        
        if ($rol === 'paciente') {
            $p = $this->pacModel->find($_SESSION['usuario_id']);
            $pacientes = $p ? [$p] : [];
        } else {
            $pacientes = $this->pacModel->all();
        }
        
        $profesionales = $this->proModel->all();
        require __DIR__ . '/../views/turnos/form.php';
    }

    public function store() {
        try {
            $rawInicio = $_POST['inicio'] ?? '';
            $inicio = (strpos($rawInicio, 'T') !== false) ? str_replace('T', ' ', $rawInicio) . ':00' : $rawInicio;

            // VALIDACIÓN 1: No permitir fechas pasadas
            $fechaTurno = strtotime($inicio);
            $ahora = time();

            if ($fechaTurno < $ahora) {
                throw new Exception("No se pueden agendar turnos en fechas u horarios pasados.");
            }

            $data = [
                'paciente_id' => (int)($_POST['paciente_id'] ?? 0),
                'profesional_id' => (int)($_POST['profesional_id'] ?? 0),
                'inicio' => $inicio,
                'duracion_min' => (int)($_POST['duracion_min'] ?? 30),
                'motivo' => trim($_POST['motivo'] ?? ''),
                'estado' => 'agendado',
            ];

            // VALIDACIÓN 2: El modelo hace el check de solapamiento
            $this->model->create($data);

            // IMPORTANTE: Volvemos a la ruta que SI existe
            header('Location: ?r=turnos&msg=created');
            exit;

        } catch (Exception $e) {
            $error = $e->getMessage();
            $rol = $_SESSION['usuario_rol'] ?? 'paciente';
            
            if ($rol === 'paciente') {
                $p = $this->pacModel->find($_SESSION['usuario_id']);
                $pacientes = $p ? [$p] : [];
            } else {
                $pacientes = $this->pacModel->all();
            }
            $profesionales = $this->proModel->all();
            
            require __DIR__ . '/../views/turnos/form.php';
        }
    }

    public function cancel() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($id) $this->model->markAsCancelled($id);
        header('Location: ?r=turnos&msg=cancelled');
        exit;
    }

    public function agendaDiaria() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') die("No autorizado");
        $date = $_GET['date'] ?? date('Y-m-d');
        $profesional_id = isset($_GET['profesional_id']) && $_GET['profesional_id'] !== '' ? (int)$_GET['profesional_id'] : null;
        $turnos = $this->model->getForDay($date, $profesional_id);
        $profesionales = $this->proModel->all();
        $pacModel = $this->pacModel;
        $proModel = $this->proModel;
        require __DIR__ . '/../views/turnos/agenda_diaria.php';
    }

    public function agendaSemanal() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') die("No autorizado");
        $date = $_GET['date'] ?? date('Y-m-d');
        $profesional_id = isset($_GET['profesional_id']) && $_GET['profesional_id'] !== '' ? (int)$_GET['profesional_id'] : null;
        $ts = strtotime($date);
        $weekday = (int)date('N', $ts);
        $mondayTs = strtotime("-" . ($weekday - 1) . " days", $ts);
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $d = date('Y-m-d', strtotime("+$i days", $mondayTs));
            $days[$d] = $this->model->getForDay($d, $profesional_id);
        }
        $profesionales = $this->proModel->all();
        $pacModel = $this->pacModel;
        $proModel = $this->proModel;
        require __DIR__ . '/../views/turnos/agenda_semanal.php';
    }
}