<?php
// controllers/especialidadController.php

class EspecialidadController {
    private $modelo;

    public function __construct($db) {
        require_once __DIR__ . '/../models/especialidad.php';
        $this->modelo = new Especialidad($db);
    }

    public function index() {
        $especialidades = $this->modelo->getAllActive();
        $title = "Gestión de Especialidades";
        ob_start(); 
        require_once __DIR__ . '/../views/especialidades/index.php';
        $content = ob_get_clean(); 
        require_once __DIR__ . '/../views/layout.php';
    }

    public function guardar() {
        // SEGURIDAD: Solo el admin puede guardar nuevas especialidades
        if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
            header("Location: index.php?r=especialidades&error=unauthorized");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            
            if (!empty($nombre)) {
                if ($this->modelo->create($nombre, $descripcion)) {
                    header("Location: index.php?r=especialidades&success=1");
                    exit();
                } else {
                    echo "Error al guardar";
                }
            }
        }
    }
}