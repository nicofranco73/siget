<?php
// views/turnos/agenda_diaria.php
$title = 'Agenda diaria';
ob_start();

// $date, $turnos, $profesionales, $pacModel, $proModel deben estar definidos por el controlador
$date = $date ?? ($_GET['date'] ?? date('Y-m-d'));
?>
<h1>Agenda diaria - <?= htmlspecialchars($date) ?></h1>

<form method="get" class="mb-3">
  <input type="hidden" name="r" value="turnos_agenda_diaria">
  <div class="row g-2">
    <div class="col-auto">
      <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($date) ?>">
    </div>
    <div class="col-auto">
      <select name="profesional_id" class="form-select">
        <option value="">-- Todos los profesionales --</option>
        <?php foreach ($profesionales as $pr): ?>
          <option value="<?= $pr['id'] ?>" <?= (isset($_GET['profesional_id']) && $_GET['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($pr['apellido'] . ' ' . $pr['nombre'] . ' (' . $pr['especialidad'] . ')') ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-auto">
      <button class="btn btn-primary">Ver</button>
    </div>
    <div class="col-auto">
      <a class="btn btn-outline-secondary" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime('-1 day', strtotime($date))) ?>">Anterior</a>
      <a class="btn btn-outline-secondary" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime('+1 day', strtotime($date))) ?>">Siguiente</a>
    </div>
  </div>
</form>

<?php if (empty($turnos)): ?>
  <div class="alert alert-info">No hay turnos para la fecha seleccionada.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead><tr><th>Hora</th><th>Paciente</th><th>Profesional</th><th>Duración</th><th>Motivo</th><th>Estado</th><th>Acciones</th></tr></thead>
      <tbody>
      <?php
        foreach ($turnos as $t):
          $pac = $pacModel->find($t['paciente_id']);
          $pro = $proModel->find($t['profesional_id']);
          $pacName = $pac ? htmlspecialchars($pac['apellido'] . ' ' . $pac['nombre']) : 'ID:' . $t['paciente_id'];
          $proName = $pro ? htmlspecialchars($pro['apellido'] . ' ' . $pro['nombre']) : 'ID:' . $t['profesional_id'];
      ?>
        <tr>
          <td><?= date('H:i', strtotime($t['inicio'])) ?></td>
          <td><?= $pacName ?></td>
          <td><?= $proName ?></td>
          <td><?= $t['duracion_min'] ?> min</td>
          <td><?= htmlspecialchars($t['motivo']) ?></td>
          <td><?= htmlspecialchars($t['estado'] ?? '') ?></td>
          <td>
            <?php if (($t['estado'] ?? '') !== 'cancelado'): ?>
              <a class="btn btn-sm btn-warning" href="?r=turnos_cancel&id=<?= $t['id'] ?>" onclick="return confirm('Confirmar cancelación?')">Cancelar</a>
            <?php endif; ?>
            <a class="btn btn-sm btn-secondary" href="?r=turnos">Ver</a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';