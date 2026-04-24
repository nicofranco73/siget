<?php
// controllers/PacienteController.php
require_once __DIR__ . '/../models/Paciente.php';

class PacienteController {
    protected $model;

    public function __construct() {
        $this->model = new Paciente();
    }

    public function index() {
        $rol = $_SESSION['usuario_rol'] ?? 'paciente';
        
        if ($rol === 'paciente') {
            // Un paciente solo debe ver su propio registro.
            // Asumimos que el 'id' del paciente coincide con el 'usuario_id' de la sesión o lo buscamos.
            $p = $this->model->find($_SESSION['usuario_id']);
            $pacientes = $p ? [$p] : [];
        } else {
            $pacientes = $this->model->all();
        }
        
        require __DIR__ . '/../views/pacientes/index.php';
    }

    public function createForm() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') die("No autorizado");
        $error = null;
        require __DIR__ . '/../views/pacientes/form.php';
    }

    public function store() {
        try {
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'dni' => trim($_POST['dni'] ?? ''),
                'fecha_nac' => !empty($_POST['fecha_nac']) ? $_POST['fecha_nac'] : null,
                'telefono' => $_POST['telefono'] ?? null,
                'email' => $_POST['email'] ?? null,
                'direccion' => $_POST['direccion'] ?? null,
            ];
            $this->model->create($data);
            header('Location: ?r=pacientes&msg=created');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../views/pacientes/form.php';
        }
    }

    public function delete() {
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') die("Solo administradores");
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->softDelete($id);
            header('Location: ?r=pacientes&msg=deleted');
            exit;
        }
    }
}