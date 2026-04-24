<?php
// views/turnos/agenda_semanal.php
$title = 'Agenda semanal';
ob_start();

// $days (array date => items), $profesionales, $pacModel, $proModel deben venir del controlador
?>
<h1>Agenda semanal</h1>

<form method="get" class="mb-3">
  <input type="hidden" name="r" value="turnos_agenda_semanal">
  <div class="row g-2">
    <div class="col-auto">
      <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>">
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
      <button class="btn btn-primary">Ver semana</button>
    </div>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <?php foreach (array_keys($days) as $d): ?>
          <th><?= date('D d/m', strtotime($d)) ?></th>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php foreach ($days as $d => $items): ?>
          <td style="vertical-align:top;">
            <?php if (empty($items)): ?>
              <div class="text-muted small">No hay turnos</div>
            <?php else: ?>
              <?php foreach ($items as $t):
                $pac = $pacModel->find($t['paciente_id']);
                $pacName = $pac ? htmlspecialchars($pac['apellido'] . ' ' . $pac['nombre']) : 'ID:' . $t['paciente_id'];
                $pro = $proModel->find($t['profesional_id']);
                $proName = $pro ? htmlspecialchars($pro['apellido'] . ' ' . $pro['nombre']) : 'ID:' . $t['profesional_id'];
              ?>
                <div class="mb-2 p-1 border rounded">
                  <strong><?= date('H:i', strtotime($t['inicio'])) ?></strong> — <?= $pacName ?><br>
                  <small><?= $proName ?> — <?= $t['duracion_min'] ?> min — <?= htmlspecialchars($t['estado'] ?? '') ?></small>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
        <?php endforeach; ?>
      </tr>
    </tbody>
  </table>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';