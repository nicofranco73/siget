<?php
$title = 'Agenda Diaria';
ob_start();
$date = $date ?? ($_GET['date'] ?? date('Y-m-d'));
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-calendar-day me-2"></i>Agenda: <?= date('d/m/Y', strtotime($date)) ?></h1>
    <div class="btn-group shadow-sm">
        <a class="btn btn-outline-secondary" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime('-1 day', strtotime($date))) ?>"><i class="bi bi-chevron-left"></i></a>
        <a class="btn btn-outline-secondary" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d') ?>">Hoy</a>
        <a class="btn btn-outline-secondary" href="?r=turnos_agenda_diaria&date=<?= date('Y-m-d', strtotime('+1 day', strtotime($date))) ?>"><i class="bi bi-chevron-right"></i></a>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body bg-light rounded">
        <form method="get" class="row g-2">
            <input type="hidden" name="r" value="turnos_agenda_diaria">
            <div class="col-md-4">
                <input type="date" name="date" class="form-control" value="<?= $date ?>">
            </div>
            <div class="col-md-6">
                <select name="profesional_id" class="form-select">
                    <option value="">Todos los profesionales</option>
                    <?php foreach ($profesionales as $pr): ?>
                        <option value="<?= $pr['id'] ?>" <?= (isset($_GET['profesional_id']) && $_GET['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pr['apellido'].' '.$pr['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($turnos)): ?>
            <div class="p-5 text-center"><i class="bi bi-info-circle fs-2 text-muted"></i><p class="mt-2 text-muted">No hay turnos para este día.</p></div>
        <?php else: ?>
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-white">
                    <tr>
                        <th class="ps-4">Hora</th>
                        <th>Paciente</th>
                        <th>Médico</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($turnos as $t): ?>
                    <tr>
                        <td class="ps-4 fw-bold fs-5 text-primary"><?= date('H:i', strtotime($t['inicio'])) ?></td>
                        <td><?= htmlspecialchars($pacModel->find($t['paciente_id'])['apellido'] ?? 'Desconocido') ?></td>
                        <td><small class="text-muted">Dr. </small><?= htmlspecialchars($proModel->find($t['profesional_id'])['apellido'] ?? 'N/A') ?></td>
                        <td><span class="badge bg-opacity-10 text-dark border <?= ($t['estado']=='cancelado') ? 'bg-danger border-danger' : 'bg-success border-success' ?>"><?= strtoupper($t['estado'] ?? 'PENTIENTE') ?></span></td>
                        <td class="text-end pe-4">
                             <a class="btn btn-sm btn-outline-primary" href="?r=turnos_ver&id=<?= $t['id'] ?>"><i class="bi bi-eye"></i> Detalle</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';