<?php
// views/profesionales/form.php - usa layout central
$title = 'Alta Profesional';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-plus-fill me-2"></i>Alta de Profesional</h1>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger border-start border-4 border-danger shadow-sm">
        <i class="bi bi-exclamation-octagon-fill me-2"></i><?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form id="pacienteForm" method="post" action="?r=profesionales_store" novalidate>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nombre</label>
                    <input id="nombre" class="form-control" name="nombre" required 
                           value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Ej: Carlos">
                    <div class="invalid-feedback">El nombre es obligatorio.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Apellido</label>
                    <input id="apellido" class="form-control" name="apellido" required 
                           value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" placeholder="Ej: Gómez">
                    <div class="invalid-feedback">El apellido es obligatorio.</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Especialidad</label>
                <input class="form-control" name="especialidad" placeholder="Ej: Cardiología"
                       value="<?= htmlspecialchars($_POST['especialidad'] ?? '') ?>">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Teléfono</label>
                    <input id="telefono" class="form-control" name="telefono" 
                           value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" placeholder="3751-000000">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input id="email" type="email" class="form-control" name="email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="profesional@correo.com">
                    <div class="invalid-feedback">Ingrese un email válido.</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Disponibilidad (Horarios)</label>
                <textarea class="form-control" name="disponibilidad" rows="3" 
                          placeholder="Ej: LUN: 08:00-17:00"><?= htmlspecialchars($_POST['disponibilidad'] ?? '') ?></textarea>
                <div class="form-text text-muted">Indique días y rangos horarios.</div>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button class="btn btn-primary px-4" type="submit">
                    <i class="bi bi-save me-1"></i> Guardar Profesional
                </button>
                <a class="btn btn-outline-secondary" href="?r=profesionales">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';