<?php
// views/pacientes/form.php
$title = 'Alta de Paciente';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4 text-success">
    <h1><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Paciente</h1>
</div>

<?php if (!empty($error)): ?>
    <div class="alert alert-danger border-start border-4 border-danger shadow-sm">
        <i class="bi bi-exclamation-octagon-fill me-2"></i><?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form id="pacienteForm" method="post" action="?r=pacientes_store" novalidate class="needs-validation">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Nombre</label>
                    <input type="text" class="form-control border-success-subtle" name="nombre" id="nombre" required 
                           value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" placeholder="Ej: Juan">
                    <div class="invalid-feedback">El nombre es obligatorio (mínimo 2 letras).</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Apellido</label>
                    <input type="text" class="form-control border-success-subtle" name="apellido" id="apellido" required 
                           value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>" placeholder="Ej: Perez">
                    <div class="invalid-feedback">El apellido es obligatorio.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">DNI / Documento</label>
                    <input type="text" class="form-control border-success-subtle" name="dni" id="dni" required 
                           value="<?= htmlspecialchars($_POST['dni'] ?? '') ?>" placeholder="Solo números" pattern="\d{7,9}">
                    <div class="invalid-feedback">DNI inválido. Ingrese entre 7 y 9 números (sin puntos ni letras).</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Teléfono</label>
                    <input type="text" class="form-control border-success-subtle" name="telefono" id="telefono"
                           value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>" placeholder="3751-000000">
                    <div class="invalid-feedback">Ingrese un teléfono de contacto.</div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold small text-muted text-uppercase">Correo Electrónico</label>
                <input type="email" class="form-control border-success-subtle" name="email" id="email"
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" placeholder="paciente@correo.com">
                <div class="invalid-feedback">Por favor, ingrese un email válido (ejemplo@correo.com).</div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-muted text-uppercase">Dirección Residencial</label>
                <input type="text" class="form-control border-success-subtle" name="direccion" id="direccion"
                       value="<?= htmlspecialchars($_POST['direccion'] ?? '') ?>" placeholder="Calle, Número, Barrio">
            </div>

            <hr class="my-4">
            <div class="d-flex gap-3">
                <button class="btn btn-success btn-lg px-5 shadow-sm" type="submit">
                    <i class="bi bi-save me-2"></i>Guardar Paciente
                </button>
                <a class="btn btn-outline-secondary btn-lg" href="?r=pacientes">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pacienteForm');
    const inputs = form.querySelectorAll('input');

    const validarInput = (input) => {
        let valido = false;
        const val = input.value.trim();

        if (input.name === 'nombre' || input.name === 'apellido') {
            valido = val.length >= 2;
        } else if (input.name === 'dni') {
            // Regex: Solo números, entre 7 y 9 dígitos
            valido = /^\d{7,9}$/.test(val);
        } else if (input.name === 'email') {
            // Regex estándar de email
            valido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
        } else if (input.id === 'telefono') {
            valido = val.length >= 7;
        } else if (input.id === 'direccion') {
            valido = val.length > 0;
        }

        if (valido) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
        return valido;
    };

    // Validar mientras el usuario escribe
    inputs.forEach(input => {
        input.addEventListener('input', () => validarInput(input));
    });

    // Validar al intentar enviar
    form.addEventListener('submit', function(event) {
        let formValido = true;
        inputs.forEach(input => {
            if (input.hasAttribute('required') || input.value !== '') {
                if (!validarInput(input)) formValido = false;
            }
        });

        if (!formValido || !form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';