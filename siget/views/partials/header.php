<?php
// views/partials/header.php
$rol_display = 'Usuario';
if (isset($_SESSION['usuario_rol'])) {
    if ($_SESSION['usuario_rol'] === 'admin') $rol_display = 'Administrador IT';
    if ($_SESSION['usuario_rol'] === 'staff') $rol_display = 'Personal de Salud';
    if ($_SESSION['usuario_rol'] === 'paciente') $rol_display = 'Paciente';
}
?>

<header class="top-navbar bg-white py-2 px-3 shadow-sm mb-0">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-outline-primary d-lg-none" id="sidebarToggle" title="Menú">
                <i class="bi bi-list"></i>
            </button>
            
            <h5 class="mb-0 fw-bold text-dark">
                <?= isset($title) ? htmlspecialchars($title) : 'SIGET - Dashboard' ?>
            </h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-light text-primary border d-none d-md-inline-block">
                Rol: <?= $rol_display ?>
            </span>

            <?php if (isset($_SESSION['usuario_autenticado'])): ?>
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle fs-5"></i>
                        <span class="fw-semibold small"><?= htmlspecialchars($_SESSION['usuario_nombre'] ?? $_SESSION['usuario']) ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userMenu">
                        <li><span class="dropdown-item-text small text-muted">Conectado como: <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></span></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="index.php?r=logout"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
                    </ul>
                </div>
            <?php endif; ?>

            <button class="btn btn-outline-secondary btn-sm rounded-circle" type="button" id="themeToggle" title="Cambiar tema">
                <i class="bi bi-moon"></i>
            </button>
        </div>
    </div>
</header>