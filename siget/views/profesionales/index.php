<?php
// views/profesionales/index.php - protegido por rol
$title = 'Profesionales';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();
?>
<h1>Profesionales</h1>

<?php if ($userRol === 'admin'): ?>
    <p><a class="btn btn-success" href="?r=profesionales_create">Nuevo profesional</a></p>
<?php endif; ?>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'created'): ?>
  <div class="alert alert-success">Profesional creado correctamente.</div>
<?php endif; ?>

<?php if (empty($profesionales)): ?>
  <p>No hay profesionales registrados.</p>
<?php else: ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Apellido</th>
        <th>Nombre</th>
        <th>Especialidad</th>
        <th>Teléfono</th>
        <th>Email</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($profesionales as $pr): ?>
      <tr>
        <td><?= $pr['id'] ?></td>
        <td><?= htmlspecialchars($pr['apellido']) ?></td>
        <td><?= htmlspecialchars($pr['nombre']) ?></td>
        <td><?= htmlspecialchars($pr['especialidad']) ?></td>
        <td><?= htmlspecialchars($pr['telefono']) ?></td>
        <td><?= htmlspecialchars($pr['email']) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<p><a class="btn btn-primary" href="?">Volver al inicio</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';