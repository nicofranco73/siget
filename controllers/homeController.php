<?php
// controllers/HomeController.php

class HomeController {
    public function index() {
        require_once __DIR__ . '/../models/Paciente.php';
        require_once __DIR__ . '/../models/Profesional.php';
        require_once __DIR__ . '/../models/Turno.php';

        $pacModel = new Paciente();
        $proModel = new Profesional();
        $turModel = new Turno();

        // Obtenemos los conteos reales
        $pacientesCount = count($pacModel->all());
        $profesionalesCount = count($proModel->all());
        $turnosCount = count($turModel->all());

        // Obtenemos los 5 turnos más recientes/próximos
        // Nota: Asegúrate de tener un método que limite o simplemente usa los últimos del array
        $allTurnos = $turModel->all();
        $recentTurnos = array_slice(array_reverse($allTurnos), 0, 5);

        // Pasamos todo a la vista
        require __DIR__ . '/../views/home.php';
    }
}