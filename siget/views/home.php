<?php
// views/home.php - dashboard mejorado y protegido
$title = 'Inicio - SIGET';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();

$pacientesCount = $pacientesCount ?? 0;
$profesionalesCount = $profesionalesCount ?? 0;
$turnosCount = $turnosCount ?? 0;
$recentTurnos = $recentTurnos ?? [];

if (!isset($pacModel)) {
    require_once __DIR__ . '/../models/Paciente.php';
    $pacModel = new Paciente();
}
if (!isset($proModel)) {
    require_once __DIR__ . '/../models/Profesional.php';
    $proModel = new Profesional();
}
?>
<div class="container">
  <div class="py-4">
    <div class="welcome-card p-4 rounded shadow-sm mb-4">
      <h1 class="h2 mb-1">Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></h1>
      <p class="text-muted mb-0">Panel de resumen del Sistema de Gestión de Turnos</p>
    </div>

    <?php if ($userRol !== 'paciente'): ?>
    <div class="row gx-3 gy-3 mb-4">
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h6 class="text-muted">Pacientes</h6>
            <p class="display-6 my-2 fw-bold"><?= intval($pacientesCount) ?></p>
            <a class="btn btn-outline-primary btn-sm" href="?r=pacientes"><i class="bi bi-people-fill me-1"></i> Ver pacientes</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h6 class="text-muted">Profesionales</h6>
            <p class="display-6 my-2 fw-bold"><?= intval($profesionalesCount) ?></p>
            <a class="btn btn-outline-primary btn-sm" href="?r=profesionales"><i class="bi bi-person-badge-fill me-1"></i> Ver profesionales</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body text-center">
            <h6 class="text-muted">Turnos totales</h6>
            <p class="display-6 my-2 fw-bold"><?= intval($turnosCount) ?></p>
            <a class="btn btn-outline-primary btn-sm" href="?r=turnos"><i class="bi bi-calendar-check-fill me-1"></i> Ver turnos</a>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-<?= ($userRol === 'paciente') ? '12' : '6' ?> mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-header d-flex justify-content-between align-items-center">
            <strong><?= ($userRol === 'paciente') ? 'Mis próximos turnos' : 'Próximos turnos en sistema' ?></strong>
            <?php if ($userRol !== 'paciente'): ?>
            <a class="btn btn-sm btn-link" href="?r=turnos_agenda_diaria"><i class="bi bi-clock-history"></i> Ver agenda</a>
            <?php endif; ?>
          </div>
          <div class="card-body">
            <?php if (empty($recentTurnos)): ?>
              <div class="text-muted p-4 text-center">No hay turnos registrados.</div>
            <?php else: ?>
              <ul class="list-unstyled mb-0">
                <?php foreach ($recentTurnos as $t):
                  $pac = $pacModel->find($t['paciente_id']);
                  $pro = $proModel->find($t['profesional_id']);
                  $pacName = $pac ? htmlspecialchars($pac['apellido'] . ' ' . $pac['nombre']) : 'Paciente #' . $t['paciente_id'];
                  $proName = $pro ? htmlspecialchars($pro['apellido'] . ' ' . $pro['nombre']) : 'Profesional #' . $t['profesional_id'];
                  $time = (!empty($t['inicio'])) ? date('d/m H:i', strtotime($t['inicio'])) : 'Sin fecha';
                  $estado = $t['estado'] ?? 'agendado';
                ?>
                <li class="py-2 border-bottom d-flex justify-content-between align-items-start">
                  <div>
                    <div class="fw-semibold"><?= $pacName ?> <small class="text-muted">— <?= $proName ?></small></div>
                    <div class="text-muted small"><?= !empty($t['motivo']) ? htmlspecialchars($t['motivo']) : 'Sin motivo' ?></div>
                    <div class="text-muted small"><?= $time ?></div>
                  </div>
                  <div class="text-end">
                    <span class="badge <?= ($estado === 'cancelado') ? 'bg-secondary' : (($estado === 'atendido') ? 'bg-success' : 'bg-info text-dark') ?>">
                        <?= ucfirst($estado) ?>
                    </span>
                  </div>
                </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <?php if ($userRol !== 'paciente'): ?>
      <div class="col-lg-6 mb-3">
        <div class="card shadow-sm h-100">
          <div class="card-header"><strong>Accesos rápidos administrativos</strong></div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <a class="btn btn-primary" href="?r=turnos_create"><i class="bi bi-plus-circle me-1"></i> Nuevo turno</a>
              <a class="btn btn-outline-secondary" href="?r=turnos_agenda_diaria"><i class="bi bi-calendar3 me-1"></i> Agenda diaria</a>
              <a class="btn btn-outline-secondary" href="?r=turnos_agenda_semanal"><i class="bi bi-calendar-week me-1"></i> Agenda semanal</a>
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';