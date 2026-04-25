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
            // Solo incluimos las columnas que existen físicamente en tu tabla de MySQL
            $data = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellido'  => trim($_POST['apellido'] ?? ''),
                'dni'       => trim($_POST['dni'] ?? ''),
                'telefono'  => $_POST['telefono'] ?? null,
                'email'     => $_POST['email'] ?? null,
                'direccion' => $_POST['direccion'] ?? null,
            ];

            // Ejecuta la inserción
            $this->model->create($data);
            
            // Si el guardado es exitoso, redirige con el mensaje para SweetAlert2
            header('Location: ?r=pacientes&msg=created');
            exit;
        } catch (Exception $e) {
            // Captura el error y lo envía a la vista para que lo veas en el banner rojo
            $error = "Error de base de datos: " . $e->getMessage();
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