<?php
// views/partials/footer.php - Pie de página
$year = date('Y');
$version = '1.0.0';
?>

<footer class="bg-light border-top py-3 mt-auto">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-md-6 small text-muted">
                <strong>SIGET</strong> v<?= $version ?> &copy; <?= $year ?> 
                <span class="d-none d-md-inline">— Sistema de Gestión de Turnos Médicos</span>
            </div>
            <div class="col-md-6 text-end small text-muted">
                <a href="#" class="text-muted text-decoration-none me-3">Ayuda</a>
                <a href="#" class="text-muted text-decoration-none me-3">Privacidad</a>
                <a href="#" class="text-muted text-decoration-none">Contacto</a>
            </div>
        </div>
    </div>
</footer>