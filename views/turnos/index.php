<?php
$title = 'Gestión de Turnos';
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-calendar-event me-2"></i>Turnos</h1>
    <a class="btn btn-primary shadow-sm" href="?r=turnos_create">
        <i class="bi bi-plus-circle me-1"></i> Nuevo Turno
    </a>
</div>

<div class="card shadow-sm mb-4 bg-light">
    <div class="card-body">
        <form method="get" class="row g-2 align-items-end">
            <input type="hidden" name="r" value="turnos_agenda_diaria">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Fecha</label>
                <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>">
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Profesional</label>
                <select name="profesional_id" class="form-select">
                    <option value="">-- Todos --</option>
                    <?php foreach ($profesionales as $pr): ?>
                        <option value="<?= $pr['id'] ?>" <?= (isset($_GET['profesional_id']) && $_GET['profesional_id']==$pr['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($pr['apellido'] . ' ' . $pr['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary w-100"><i class="bi bi-search me-1"></i> Agenda Diaria</button>
                    <a class="btn btn-outline-secondary w-100" href="?r=turnos_agenda_semanal&date=<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>&profesional_id=<?= urlencode($_GET['profesional_id'] ?? '') ?>">
                        <i class="bi bi-calendar3 me-1"></i> Semanal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($turnos)): ?>
            <div class="p-5 text-center text-muted">No hay turnos registrados.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Paciente</th>
                            <th>Profesional</th>
                            <th>Fecha/Hora</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($turnos as $t): 
                        $estado = $t['estado'] ?? 'pendiente';
                        $badgeClass = ($estado == 'cancelado') ? 'bg-danger' : (($estado == 'realizado') ? 'bg-success' : 'bg-warning text-dark');
                        
                        // Obtener datos para evitar errores de N/A
                        $pData = $pacModel->find($t['paciente_id']);
                        $prData = $proModel->find($t['profesional_id']);
                    ?>
                        <tr>
                            <td class="ps-4 fw-bold"><?= htmlspecialchars(($pData['apellido'] ?? '') . ' ' . ($pData['nombre'] ?? '')) ?: 'N/A' ?></td>
                            <td><?= htmlspecialchars(($prData['apellido'] ?? '') . ' ' . ($prData['nombre'] ?? '')) ?: 'N/A' ?></td>
                            <td>
                                <?php 
                                    // SOLUCIÓN AL ERROR DE strtotime(null)
                                    if (!empty($t['inicio']) && $t['inicio'] !== '0000-00-00 00:00:00') {
                                        echo date('d/m/Y H:i', strtotime($t['inicio'])) . ' hs';
                                    } else {
                                        echo '<span class="text-danger small"><i class="bi bi-exclamation-triangle"></i> Sin fecha</span>';
                                    }
                                ?>
                            </td>
                            <td><span class="badge <?= $badgeClass ?>"><?= strtoupper($estado) ?></span></td>
                            <td class="text-end pe-4">
                                <a title="Ver detalle" class="btn btn-sm btn-outline-info" href="?r=turnos_ver&id=<?= $t['id'] ?>"><i class="bi bi-eye"></i></a>
                                <?php if ($estado !== 'cancelado'): ?>
                                    <a title="Cancelar" class="btn btn-sm btn-outline-danger" href="?r=turnos_cancel&id=<?= $t['id'] ?>" onclick="return confirm('¿Cancelar turno?')"><i class="bi bi-x-circle"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';