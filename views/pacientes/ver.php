<?php $pageTitle = 'Ficha de paciente'; ?>
<div class="d-flex align-items-center gap-2 mb-4">
  <a href="<?= url('pacientes') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
  <h2 class="fw-bold mb-0"><?= h($paciente['apellido'].' '.$paciente['nombre']) ?></h2>
  <a href="<?= url('pacientes','editar',['id'=>$paciente['id_paciente']]) ?>" class="btn btn-sm btn-outline-secondary ms-auto">
    <i class="bi bi-pencil me-1"></i>Editar
  </a>
</div>

<div class="row g-4">
  <!-- Datos personales -->
  <div class="col-md-5">
    <div class="siget-card h-100">
      <h6 class="fw-bold mb-3 border-bottom pb-2">Datos personales</h6>
      <dl class="row mb-0 small">
        <dt class="col-5 text-muted">DNI</dt>        <dd class="col-7"><code><?= h($paciente['dni']) ?></code></dd>
        <dt class="col-5 text-muted">Fecha nac.</dt> <dd class="col-7"><?= $paciente['fecha_nac'] ? fecha($paciente['fecha_nac']) : '—' ?></dd>
        <dt class="col-5 text-muted">Teléfono</dt>   <dd class="col-7"><?= h($paciente['telefono'] ?? '—') ?></dd>
        <dt class="col-5 text-muted">Email</dt>       <dd class="col-7"><?= h($paciente['email'] ?? '—') ?></dd>
        <dt class="col-5 text-muted">Obra social</dt><dd class="col-7"><?= h($paciente['obra_social'] ?? '—') ?></dd>
        <dt class="col-5 text-muted">Nro. afiliado</dt><dd class="col-7"><?= h($paciente['nro_afiliado'] ?? '—') ?></dd>
        <dt class="col-5 text-muted">Alta</dt>        <dd class="col-7"><?= fechaHora($paciente['creado_en']) ?></dd>
      </dl>
      <div class="mt-3">
        <a href="<?= url('turnos','crear') ?>?id_paciente=<?= $paciente['id_paciente'] ?>" class="btn btn-sm btn-teal w-100">
          <i class="bi bi-calendar-plus me-1"></i>Nuevo turno para este paciente
        </a>
      </div>
    </div>
  </div>

  <!-- Historial de consultas -->
  <div class="col-md-7">
    <div class="siget-card">
      <h6 class="fw-bold mb-3 border-bottom pb-2">Historial de consultas</h6>
      <?php if (empty($historial)): ?>
        <p class="text-muted small">Sin consultas registradas.</p>
      <?php else: ?>
        <?php foreach ($historial as $h_item): ?>
        <div class="border rounded p-3 mb-2 small">
          <div class="d-flex justify-content-between mb-1">
            <span class="fw-semibold"><?= h($h_item['especialidad']) ?></span>
            <span class="text-muted"><?= fechaHora($h_item['fecha_consulta']) ?></span>
          </div>
          <div class="text-muted mb-1">Profesional: <?= h($h_item['medico']) ?></div>
          <?php if ($h_item['diagnostico']): ?>
          <div><span class="fw-semibold">Diagnóstico:</span> <?= h($h_item['diagnostico']) ?></div>
          <?php endif; ?>
          <?php if ($h_item['tratamiento']): ?>
          <div><span class="fw-semibold">Tratamiento:</span> <?= h($h_item['tratamiento']) ?></div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Turnos del paciente -->
    <div class="siget-card mt-3">
      <h6 class="fw-bold mb-3 border-bottom pb-2">Turnos</h6>
      <?php if (empty($turnos)): ?>
        <p class="text-muted small">Sin turnos registrados.</p>
      <?php else: ?>
      <div class="table-responsive">
        <table class="table table-siget table-sm mb-0">
          <thead><tr><th>Fecha</th><th>Profesional</th><th>Estado</th><th></th></tr></thead>
          <tbody>
            <?php foreach ($turnos as $t): ?>
            <tr>
              <td><?= fechaHora($t['fecha_hora']) ?></td>
              <td><?= h($t['medico']) ?></td>
              <td><?= estadoBadge($t['estado']) ?></td>
              <td><a href="<?= url('turnos','ver',['id'=>$t['id_turno']]) ?>" class="btn btn-xs btn-outline-secondary btn-sm py-0 px-1" style="font-size:.75rem">Ver</a></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
