<?php $pageTitle = 'Detalle del Turno'; ob_start(); ?>
<div class="d-flex align-items-center gap-2 mb-4">
    <a href="?r=turnos" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-arrow-left"></i></a>
    <h2 class="fw-bold mb-0">Turno #<?= $turno['id'] ?></h2>
    <?php 
        $est = $turno['estado'] ?? 'pendiente';
        $bCl = ($est == 'cancelado') ? 'bg-danger' : (($est == 'realizado') ? 'bg-success' : 'bg-warning text-dark');
    ?>
    <span class="badge <?= $bCl ?> ms-2"><?= strtoupper($est) ?></span>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-info-circle me-2"></i>Datos del Turno</h6></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted fw-normal">Paciente</dt> 
                    <dd class="col-7 fw-bold"><?= htmlspecialchars($paciente['apellido'] . ' ' . $paciente['nombre']) ?></dd>
                    <dt class="col-5 text-muted fw-normal">Médico</dt> 
                    <dd class="col-7"><?= htmlspecialchars($profesional['apellido'] . ' ' . $profesional['nombre']) ?></dd>
                    <dt class="col-5 text-muted fw-normal">Especialidad</dt>
                    <dd class="col-7 text-primary fw-bold"><?= htmlspecialchars($profesional['especialidad']) ?></dd>
                    <hr class="my-3 opacity-10">
                    <dt class="col-5 text-muted fw-normal">Fecha y Hora</dt> 
                    <dd class="col-7 fw-bold"><?= date('d/m/Y - H:i', strtotime($turno['inicio'])) ?> hs</dd>
                    <dt class="col-5 text-muted fw-normal">Duración</dt> 
                    <dd class="col-7"><?= $turno['duracion_min'] ?> minutos</dd>
                    <dt class="col-5 text-muted fw-normal">Motivo</dt> 
                    <dd class="col-7 italic">"<?= htmlspecialchars($turno['motivo'] ?? 'Sin observaciones') ?>"</dd>
                </dl>
                
                <div class="d-flex gap-2 mt-4">
                    <?php if ($est !== 'cancelado' && $est !== 'realizado'): ?>
                        <button class="btn btn-success btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalRealizar">
                            <i class="bi bi-check-circle me-1"></i> Realizar Consulta
                        </button>
                        <a href="?r=turnos_cancel&id=<?= $turno['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Cancelar?')">
                            <i class="bi bi-x-circle me-1"></i> Cancelar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm h-100 border-0 bg-light">
            <div class="card-header bg-white py-3"><h6 class="fw-bold mb-0"><i class="bi bi-journal-medical me-2"></i>Historial de la Consulta</h6></div>
            <div class="card-body">
                <?php if (isset($historial) && $historial): ?>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Diagnóstico</label>
                        <p class="fw-bold border-start border-primary border-3 ps-2"><?= nl2br(htmlspecialchars($historial['diagnostico'])) ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted d-block">Tratamiento</label>
                        <p class="text-secondary"><?= nl2br(htmlspecialchars($historial['tratamiento'])) ?></p>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="bi bi-clock-history fs-1 text-muted opacity-25"></i>
                        <p class="text-muted mt-2">Aún no se ha registrado la consulta.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRealizar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content shadow-lg border-0">
            <form method="POST" action="?r=turnos_realizar">
                <input type="hidden" name="id_turno" value="<?= $turno['id'] ?>">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Registrar Consulta</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label fw-bold small">DIAGNÓSTICO</label><textarea name="diagnostico" class="form-control" rows="3" required></textarea></div>
                    <div class="mb-3"><label class="form-label fw-bold small">TRATAMIENTO</label><textarea name="tratamiento" class="form-control" rows="3" required></textarea></div>
                </div>
                <div class="modal-footer bg-light"><button type="submit" class="btn btn-success px-4">Guardar y Finalizar</button></div>
            </form>
        </div>
    </div>
</div>
<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layout.php';