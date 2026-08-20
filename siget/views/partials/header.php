<?php
// views/partials/header.php - Encabezado superior
$userName = $_SESSION['usuario_nombre'] ?? 'Usuario';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
$rolLabel = [
    'admin' => 'Administrador',
    'profesional' => 'Profesional',
    'paciente' => 'Paciente'
][$userRol] ?? ucfirst($userRol);
?>

<header class="top-navbar navbar navbar-expand-lg navbar-light bg-white">
    <div class="container-fluid">
        <!-- Botón para mostrar/ocultar sidebar en móvil -->
        <button class="navbar-toggler d-lg-none" type="button" id="sidebarToggle" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Título de la página (opcional) -->
        <span class="navbar-brand d-lg-none">
            <i class="bi bi-hospital"></i> SIGET
        </span>

        <!-- Menú derecho (usuario, notificaciones, tema) -->
        <div class="ms-auto d-flex align-items-center gap-3">
            <!-- Notificaciones (icono) -->
            <button class="btn btn-link position-relative" title="Notificaciones">
                <i class="bi bi-bell"></i>
                <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span> -->
            </button>

            <!-- Toggle de tema (Light/Dark) -->
            <button class="btn btn-link" id="themeToggle" title="Cambiar tema">
                <i class="bi bi-moon"></i>
            </button>

            <!-- Dropdown de usuario -->
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; color: inherit;">
                    <div class="user-info text-end d-none d-md-block">
                        <div class="user-name small fw-semibold"><?= htmlspecialchars($userName) ?></div>
                        <div class="user-role small text-muted"><?= $rolLabel ?></div>
                    </div>
                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= urlencode($userName) ?>" alt="Avatar" class="rounded-circle" width="36" height="36">
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="?r=profile"><i class="bi bi-person-fill me-2"></i> Mi Perfil</a></li>
                    <li><a class="dropdown-item" href="?r=settings"><i class="bi bi-gear-fill me-2"></i> Configuración</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="?r=logout"><i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>