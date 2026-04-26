<?php
// controllers/ProfesionalController.php

require_once __DIR__ . '/../models/Profesional.php';
require_once __DIR__ . '/../models/especialidad.php';

class ProfesionalController {
    protected $model;
    protected $especialidadModel;

    public function __construct($db = null) {
        $this->model = new Profesional();
        $this->especialidadModel = new Especialidad($db);
    }

    public function index() {
        $profesionales = $this->model->all();
        require __DIR__ . '/../views/profesionales/index.php';
    }

    public function createForm() {
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            header('Location: ?r=profesionales&msg=not_authorized');
            exit;
        }
        
        $error = null;
        $especialidades = $this->especialidadModel->getAllActive();
        require __DIR__ . '/../views/profesionales/form.php';
    }

    public function store() {
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            die("Acceso denegado: No tiene permisos.");
        }

        try {
            $rawDisp = trim($_POST['disponibilidad'] ?? '');
            $dispVal = null;
            if ($rawDisp !== '') {
                $parts = preg_split('/[;,]+/', $rawDisp);
                $parts = array_map('trim', array_filter($parts, fn($v) => $v !== ''));
                $dispVal = empty($parts) ? json_encode([$rawDisp]) : json_encode($parts);
            }

            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'id_especialidad' => $_POST['id_especialidad'] ?? null,
                'telefono' => $_POST['telefono'] ?? null,
                'email' => $_POST['email'] ?? null,
                'disponibilidad' => $dispVal,
            ];

            $this->model->create($data);
            header('Location: ?r=profesionales&msg=created');
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $especialidades = $this->especialidadModel->getAllActive();
            require __DIR__ . '/../views/profesionales/form.php';
        }
    }
}