<?php
// controllers/ProfesionalController.php
require_once __DIR__ . '/../models/Profesional.php';

class ProfesionalController {
    protected $model;

    public function __construct() {
        $this->model = new Profesional();
    }

    public function index() {
        $profesionales = $this->model->all();
        require __DIR__ . '/../views/profesionales/index.php';
    }

    public function createForm() {
        // SEGURIDAD: Solo el admin accede al formulario
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            header('Location: ?r=profesionales&msg=not_authorized');
            exit;
        }
        $error = null;
        require __DIR__ . '/../views/profesionales/form.php';
    }

    public function store() {
        // SEGURIDAD: Doble validación en el servidor
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            die("Acceso denegado: No tiene permisos para realizar esta acción.");
        }

        try {
            $rawDisp = trim($_POST['disponibilidad'] ?? '');
            if ($rawDisp === '') {
                $dispVal = null;
            } else {
                $decoded = json_decode($rawDisp, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $dispVal = json_encode($decoded);
                } else {
                    $parts = preg_split('/[;,]+/', $rawDisp);
                    $parts = array_map('trim', array_filter($parts, fn($v) => $v !== ''));
                    $dispVal = empty($parts) ? json_encode([$rawDisp]) : json_encode($parts);
                }
            }

            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'especialidad' => trim($_POST['especialidad'] ?? ''),
                'telefono' => $_POST['telefono'] ?? null,
                'email' => $_POST['email'] ?? null,
                'disponibilidad' => $dispVal,
            ];

            $this->model->create($data);
            header('Location: ?r=profesionales&msg=created');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            require __DIR__ . '/../views/profesionales/form.php';
        }
    }
}