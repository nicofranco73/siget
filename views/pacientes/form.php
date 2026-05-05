<?php
// views/pacientes/form.php
$esEdicion = !empty($paciente['id']);
// Ya no usamos $title, ob_start o require aquí porque el controlador se encarga
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="text-success">
        <h1 class="fw-bold mb-0" style="color: #2d8a6e;">
            <i class="bi <?= $esEdicion ? 'bi-pencil-square' : 'bi-person-plus-fill' ?> me-2"></i>
            <?= $esEdicion ? "Editar Paciente: " . htmlspecialchars($paciente['nombre']) : "Registrar Nuevo Paciente" ?>
        </h1>
        <p class="text-muted mb-0 small">Complete los campos para <?= $esEdicion ? 'actualizar' : 'dar de alta' ?> al paciente en el sistema</p>
    </div>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger border-start border-4 border-danger shadow-sm">
        <i class="bi bi-exclamation-octagon-fill me-2"></i><?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-4">
        <form id="pacienteForm" method="post" action="?r=pacientes_store" novalidate class="needs-validation">
            <!-- Campo oculto para el ID en caso de edición -->
            <?php if($esEdicion): ?>
                <input type="hidden" name="id" value="<?= $paciente['id'] ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Nombre</label>
                    <input type="text" class="form-control border-success-subtle shadow-sm" name="nombre" id="nombre" required 
                           value="<?= htmlspecialchars($paciente['nombre'] ?? '') ?>" placeholder="Ej: Juan">
                    <div class="invalid-feedback">El nombre es obligatorio (mínimo 2 letras).</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Apellido</label>
                    <input type="text" class="form-control border-success-subtle shadow-sm" name="apellido" id="apellido" required 
                           value="<?= htmlspecialchars($paciente['apellido'] ?? '') ?>" placeholder="Ej: Perez">
                    <div class="invalid-feedback">El apellido es obligatorio.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">DNI / Documento</label>
                    <input type="text" class="form-control border-success-subtle shadow-sm" name="dni" id="dni" required 
                           value="<?= htmlspecialchars($paciente['dni'] ?? '') ?>" placeholder="Solo números" pattern="\d{7,10}">
                    <div class="invalid-feedback">DNI inválido. Ingrese entre 7 y 10 números.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Teléfono</label>
                    <input type="text" class="form-control border-success-subtle shadow-sm" name="telefono" id="telefono"
                           value="<?= htmlspecialchars($paciente['telefono'] ?? '') ?>" placeholder="3751-000000">
                    <div class="invalid-feedback">Ingrese un teléfono de contacto.</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-muted text-uppercase">Correo Electrónico</label>
                <input type="email" class="form-control border-success-subtle shadow-sm" name="email" id="email"
                       value="<?= htmlspecialchars($paciente['email'] ?? '') ?>" placeholder="paciente@correo.com">
                <div class="invalid-feedback">Por favor, ingrese un email válido.</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-muted text-uppercase">Dirección Residencial</label>
                <input type="text" class="form-control border-success-subtle shadow-sm" name="direccion" id="direccion"
                       value="<?= htmlspecialchars($paciente['direccion'] ?? '') ?>" placeholder="Calle, Número, Barrio">
            </div>

            <hr class="my-4 text-muted opacity-25">
            
            <div class="d-flex gap-3">
                <button class="btn btn-success btn-lg px-5 shadow-sm" type="submit" style="background-color: #2d8a6e; border: none;">
                    <i class="bi bi-save me-2"></i><?= $esEdicion ? 'Actualizar Cambios' : 'Guardar Paciente' ?>
                </button>
                <a class="btn btn-light border btn-lg px-4 shadow-sm" href="?r=pacientes">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Script de validación Bootstrap
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
</script>