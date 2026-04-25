<?php
$title = 'Agenda Semanal';
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-calendar3 me-2"></i>Agenda Semanal</h1>
    <a class="btn btn-outline-primary shadow-sm" href="?r=turnos"><i class="bi bi-list-ul me-1"></i> Lista General</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body bg-light">
        <form method="get" class="row g-2 justify-content-center">
            <input type="hidden" name="r" value="turnos_agenda_semanal">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control shadow-sm" value="<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>">
            </div>
            <div class="col-md-4">
                <select name="profesional_id" class="form-select shadow-sm">
                    <option value="">Todos los profesionales</option>
                    <?php foreach ($profesionales as $pr): ?>
                        <option value="<?= $pr['id'] ?>" <?= (isset($_GET['profesional_id']) && $_GET['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pr['apellido'].' '.$pr['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100 shadow-sm"><i class="bi bi-arrow-repeat"></i> Actualizar</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-bordered mb-0 border-light">
            <thead class="bg-primary text-white text-center">
                <tr>
                    <?php foreach (array_keys($days) as $d): 
                        $isToday = ($d == date('Y-m-d')) ? 'bg-warning text-dark border-bottom border-4 border-warning' : '';
                    ?>
                        <th width="14%" class="py-3 <?= $isToday ?>">
                            <div class="small fw-normal"><?= date('D', strtotime($d)) ?></div>
                            <div class="fs-5"><?= date('d/m', strtotime($d)) ?></div>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 400px;">
                    <?php foreach ($days as $d => $items): ?>
                        <td class="p-1 bg-white" style="vertical-align:top;">
                            <?php if (empty($items)): ?>
                                <div class="text-center mt-3 small text-muted opacity-50">Sin turnos</div>
                            <?php else: ?>
                                <?php foreach ($items as $t): ?>
                                    <div class="card mb-2 border-0 shadow-sm bg-light" style="font-size: 0.75rem;">
                                        <div class="card-body p-2 border-start border-3 <?= ($t['estado']=='cancelado') ? 'border-danger' : 'border-success' ?>">
                                            <div class="fw-bold text-primary"><?= date('H:i', strtotime($t['inicio'])) ?></div>
                                            <div class="text-truncate"><strong><?= htmlspecialchars($pacModel->find($t['paciente_id'])['apellido'] ?? 'ID:'.$t['paciente_id']) ?></strong></div>
                                            <div class="text-muted small"><?= htmlspecialchars($proModel->find($t['profesional_id'])['apellido'] ?? 'N/A') ?></div>
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
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';