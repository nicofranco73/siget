<?php $pageTitle = 'Detalle del turno'; ?>
<div class="d-flex align-items-center gap-2 mb-4">
  <a href="<?= url('turnos') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i></a>
  <h2 class="fw-bold mb-0">Turno #<?= $turno['id_turno'] ?></h2>
  <span class="ms-2"><?= estadoBadge($turno['estado']) ?></span>
</div>

<div class="row g-4">
  <div class="col-md-6">
    <div class="siget-card">
      <h6 class="fw-bold border-bottom pb-2 mb-3">Datos del turno</h6>
      <dl class="row small mb-0">
        <dt class="col-5 text-muted">Paciente</dt>    <dd class="col-7 fw-semibold"><?= h($turno['paciente']) ?></dd>
        <dt class="col-5 text-muted">Profesional</dt> <dd class="col-7"><?= h($turno['medico']) ?></dd>
        <dt class="col-5 text-muted">Especialidad</dt><dd class="col-7"><?= h($turno['especialidad']) ?></dd>
        <dt class="col-5 text-muted">Sala</dt>        <dd class="col-7"><?= h($turno['sala']) ?></dd>
        <dt class="col-5 text-muted">Fecha/Hora</dt>  <dd class="col-7"><?= fechaHora($turno['fecha_hora']) ?></dd>
        <dt class="col-5 text-muted">Duración</dt>    <dd class="col-7"><?= $turno['duracion_min'] ?> min</dd>
        <dt class="col-5 text-muted">Motivo</dt>      <dd class="col-7"><?= h($turno['observaciones'] ?? '—') ?></dd>
        <dt class="col-5 text-muted">Registrado</dt>  <dd class="col-7"><?= fechaHora($turno['creado_en']) ?></dd>
      </dl>

      <div class="d-flex gap-2 mt-4 flex-wrap">
        <?php if ($turno['estado'] === 'agendado'): ?>
        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalRealizar">
          <i class="bi bi-check-circle me-1"></i>Marcar como realizado
        </button>
        <a href="<?= url('turnos','cancelar',['id'=>$turno['id_turno']]) ?>"
           class="btn btn-warning btn-sm"
           onclick="return confirm('¿Cancelar este turno?')">
          <i class="bi bi-x-circle me-1"></i>Cancelar turno
        </a>
        <?php endif; ?>
        <a href="<?= url('pacientes','ver',['id'=>$turno['id_paciente']]) ?>" class="btn btn-outline-primary btn-sm">
          <i class="bi bi-person me-1"></i>Ver paciente
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="siget-card">
      <h6 class="fw-bold border-bottom pb-2 mb-3">Historial clínico</h6>
      <?php if ($historial): ?>
        <dl class="row small mb-0">
          <dt class="col-4 text-muted">Fecha</dt>       <dd class="col-8"><?= fechaHora($historial['fecha_consulta']) ?></dd>
          <dt class="col-4 text-muted">Diagnóstico</dt> <dd class="col-8"><?= h($historial['diagnostico'] ?? '—') ?></dd>
          <dt class="col-4 text-muted">Tratamiento</dt> <dd class="col-8"><?= h($historial['tratamiento'] ?? '—') ?></dd>
          <dt class="col-4 text-muted">Notas</dt>       <dd class="col-8"><?= h($historial['observaciones'] ?? '—') ?></dd>
        </dl>
      <?php else: ?>
        <p class="text-muted small">
          <?= $turno['estado']==='agendado' ? 'El turno aún no fue realizado.' : 'Sin registro clínico.' ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Modal: marcar realizado -->
<?php if ($turno['estado'] === 'agendado'): ?>
<div class="modal fade" id="modalRealizar" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="<?= url('turnos','realizar') ?>">
        <input type="hidden" name="id_turno" value="<?= $turno['id_turno'] ?>">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Registrar consulta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Diagnóstico</label>
            <textarea name="diagnostico" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Tratamiento</label>
            <textarea name="tratamiento" class="form-control" rows="2"></textarea>
          </div>
          <div class="mb-0">
            <label class="form-label fw-semibold">Observaciones adicionales</label>
            <textarea name="obs_historial" class="form-control" rows="2"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Confirmar y guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php endif; ?>
