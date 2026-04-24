<?php
// views/pacientes/form.php - usa layout central
$title = 'Alta Paciente';
ob_start();
?>
<h1>Alta Paciente</h1>
<?php if (!empty($error)): ?>
  <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" action="?r=pacientes_store">
  <div class="mb-3">
    <label class="form-label">Nombre</label>
    <input class="form-control" name="nombre" required value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Apellido</label>
    <input class="form-control" name="apellido" required value="<?= htmlspecialchars($_POST['apellido'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">DNI</label>
    <input class="form-control" name="dni" value="<?= htmlspecialchars($_POST['dni'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Teléfono</label>
    <input class="form-control" name="telefono" value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
  </div>

  <button class="btn btn-primary" type="submit">Guardar</button>
  <a class="btn btn-secondary" href="?r=pacientes">Volver</a>
</form>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';