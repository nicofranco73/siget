<?php
// views/pacientes/form.php - usa layout central
$title = 'Alta Paciente';
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-plus me-2"></i>Alta de Paciente</h1>
</div>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger shadow-sm border-start border-4 border-danger">
      <i class="bi bi-exclamation-triangle-fill me-2"></i><?= htmlspecialchars($error) ?>
  </div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form id="pacienteForm" method="post" action="?r=pacientes_store" novalidate>
          <div class="mb-3">
            <label class="form-label fw-bold">Nombre</label>
            <input id="nombre" class="form-control" name="nombre" required 
                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Ej: Juan">
            <div class="invalid-feedback">El nombre es obligatorio y no puede contener números.</div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Apellido</label>
            <input id="apellido" class="form-control" name="apellido" required 
                   value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" placeholder="Ej: Pérez">
            <div class="invalid-feedback">El apellido es obligatorio.</div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">DNI</label>
            <input id="dni" class="form-control" name="dni" required
                   value="<?= htmlspecialchars($_POST['dni'] ?? '') ?>" placeholder="Solo números">
            <div class="invalid-feedback">El DNI debe tener entre 7 y 8 números (sin puntos).</div>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Teléfono</label>
            <input id="telefono" class="form-control" name="telefono" 
                   value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" placeholder="Ej: 3751000000">
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input id="email" type="email" class="form-control" name="email" 
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="ejemplo@correo.com">
            <div class="invalid-feedback">Ingresá un correo electrónico válido.</div>
          </div>

          <hr>
          <div class="d-flex gap-2">
              <button id="btnGuardar" class="btn btn-primary px-4" type="submit">
                  <i class="bi bi-save me-1"></i> Guardar
              </button>
              <a class="btn btn-outline-secondary" href="?r=pacientes">
                  <i class="bi bi-arrow-left"></i> Volver
              </a>
          </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';