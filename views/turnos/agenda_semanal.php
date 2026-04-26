<?php
// views/turnos/agenda_semanal.php
$title = 'Agenda Semanal';
ob_start();

// Mantenemos tus filtros actuales
$selectedDate = $_GET['date'] ?? date('Y-m-d');
$profesionalId = $_GET['profesional_id'] ?? '';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div style="color: #6f42c1;">
            <h1 class="fw-bold mb-0"><i class="bi bi-calendar3 me-2"></i>Agenda Semanal</h1>
            <p class="text-muted mb-0 small">Distribución de turnos por profesional y semana</p>
        </div>
        <a class="btn btn-outline-primary shadow-sm border-2 fw-bold" href="?r=turnos">
            <i class="bi bi-list-ul me-1"></i> Lista General
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4 bg-white">
        <div class="card-body p-3">
            <form method="get" class="row g-3 justify-content-center align-items-end">
                <input type="hidden" name="r" value="turnos_agenda_semanal">
                
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Semana del...</label>
                    <input type="date" name="date" class="form-control border-light-subtle shadow-sm" value="<?= htmlspecialchars($selectedDate) ?>">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Filtrar por Profesional</label>
                    <select name="profesional_id" class="form-select border-light-subtle shadow-sm">
                        <option value="">Todos los profesionales</option>
                        <?php foreach ($profesionales as $pr): ?>
                            <option value="<?= $pr['id'] ?>" <?= ($profesionalId == $pr['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($pr['apellido'].' '.$pr['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <button class="btn btn-primary w-100 shadow-sm fw-bold">
                        <i class="bi bi-arrow-repeat me-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 overflow-hidden rounded-3">
        <div class="table-responsive">
            <table class="table table-bordered mb-0 border-light-subtle">
                <thead class="text-white text-center" style="background-color: #6f42c1;">
                    <tr>
                        <?php 
                        $diasNombres = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
                        foreach (array_keys($days) as $d): 
                            $esHoy = ($d == date('Y-m-d'));
                            $timestamp = strtotime($d);
                        ?>
                            <th width="14.28%" class="py-3 border-0 <?= $esHoy ? 'bg-warning text-dark shadow-sm' : '' ?>" 
                                style="<?= $esHoy ? 'position: relative; z-index: 10;' : '' ?>">
                                <div class="small text-uppercase fw-bold opacity-75"><?= $diasNombres[date('w', $timestamp)] ?></div>
                                <div class="fs-4 fw-bold"><?= date('d/m', $timestamp) ?></div>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="bg-light">
                    <tr style="min-height: 500px;">
                        <?php foreach ($days as $d => $items): ?>
                            <td class="p-2 align-top bg-white border-light-subtle" style="min-width: 160px;">
                                <?php if (empty($items)): ?>
                                    <div class="text-center mt-4 small text-muted opacity-25 italic">Sin turnos</div>
                                <?php else: ?>
                                    <?php foreach ($items as $t): 
                                        $paciente = $pacModel->find($t['paciente_id']);
                                        $profesional = $proModel->find($t['profesional_id']);
                                        $esCancelado = ($t['estado'] == 'cancelado');
                                        $borderCol = $esCancelado ? '#dc3545' : '#6f42c1';
                                    ?>
                                        <div class="card mb-2 border-0 shadow-sm card-hover" style="font-size: 0.8rem;">
                                            <div class="card-body p-2 border-start border-4 rounded-start" style="border-color: <?= $borderCol ?> !important;">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <span class="fw-bold text-primary"><?= date('H:i', strtotime($t['inicio'])) ?> hs</span>
                                                    <?php if($esCancelado): ?>
                                                        <span class="badge bg-danger p-1" style="font-size: 0.6rem;">X</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="text-dark fw-bold text-truncate" title="<?= htmlspecialchars($paciente['apellido'] ?? 'N/A') ?>">
                                                    <?= htmlspecialchars($paciente['apellido'] ?? 'Paciente') ?>
                                                </div>
                                                <div class="text-muted small text-truncate">
                                                    Dr. <?= htmlspecialchars($profesional['apellido'] ?? 'N/A') ?>
                                                </div>
                                                <a href="?r=turnos_ver&id=<?= $t['id'] ?>" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .card-hover { transition: all 0.2s ease-in-out; }
    .card-hover:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.1) !important; 
        background-color: #f8f9ff;
    }
    .table-responsive::-webkit-scrollbar { height: 8px; }
    .table-responsive::-webkit-scrollbar-thumb { background: #6f42c1; border-radius: 10px; }
</style>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';