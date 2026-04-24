<?php
// views/turnos/index.php - usa layout central
$title = 'Turnos';
ob_start();
?>
<h1>Turnos</h1>

<div class="mb-3">
  <a class="btn btn-success" href="?r=turnos_create">Nuevo turno</a>
</div>

<!-- Formulario rápido para ver agenda: fecha + profesional -->
<form method="get" class="row g-2 mb-4">
  <input type="hidden" name="r" value="turnos_agenda_diaria">
  <div class="col-auto">
    <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>">
  </div>
  <div class="col-auto">
    <select name="profesional_id" class="form-select">
      <option value="">-- Todos los profesionales --</option>
      <?php
        // $profesionales debería venir del controlador; si no, cargamos rápido
        if (!isset($profesionales)) {
            require_once __DIR__ . '/../../models/Profesional.php';
            $pmodel = new Profesional();
            $profesionales = $pmodel->all();
        }
        foreach ($profesionales as $pr): ?>
        <option value="<?= $pr['id'] ?>" <?= (isset($_GET['profesional_id']) && $_GET['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
          <?= htmlspecialchars($pr['apellido'] . ' ' . $pr['nombre'] . ' (' . $pr['especialidad'] . ')') ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-auto">
    <button class="btn btn-primary">Ver agenda diaria</button>
  </div>
  <div class="col-auto">
    <!-- Link directo a agenda semanal con mismos filtros -->
    <a class="btn btn-outline-secondary" href="?r=turnos_agenda_semanal&date=<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>&profesional_id=<?= urlencode($_GET['profesional_id'] ?? '') ?>">Ver agenda semanal</a>
  </div>
</form>

<?php if (!empty($_GET['msg']) && $_GET['msg'] === 'created'): ?>
  <div class="alert alert-success">Turno creado correctamente.</div>
<?php endif; ?>

<?php if (empty($turnos)): ?>
  <p>No hay turnos registrados.</p>
<?php else: ?>
  <?php
    // preferimos usar los modelos pasados por el controlador ($pacModel, $proModel)
    if (!isset($pacModel)) {
        require_once __DIR__ . '/../../models/Paciente.php';
        $pacModel = new Paciente();
    }
    if (!isset($proModel)) {
        require_once __DIR__ . '/../../models/Profesional.php';
        $proModel = new Profesional();
    }
  ?>
  <table class="table table-striped">
    <thead><tr><th>ID</th><th>Paciente</th><th>Profesional</th><th>Inicio</th><th>Duración (min)</th><th>Motivo</th><th>Estado</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach ($turnos as $t):
      $pac = $pacModel->find($t['paciente_id']);
      $pro = $proModel->find($t['profesional_id']);
      $pacName = $pac ? htmlspecialchars($pac['apellido'] . ' ' . $pac['nombre']) : 'ID:' . $t['paciente_id'];
      $proName = $pro ? htmlspecialchars($pro['apellido'] . ' ' . $pro['nombre']) : 'ID:' . $t['profesional_id'];
    ?>
      <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $pacName ?></td>
        <td><?= $proName ?></td>
        <td><?= $t['inicio'] ?></td>
        <td><?= $t['duracion_min'] ?></td>
        <td><?= htmlspecialchars($t['motivo']) ?></td>
        <td><?= htmlspecialchars($t['estado'] ?? '') ?></td>
        <td>
          <!-- Enlace rápido a ver la agenda diaria del profesional en la fecha del turno -->
          <a class="btn btn-sm btn-outline-primary" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime($t['inicio'])) ?>&profesional_id=<?= $t['profesional_id'] ?>">Ver agenda del profesional</a>
          <?php if (($t['estado'] ?? '') !== 'cancelado'): ?>
            <a class="btn btn-sm btn-warning" href="?r=turnos_cancel&id=<?= $t['id'] ?>" onclick="return confirm('Confirmar cancelación?')">Cancelar</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<p><a class="btn btn-primary" href="?">Volver al inicio</a></p>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';