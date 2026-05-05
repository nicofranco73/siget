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
        
        // Carga con diseño (Layout)
        ob_start();
        require __DIR__ . '/../views/pacientes/index.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
    }

    public function createForm() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') {
            die("Acceso denegado.");
        }
        $error = null;
        $paciente = null; // Para que el form sepa que es ALTA
        
        ob_start();
        require __DIR__ . '/../views/pacientes/form.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
    }

    public function editForm() {
        $id = $_GET['id'] ?? null;
        $paciente = $this->model->find($id);
        
        if (!$paciente) {
            header('Location: ?r=pacientes&msg=not_found');
            exit;
        }
        
        $error = null;
        
        ob_start();
        require __DIR__ . '/../views/pacientes/form.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
    }

    public function store() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') {
            die("Acceso denegado.");
        }

        try {
            $id = $_POST['id'] ?? null; // Si viene ID, es edición
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
            $paciente = $_POST; // Mantenemos los datos en el form si hay error
            
            ob_start();
            require __DIR__ . '/../views/pacientes/form.php';
            $content = ob_get_clean();
            require __DIR__ . '/../views/layout.php';
        }
    }

    public function view() {
        $id = $_GET['id'] ?? null;
        $paciente = $this->model->find($id);
        
        if (!$paciente) {
            header('Location: ?r=pacientes&msg=not_found');
            exit;
        }
        
        // MODIFICACIÓN: Sincronización para evitar errores en ver.php
        if (!isset($paciente['id_paciente'])) {
            $paciente['id_paciente'] = $paciente['id'];
        }

        // MODIFICACIÓN: Evitar el Warning de fecha_nac que vimos en la captura
        if (!isset($paciente['fecha_nac'])) {
            $paciente['fecha_nac'] = null;
        }

        // Variables obligatorias para los foreach de la vista (Historial y Turnos)
        $historial = []; 
        $turnos = [];
        
        // MODIFICACIÓN: Envolver en el diseño general (Layout)
        ob_start();
        require __DIR__ . '/../views/pacientes/ver.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout.php';
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