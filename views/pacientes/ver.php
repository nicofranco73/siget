<?php
// views/pacientes/ver.php
?>

<div class="d-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center gap-3">
        <a href="?r=pacientes" class="btn btn-light border shadow-sm btn-sm">
            <i class="bi bi-arrow-left text-success"></i> Volver
        </a>
        <h2 class="fw-bold mb-0 text-capitalize" style="color: #2d8a6e;">
            <?= htmlspecialchars($paciente['apellido'] . ' ' . $paciente['nombre']) ?>
        </h2>
    </div>
    <a href="?r=pacientes_edit&id=<?= $paciente['id_paciente'] ?>" class="btn btn-outline-warning shadow-sm">
        <i class="bi bi-pencil me-1"></i> Editar Ficha
    </a>
</div>

<div class="row g-4">
    <!-- Columna Izquierda: Datos Personales -->
    <div class="col-md-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2 text-success">
                    <i class="bi bi-person-vcard me-2"></i>Datos personales
                </h6>
                <dl class="row mb-0">
                    <dt class="col-5 text-muted small">DNI</dt>
                    <dd class="col-7 text-success fw-bold"><?= htmlspecialchars($paciente['dni']) ?></dd>
                    
                    <dt class="col-5 text-muted small">Fecha nac.</dt>
                    <dd class="col-7 text-dark"><?= !empty($paciente['fecha_nac']) ? date('d/m/Y', strtotime($paciente['fecha_nac'])) : '—' ?></dd>
                    
                    <dt class="col-5 text-muted small">Teléfono</dt>
                    <dd class="col-7 text-dark"><?= htmlspecialchars($paciente['telefono'] ?? '—') ?></dd>
                    
                    <dt class="col-5 text-muted small">Email</dt>
                    <dd class="col-7 text-dark small text-lowercase"><?= htmlspecialchars($paciente['email'] ?? '—') ?></dd>
                    
                    <dt class="col-5 text-muted small">Obra social</dt>
                    <dd class="col-7 text-dark"><?= htmlspecialchars($paciente['obra_social'] ?? '—') ?></dd>
                    
                    <dt class="col-5 text-muted small">Nro. afiliado</dt>
                    <dd class="col-7 text-dark"><?= htmlspecialchars($paciente['nro_afiliado'] ?? '—') ?></dd>
                    
                    <dt class="col-5 text-muted small">Alta en sistema</dt>
                    <dd class="col-7 text-muted small"><?= date('d/m/Y H:i', strtotime($paciente['created_at'] ?? 'now')) ?></dd>
                </dl>
                
                <div class="mt-4 pt-3 border-top">
                    <a href="?r=turnos_create&id_paciente=<?= $paciente['id_paciente'] ?>" class="btn btn-success w-100 shadow-sm" style="background-color: #2d8a6e; border: none;">
                        <i class="bi bi-calendar-plus me-1"></i> Nuevo turno para este paciente
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Historial y Turnos -->
    <div class="col-md-7">
        <!-- Historial -->
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2 text-success">
                    <i class="bi bi-clock-history me-2"></i>Historial de consultas
                </h6>
                <?php if (empty($historial)): ?>
                    <p class="text-muted small italic m-0">Sin consultas registradas.</p>
                <?php else: ?>
                    <!-- Aquí iría el bucle de historial si existiera data -->
                <?php endif; ?>
            </div>
        </div>

        <!-- Turnos Proximos -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-3 border-bottom pb-2 text-success">
                    <i class="bi bi-calendar2-check me-2"></i>Turnos registrados
                </h6>
                <?php if (empty($turnos)): ?>
                    <p class="text-muted small italic m-0">Sin turnos pendientes.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr class="text-muted small">
                                    <th>Fecha</th>
                                    <th>Profesional</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($turnos as $t): ?>
                                    <tr>
                                        <td class="small"><?= date('d/m/Y H:i', strtotime($t['fecha_hora'])) ?></td>
                                        <td class="small fw-bold"><?= htmlspecialchars($t['medico']) ?></td>
                                        <td><span class="badge bg-info text-dark small" style="font-size: 0.7rem;">Pendiente</span></td>
                                        <td class="text-end">
                                            <a href="?r=turnos_view&id=<?= $t['id_turno'] ?>" class="btn btn-xs btn-light border py-0 px-1" style="font-size: 0.7rem;">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>