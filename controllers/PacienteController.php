<?php
// controllers/PacienteController.php

require_once __DIR__ . '/../models/Paciente.php';

class PacienteController {
    protected $model;

    public function __construct() {
        // Inicializamos el modelo de Pacientes
        $this->model = new Paciente();
    }

    /**
     * Lista los pacientes según el rol del usuario logueado
     */
    public function index() {
        $rol = $_SESSION['usuario_rol'] ?? 'paciente';
        
        if ($rol === 'paciente') {
            // Si es un paciente, solo ve sus propios datos
            $p = $this->model->find($_SESSION['usuario_id']);
            $pacientes = $p ? [$p] : [];
        } else {
            // Si es admin o staff, ve todos los pacientes activos
            $pacientes = $this->model->all();
        }
        
        require __DIR__ . '/../views/pacientes/index.php';
    }

    /**
     * Muestra el formulario de alta (solo para admin/staff)
     */
    public function createForm() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') {
            die("Acceso denegado: No tiene permisos para registrar pacientes.");
        }
        
        $error = null;
        require __DIR__ . '/../views/pacientes/form.php';
    }

    /**
     * Procesa y guarda los datos del nuevo paciente
     */
    public function store() {
        if (($_SESSION['usuario_rol'] ?? 'paciente') === 'paciente') {
            die("Acceso denegado.");
        }

        try {
            // Limpiamos y preparamos los datos
            $data = [
                'nombre'    => trim($_POST['nombre'] ?? ''),
                'apellido'  => trim($_POST['apellido'] ?? ''),
                'dni'       => trim($_POST['dni'] ?? ''),
                'telefono'  => $_POST['telefono'] ?? null,
                'email'     => $_POST['email'] ?? null,
                'direccion' => $_POST['direccion'] ?? null,
            ];

            // Validaciones básicas
            if (empty($data['nombre']) || empty($data['apellido']) || empty($data['dni'])) {
                throw new Exception("Nombre, Apellido y DNI son campos obligatorios.");
            }

            // Guardamos en la base de datos
            $this->model->create($data);
            
            // Redirigimos al listado con mensaje de éxito
            header('Location: ?r=pacientes&msg=created');
            exit;

        } catch (Exception $e) {
            // Si hay error, volvemos al formulario mostrando el mensaje
            $error = $e->getMessage();
            require __DIR__ . '/../views/pacientes/form.php';
        }
    }

    /**
     * Baja lógica de un paciente
     */
    public function delete() {
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            die("Acceso denegado: Solo el administrador puede eliminar registros.");
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->model->softDelete($id);
            header('Location: ?r=pacientes&msg=deleted');
            exit;
        }
    }
}