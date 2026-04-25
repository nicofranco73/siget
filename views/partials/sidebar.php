<?php
// views/partials/sidebar.php
$rol = $_SESSION['usuario_rol'] ?? 'paciente';
?>
<nav id="sidebar">
    <div class="sidebar-header text-center py-4">
        <img src="../public/assets/img/logoTesis.png" alt="Logo SIGET" class="sidebar-logo mb-3">
        
        <h3 class="fw-bold mb-0" style="letter-spacing: 1.5px;">SIGET</h3>
        <small class="opacity-75">Gestión Hospitalaria</small>
    </div>

    <ul class="list-unstyled components">
        <li class="<?= (!isset($_GET['r']) || $_GET['r'] == 'home') ? 'active' : '' ?>">
            <a href="index.php">
                <i class="bi bi-house-door"></i> Dashboard
            </a>
        </li>
        
        <li class="<?= (isset($_GET['r']) && $_GET['r'] == 'pacientes') ? 'active' : '' ?>">
            <a href="index.php?r=pacientes">
                <i class="bi bi-people"></i> <?= ($rol === 'paciente') ? 'Mi Perfil' : 'Pacientes' ?>
            </a>
        </li>

        <li class="<?= (isset($_GET['r']) && $_GET['r'] == 'turnos') ? 'active' : '' ?>">
            <a href="index.php?r=turnos">
                <i class="bi bi-calendar-event"></i> <?= ($rol === 'paciente') ? 'Mis Turnos' : 'Turnos' ?>
            </a>
        </li>

        <?php if ($rol === 'admin' || $rol === 'staff'): ?>
        <li class="<?= (isset($_GET['r']) && strpos($_GET['r'], 'agenda') !== false) ? 'active' : '' ?>">
            <a href="#agendaSubmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                <i class="bi bi-calendar3"></i> Agendas
            </a>
            <ul class="collapse list-unstyled ps-3" id="agendaSubmenu">
                <li><a href="index.php?r=turnos_agenda_diaria" class="small">Diaria</a></li>
                <li><a href="index.php?r=turnos_agenda_semanal" class="small">Semanal</a></li>
            </ul>
        </li>

        <hr class="mx-3 opacity-25">

        <li class="<?= (isset($_GET['r']) && $_GET['r'] == 'profesionales') ? 'active' : '' ?>">
            <a href="index.php?r=profesionales">
                <i class="bi bi-person-badge"></i> Profesionales
            </a>
        </li>

        <li class="<?= (isset($_GET['r']) && $_GET['r'] == 'especialidades') ? 'active' : '' ?>">
            <a href="index.php?r=especialidades">
                <i class="bi bi-heart-pulse"></i> Especialidades
            </a>
        </li>
        <?php endif; ?>

        <hr class="mx-3 opacity-25">

        <li>
            <a href="index.php?r=logout" class="text-warning">
                <i class="bi bi-box-arrow-right"></i> Salir
            </a>
        </li>
    </ul>
</nav>