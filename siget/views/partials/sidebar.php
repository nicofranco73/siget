<?php
// views/partials/sidebar.php - Sidebar con navegación
$currentRoute = $_GET['r'] ?? 'home';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
?>

<nav id="sidebar" class="sidebar-nav">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <?php if (file_exists(__DIR__ . '/../../public/assets/img/logoTesis.png')): ?>
            <img src="assets/img/logoTesis.png" alt="SIGET" class="sidebar-logo">
        <?php else: ?>
            <div class="sidebar-logo-placeholder">
                <i class="bi bi-hospital"></i>
            </div>
        <?php endif; ?>
        <h4 class="mb-0 text-white" style="font-size: 1.1rem; font-weight: 700;">SIGET</h4>
        <small class="text-white-50">Sistema de Turnos</small>
    </div>

    <hr class="my-3">

    <!-- Menú de Navegación -->
    <ul class="nav flex-column components">
        <!-- Inicio -->
        <li class="nav-item">
            <a class="nav-link <?= ($currentRoute === 'home' || $currentRoute === '') ? 'active' : '' ?>" href="?r=home">
                <i class="bi bi-house-door-fill"></i>
                <span>Inicio</span>
            </a>
        </li>

        <!-- Turnos - Visible para todos -->
        <li class="nav-item">
            <a class="nav-link <?= (strpos($currentRoute, 'turno') === 0) ? 'active' : '' ?>" href="?r=turnos">
                <i class="bi bi-calendar2-check"></i>
                <span>Mis Turnos</span>
            </a>
        </li>

        <?php if ($userRol !== 'paciente'): ?>
            <hr class="my-2">

            <!-- Sección Administrativa -->
            <li class="nav-header text-white-50 ps-3 small fw-semibold">ADMINISTRACIÓN</li>

            <!-- Pacientes -->
            <li class="nav-item">
                <a class="nav-link <?= ($currentRoute === 'pacientes' || strpos($currentRoute, 'paciente') === 0) ? 'active' : '' ?>" href="?r=pacientes">
                    <i class="bi bi-people-fill"></i>
                    <span>Pacientes</span>
                </a>
            </li>

            <!-- Profesionales -->
            <li class="nav-item">
                <a class="nav-link <?= ($currentRoute === 'profesionales' || strpos($currentRoute, 'profesional') === 0) ? 'active' : '' ?>" href="?r=profesionales">
                    <i class="bi bi-person-badge-fill"></i>
                    <span>Profesionales</span>
                </a>
            </li>

            <!-- Especialidades -->
            <li class="nav-item">
                <a class="nav-link <?= (strpos($currentRoute, 'especialidad') === 0) ? 'active' : '' ?>" href="?r=especialidades">
                    <i class="bi bi-building"></i>
                    <span>Especialidades</span>
                </a>
            </li>

            <!-- Reportes -->
            <li class="nav-item">
                <a class="nav-link" href="?r=reportes" title="Estadísticas y reportes">
                    <i class="bi bi-bar-chart-fill"></i>
                    <span>Reportes</span>
                </a>
            </li>

            <hr class="my-2">
        <?php endif; ?>

        <!-- Historial (para pacientes) o General (para staff) -->
        <li class="nav-item">
            <a class="nav-link <?= (strpos($currentRoute, 'historial') === 0) ? 'active' : '' ?>" href="?r=historial">
                <i class="bi bi-clock-history"></i>
                <span><?= ($userRol === 'paciente') ? 'Mi Historial' : 'Historial General' ?></span>
            </a>
        </li>
    </ul>

    <hr class="my-3">

    <!-- Cerrar sesión -->
    <div class="sidebar-footer">
        <a class="nav-link text-danger" href="?r=logout" title="Cerrar sesión">
            <i class="bi bi-box-arrow-right"></i>
            <span>Salir</span>
        </a>
    </div>
</nav>