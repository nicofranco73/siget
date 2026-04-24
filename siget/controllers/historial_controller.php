<?php
// controllers/historial_controller.php

require_once __DIR__ . '/../models/historial.php'; 

class historial_controller {
    private $modelo;

    public function __construct() {
        // Intentamos instanciar el modelo y capturamos errores de una
        try {
            $this->modelo = new Historial(); 
        } catch (Exception $e) {
            die("Error al instanciar el modelo Historial: " . $e->getMessage());
        }
    }

    public function index() {
        // 1. Validar ID del paciente
        $id_paciente = $_GET['id_paciente'] ?? null;
        
        if (!$id_paciente) { 
            header("Location: ?r=pacientes"); 
            exit; 
        }

        $title = "Historia Clínica";

        // 2. Obtener datos (Si falla el SQL, el die() que pusimos en el modelo actuará)
        $consultas = $this->modelo->obtener_por_paciente($id_paciente);

        // 3. Renderizar vista con verificación de existencia
        ob_start();
        
        $vistaRuta = __DIR__ . '/../views/historial/index.php';
        
        if (!file_exists($vistaRuta)) {
            ob_end_clean();
            die("Error Fatal: No existe el archivo de la vista en: " . $vistaRuta . ". Revisá el nombre de la carpeta y del archivo.");
        }

        require $vistaRuta;
        
        $content = ob_get_clean();

        // 4. Cargar el layout central
        $layoutRuta = __DIR__ . '/../views/layout.php';
        if (!file_exists($layoutRuta)) {
            die("Error Fatal: No se encuentra el archivo layout.php en: " . $layoutRuta);
        }

        require $layoutRuta;
    }
}