<?php
// views/turnos/agenda_diaria.php
$title = 'Agenda Diaria';
ob_start();

// Lógica de fecha (manteniendo tu estructura)
$date = $date ?? ($_GET['date'] ?? date('Y-m-d'));
$profesional_id_filtro = $_GET['profesional_id'] ?? '';
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div style="color: #6f42c1;">
            <h1 class="fw-bold mb-0">
                <i class="bi bi-calendar-check-fill me-2"></i>
                Agenda: <?= date('d/m/Y', strtotime($date)) ?>
            </h1>
            <p class="text-muted mb-0 small">Visualización y filtrado de turnos diarios</p>
        </div>
        
        <div class="btn-group shadow-sm">
            <a class="btn btn-white border" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime('-1 day', strtotime($date))) ?>">
                <i class="bi bi-chevron-left"></i>
            </a>
            <a class="btn btn-white border fw-bold" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d') ?>">
                Hoy
            </a>
            <a class="btn btn-white border" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime('+1 day', strtotime($date))) ?>">
                <i class="bi bi-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-3">
            <form method="get" class="row g-3 align-items-end">
                <input type="hidden" name="r" value="turnos_agenda_diaria">
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Fecha de Consulta</label>
                    <input type="date" name="date" class="form-control border-light-subtle" value="<?= $date ?>">
                </div>
                
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-muted text-uppercase">Médico / Profesional</label>
                    <select name="profesional_id" class="form-select border-light-subtle">
                        <option value="">Todos los profesionales</option>
                        <?php foreach ($profesionales as $pr): ?>
                            <option value="<?= $pr['id'] ?>" <?= ($profesional_id_filtro == $pr['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pr['apellido'] . ' ' . $pr['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                </div>

                <div class="col-md-2 text-end">
                     <a href="?r=turnos_create" class="btn text-white w-100 shadow-sm" style="background-color: #6f42c1;">
                        <i class="bi bi-plus-lg"></i> Nuevo
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <?php if (empty($turnos)): ?>
                <div class="p-5 text-center">
                    <i class="bi bi-calendar-x fs-1 text-muted opacity-25"></i>
                    <p class="mt-3 text-muted">No se encontraron turnos para los criterios seleccionados.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-uppercase text-muted">
                                <th class="ps-4 py-3" style="width: 130px;">Horario</th>
                                <th class="py-3">Paciente</th>
                                <th class="py-3">Médico Responsable</th>
                                <th class="py-3 text-center">Estado</th>
                                <th class="text-end pe-4 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($turnos as $t): 
                            $paciente = $pacModel->find($t['paciente_id']);
                            $profesional = $proModel->find($t['profesional_id']);
                            $estado = $t['estado'] ?? 'pendiente';
                            
                            // Estilo dinámico de badges
                            $badgeClass = ($estado == 'cancelado') ? 'bg-danger-subtle text-danger border-danger-subtle' : 
                                         (($estado == 'realizado') ? 'bg-success-subtle text-success border-success-subtle' : 
                                         'bg-primary-subtle text-primary border-primary-subtle');
                        ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="badge bg-light text-primary border border-primary-subtle fs-6 px-3 py-2 fw-bold">
                                        <i class="bi bi-clock me-1"></i> <?= date('H:i', strtotime($t['inicio'])) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark"><?= htmlspecialchars($paciente['apellido'] . ' ' . $paciente['nombre'] ?? 'Desconocido') ?></div>
                                    <div class="text-muted small">DNI: <?= htmlspecialchars($paciente['dni'] ?? 'N/A') ?></div>
                                </td>
                                <td>
                                    <div class="text-dark"><small class="text-muted">Dr.</small> <?= htmlspecialchars($profesional['apellido'] ?? 'N/A') ?></div>
                                    <div class="small text-muted italic" style="font-size: 0.75rem;"><?= htmlspecialchars($profesional['especialidad'] ?? '') ?></div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill border px-3 <?= $badgeClass ?>">
                                        <?= strtoupper($estado) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a class="btn btn-sm btn-outline-primary shadow-sm px-3" href="?r=turnos_ver&id=<?= $t['id'] ?>">
                                        <i class="bi bi-eye-fill"></i> Detalle
                                    </a>
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

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';