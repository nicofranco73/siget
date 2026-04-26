<?php
// views/profesionales/form.php
$title = 'Alta Profesional';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4 text-primary">
    <h1><i class="bi bi-person-plus-fill me-2"></i>Alta de Profesional</h1>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger border-start border-4 border-danger shadow-sm">
        <i class="bi bi-exclamation-octagon-fill me-2"></i><?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form id="profesionalForm" method="post" action="?r=profesionales_store" novalidate class="needs-validation">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Nombre</label>
                    <input type="text" class="form-control form-control-lg border-primary-subtle" name="nombre" id="nombre" required 
                           value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Ej: Carlos">
                    <div class="invalid-feedback">El nombre es requerido (mínimo 2 letras).</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Apellido</label>
                    <input type="text" class="form-control form-control-lg border-primary-subtle" name="apellido" id="apellido" required 
                           value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" placeholder="Ej: Gómez">
                    <div class="invalid-feedback">El apellido es requerido.</div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold text-primary small text-uppercase">Especialidad Médica</label>
                <select name="id_especialidad" id="id_especialidad" class="form-select form-select-lg border-primary" required>
                    <option value="">-- Seleccione una Especialidad --</option>
                    <?php if (!empty($especialidades)): ?>
                        <?php foreach ($especialidades as $esp): ?>
                            <option value="<?= $esp['id_especialidad'] ?>" 
                                <?= (isset($_POST['id_especialidad']) && $_POST['id_especialidad'] == $esp['id_especialidad']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($esp['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <div class="invalid-feedback">Debe asignar una especialidad.</div>
                <div class="form-text">Si no ve la especialidad, créela primero en el menú correspondiente.</div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Teléfono de Contacto</label>
                    <input type="text" class="form-control border-primary-subtle" name="telefono" id="telefono"
                           value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" placeholder="3751-000000">
                    <div class="invalid-feedback">Ingrese un número válido.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Email Institucional</label>
                    <input type="email" class="form-control border-primary-subtle" name="email" id="email"
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="profesional@correo.com">
                    <div class="invalid-feedback">Formato de correo inválido.</div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-muted text-uppercase">Disponibilidad de Atención</label>
                <textarea class="form-control border-primary-subtle" name="disponibilidad" id="disponibilidad" rows="3" 
                          placeholder="Ej: Lunes y Miércoles 08:00 a 12:00"><?= htmlspecialchars($_POST['disponibilidad'] ?? '') ?></textarea>
                <div class="form-text">Describa brevemente los días y horarios.</div>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-3">
                <button class="btn btn-primary btn-lg px-5 shadow-sm" type="submit">
                    <i class="bi bi-save me-2"></i>Guardar Profesional
                </button>
                <a class="btn btn-outline-secondary btn-lg" href="?r=profesionales">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('profesionalForm');
    const inputs = form.querySelectorAll('input, select, textarea');

    const validar = (el) => {
        let valido = false;
        const val = el.value.trim();

        if (el.name === 'nombre' || el.name === 'apellido') {
            valido = val.length >= 2;
        } else if (el.name === 'id_especialidad') {
            valido = val !== "";
        } else if (el.name === 'email' && val !== "") {
            valido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
        } else {
            valido = true; // Campos opcionales
        }

        if (valido) {
            el.classList.remove('is-invalid');
            el.classList.add('is-valid');
        } else {
            el.classList.remove('is-valid');
            el.classList.add('is-invalid');
        }
        return valido;
    };

    inputs.forEach(input => {
        input.addEventListener('change', () => validar(input));
        input.addEventListener('input', () => validar(input));
    });

    form.addEventListener('submit', function(e) {
        let formValido = true;
        inputs.forEach(input => {
            if (input.hasAttribute('required') && !validar(input)) {
                formValido = false;
            }
        });

        if (!formValido || !form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';