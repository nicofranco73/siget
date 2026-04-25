<?php
$title = 'Nuevo Turno';
ob_start();
?>
<div class="mb-4">
    <h1><i class="bi bi-calendar-plus me-2"></i>Crear Nuevo Turno</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="post" action="?r=turnos_store">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Paciente</label>
                    <select name="paciente_id" class="form-select border-primary" required>
                        <option value="">-- Seleccione Paciente --</option>
                        <?php foreach ($pacientes as $p): ?>
                            <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['apellido'].' '.$p['nombre'].' (DNI: '.$p['dni'].')') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Profesional</label>
                    <select name="profesional_id" class="form-select border-primary" required>
                        <option value="">-- Seleccione Profesional --</option>
                        <?php foreach ($profesionales as $pr): ?>
                            <option value="<?= $pr['id'] ?>"><?= htmlspecialchars($pr['apellido'].' '.$pr['nombre'].' - '.$pr['especialidad']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-bold">Fecha y Hora de Inicio</label>
                    <input type="datetime-local" name="inicio" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Duración (min)</label>
                    <input type="number" name="duracion_min" class="form-control" value="30" min="5">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Motivo de la consulta</label>
                <textarea name="motivo" class="form-control" rows="3" placeholder="Ej: Control anual..."></textarea>
            </div>

            <hr>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i> Guardar Turno</button>
                <a class="btn btn-outline-secondary" href="?r=turnos"><i class="bi bi-arrow-left"></i> Volver</a>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';