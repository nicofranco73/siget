<?php
// views/profesionales/form.php - usa layout central
$title = 'Alta Profesional';
ob_start();
?>
<h1>Alta Profesional</h1>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<form method="post" action="?r=profesionales_store">
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input class="form-control" name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Apellido</label>
    <input class="form-control" name="apellido" required value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Especialidad</label>
    <input class="form-control" name="especialidad" value="<?= htmlspecialchars($_POST['especialidad'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input class="form-control" name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Disponibilidad (texto o JSON)</label>
    <textarea class="form-control" name="disponibilidad" rows="3"><?= htmlspecialchars($_POST['disponibilidad'] ?? '') ?></textarea>
    <div class="form-text">Ej: LUN:08:00-17:00, MAR:08:00-12:00 o JSON.</div>
  </div>
  <button class="btn btn-primary" type="submit">Guardar</button>
  <a class="btn btn-secondary" href="?r=profesionales">Volver</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';