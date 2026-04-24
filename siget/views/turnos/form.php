<?php
// views/turnos/form.php - usa layout central
$title = 'Crear Turno';
ob_start();
?>
<h1>Crear Turno</h1>

<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="?r=turnos_store">
  <div class="mb-3">
    <label class="form-label">Paciente</label>
    <select name="paciente_id" class="form-select" required>
      <option value="">-- Seleccione --</option>
      <?php foreach ($pacientes as $p): ?>
        <option value="<?= $p['id'] ?>" <?= (isset($_POST['paciente_id']) && $_POST['paciente_id']==$p['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($p['apellido'] . ' ' . $p['nombre'] . ' (DNI:' . $p['dni'] . ')') ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Profesional</label>
    <select name="profesional_id" class="form-select" required>
      <option value="">-- Seleccione --</option>
      <?php foreach ($profesionales as $pr): ?>
        <option value="<?= $pr['id'] ?>" <?= (isset($_POST['profesional_id']) && $_POST['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($pr['apellido'] . ' ' . $pr['nombre'] . ' (' . $pr['especialidad'] . ')') ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Inicio</label>
    <input type="datetime-local" name="inicio" class="form-control" required value="<?= htmlspecialchars($_POST['inicio'] ?? '') ?>">
    <div class="form-text">Fecha y hora de inicio del turno.</div>
  </div>

  <div class="mb-3">
    <label class="form-label">Duración (minutos)</label>
    <input type="number" name="duracion_min" class="form-control" required min="5" value="<?= htmlspecialchars($_POST['duracion_min'] ?? 30) ?>">
  </div>

  <div class="mb-3">
    <label class="form-label">Motivo</label>
    <textarea name="motivo" class="form-control" rows="3"><?= htmlspecialchars($_POST['motivo'] ?? '') ?></textarea>
  </div>

  <button class="btn btn-primary" type="submit">Guardar turno</button>
  <a class="btn btn-secondary" href="?r=turnos">Volver</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';