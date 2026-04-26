<?php
// views/turnos/form.php
$title = 'Nuevo Turno';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4" style="color: #6f42c1;">
    <h1><i class="bi bi-calendar-plus-fill me-2"></i>Registrar Cita Médica</h1>
</div>

<?php if (isset($error) && $error): ?>
    <div class="alert alert-danger border-start border-4 border-danger shadow-sm">
        <i class="bi bi-exclamation-octagon-fill me-2"></i><strong>Error:</strong> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <form id="turnoForm" method="post" action="?r=turnos_store" novalidate class="needs-validation">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Paciente</label>
                    <select name="paciente_id" class="form-select form-select-lg border-primary-subtle" style="border-color: #6f42c1 !important;" required>
                        <option value="">-- Seleccione Paciente --</option>
                        <?php foreach ($pacientes as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['apellido'].' '.$p['nombre'].' (DNI: '.$p['dni'].')') ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Debe seleccionar un paciente.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Profesional / Especialidad</label>
                    <select name="profesional_id" class="form-select form-select-lg border-primary-subtle" style="border-color: #6f42c1 !important;" required>
                        <option value="">-- Seleccione Profesional --</option>
                        <?php foreach ($profesionales as $pr): ?>
                            <option value="<?= $pr['id'] ?>"><?= htmlspecialchars($pr['apellido'].' '.$pr['nombre'].' - '.$pr['especialidad']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Debe asignar un profesional.</div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" name="inicio" class="form-control form-control-lg border-primary-subtle" required>
                    <div class="invalid-feedback">Seleccione fecha y hora válidas.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold small text-muted text-uppercase">Duración Estimada (minutos)</label>
                    <input type="number" name="duracion_min" class="form-control form-control-lg border-primary-subtle" value="30" min="5" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold small text-muted text-uppercase">Motivo de la consulta</label>
                <textarea name="motivo" class="form-control border-primary-subtle" rows="3" placeholder="Ej: Control post-operatorio, consulta general..."></textarea>
            </div>

            <hr class="my-4">
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-lg px-5 shadow-sm text-white" style="background-color: #6f42c1;">
                    <i class="bi bi-save me-2"></i>Confirmar Turno
                </button>
                <a class="btn btn-outline-secondary btn-lg" href="?r=turnos">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('turnoForm');
    const inputs = form.querySelectorAll('select, input');

    const validar = (el) => {
        if (el.checkValidity()) {
            el.classList.remove('is-invalid');
            el.classList.add('is-valid');
        } else {
            el.classList.remove('is-valid');
            el.classList.add('is-invalid');
        }
    };

    inputs.forEach(input => {
        input.addEventListener('change', () => validar(input));
    });

    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
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