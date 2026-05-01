<?php
// controllers/PacienteController.php - Completo para SIGET

require_once __DIR__ . '/../models/Paciente.php';

class PacienteController {
    protected $model;

    public function __construct() {
        $this->model = new Paciente();
    }

    public function index() {
        $rol = $_SESSION['usuario_rol'] ?? 'paciente';
        if ($rol === 'paciente') {
            $p = $this->model->find($_SESSION['usuario_id']);
            $pacientes = $p ? [$p] : [];
        } else {
            $pacientes = $this->model->all();
        }
        require __DIR__ . '/../views/pacientes/index.php';
    }

    public function createForm() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') {
            die("Acceso denegado.");
        }
        $error = null;
        $paciente = null;
        require __DIR__ . '/../views/pacientes/form.php';
    }

    public function editForm() {
        $id = $_GET['id'] ?? null;
        $paciente = $this->model->find($id);
        
        if (!$paciente) {
            header('Location: ?r=pacientes&msg=not_found');
            exit;
        }
        
        $error = null;
        require __DIR__ . '/../views/pacientes/form.php';
    }

    public function store() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') {
            die("Acceso denegado.");
        }

        try {
            $id = $_POST['id'] ?? null;
            $data = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellido'  => trim($_POST['apellido'] ?? ''),
                'dni'       => trim($_POST['dni'] ?? ''),
                'telefono'  => $_POST['telefono'] ?? null,
                'email'     => $_POST['email'] ?? null,
                'direccion' => $_POST['direccion'] ?? null,
            ];

            if (empty($data['nombre']) || empty($data['apellido']) || empty($data['dni'])) {
                throw new Exception("Nombre, Apellido y DNI son campos obligatorios.");
            }

            if ($id) {
                $this->model->update($id, $data);
                $msg = 'updated';
            } else {
                $this->model->create($data);
                $msg = 'created';
            }
            
            header("Location: ?r=pacientes&msg=$msg");
            exit;

        } catch (Exception $e) {
            $error = $e->getMessage();
            $paciente = $_POST;
            require __DIR__ . '/../views/pacientes/form.php';
        }
    }

    public function view() {
        $id = $_GET['id'] ?? null;
        $paciente = $this->model->find($id);
        
        if (!$paciente) {
            header('Location: ?r=pacientes&msg=not_found');
            exit;
        }

        // Sincronización para la vista ver.php
        if (!isset($paciente['id_paciente'])) {
            $paciente['id_paciente'] = $paciente['id'];
        }

        // Inicializamos estas variables para que la vista ver.php no tire error
        $historial = []; 
        $turnos = [];
        
        require __DIR__ . '/../views/pacientes/ver.php';
    }

    public function delete() {
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            die("Acceso denegado.");
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->softDelete($id);
            header('Location: ?r=pacientes&msg=deleted');
            exit;
        }
    }
}