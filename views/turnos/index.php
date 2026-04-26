<?php
// views/turnos/index.php
$title = 'Gestión de Turnos';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div style="color: #6f42c1;">
        <h1 class="fw-bold mb-0"><i class="bi bi-calendar-event-fill me-2"></i>Gestión de Turnos</h1>
        <p class="text-muted mb-0 small">Administración de citas y agenda médica</p>
    </div>
    <a class="btn btn-lg shadow-sm px-4 text-white" href="?r=turnos_create" style="background-color: #6f42c1; border: none;">
        <i class="bi bi-plus-circle me-1"></i> Nuevo Turno
    </a>
</div>

<div class="card shadow-sm border-0 mb-4 bg-white">
    <div class="card-body p-4">
        <form method="get" class="row g-3 align-items-end">
            <input type="hidden" name="r" value="turnos_agenda_diaria">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-uppercase text-muted">Fecha de Consulta</label>
                <input type="date" name="date" class="form-control border-primary-subtle" style="border-color: #e0d0ff !important;" value="<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold text-uppercase text-muted">Profesional</label>
                <select name="profesional_id" class="form-select border-primary-subtle" style="border-color: #e0d0ff !important;">
                    <option value="">-- Todos los Médicos --</option>
                    <?php foreach ($profesionales as $pr): ?>
                        <option value="<?= $pr['id'] ?>" <?= (isset($_GET['profesional_id']) && $_GET['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pr['apellido'] . ' ' . $pr['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <div class="d-flex gap-2">
                    <button class="btn text-white w-100 shadow-sm" style="background-color: #6f42c1;">
                        <i class="bi bi-search me-1"></i> Ver Agenda Diaria
                    </button>
                    <a class="btn btn-outline-secondary w-100 shadow-sm" href="?r=turnos_agenda_semanal&date=<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>&profesional_id=<?= urlencode($_GET['profesional_id'] ?? '') ?>">
                        <i class="bi bi-calendar3 me-1"></i> Vista Semanal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <?php if (empty($turnos)): ?>
            <div class="p-5 text-center text-muted">
                <i class="bi bi-calendar-x display-4"></i>
                <p class="mt-3">No hay turnos registrados para los criterios seleccionados.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">Paciente</th>
                            <th class="py-3 text-uppercase small fw-bold">Profesional</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Fecha y Hora</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Estado</th>
                            <th class="text-center py-3 text-uppercase small fw-bold" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($turnos as $t): 
                        $estado = $t['estado'] ?? 'pendiente';
                        $badgeStyle = ($estado == 'cancelado') ? 'bg-danger-subtle text-danger border-danger-subtle' : 
                                     (($estado == 'realizado') ? 'bg-success-subtle text-success border-success-subtle' : 
                                     'bg-warning-subtle text-dark border-warning-subtle');
                        
                        $pData = $pacModel->find($t['paciente_id']);
                        $prData = $proModel->find($t['profesional_id']);
                    ?>
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark fs-6"><?= htmlspecialchars(($pData['apellido'] ?? '') . ' ' . ($pData['nombre'] ?? '')) ?: 'N/A' ?></div>
                                <div class="text-muted small">DNI: <?= htmlspecialchars($pData['dni'] ?? 'S/D') ?></div>
                            </td>
                            <td>
                                <div class="text-dark small"><i class="bi bi-person-md me-1"></i>Dr. <?= htmlspecialchars(($prData['apellido'] ?? '') . ' ' . ($prData['nombre'] ?? '')) ?: 'N/A' ?></div>
                            </td>
                            <td class="text-center">
                                <div class="badge bg-light text-dark border px-3 py-2">
                                    <i class="bi bi-clock me-1 text-primary"></i>
                                    <?php 
                                        if (!empty($t['inicio']) && $t['inicio'] !== '0000-00-00 00:00:00') {
                                            echo date('d/m/Y H:i', strtotime($t['inicio'])) . ' hs';
                                        } else {
                                            echo '<span class="text-danger">Sin fecha</span>';
                                        }
                                    ?>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill border px-3 <?= $badgeStyle ?>">
                                    <?= strtoupper($estado) ?>
                                </span>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="?r=turnos_ver&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary shadow-sm" title="Ver Detalle">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <?php if ($estado !== 'cancelado'): ?>
                                        <a href="?r=turnos_cancel&id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger shadow-sm" 
                                           onclick="return confirm('¿Cancelar turno?')" title="Cancelar">
                                            <i class="bi bi-x-lg"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="d-flex justify-content-start">
    <a class="btn btn-light border shadow-sm px-4" href="?">
        <i class="bi bi-house-door-fill me-2" style="color: #6f42c1;"></i>Panel Principal
    </a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';