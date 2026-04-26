<?php
// views/home.php - Dashboard Profesional unificado
$title = 'Panel de Control - SIGET';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();
?>

<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm text-white" style="background: linear-gradient(45deg, #4e73df, #224abe); border-radius: 15px;">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold mb-1">¡Hola, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>!</h1>
                        <p class="mb-0 opacity-75">Bienvenido al Panel de Gestión del SIGET. Aquí tienes el resumen de hoy.</p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="bi bi-clock-history fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if ($userRol !== 'paciente'): ?>
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-success fw-bold text-uppercase small mb-1">Total Pacientes</div>
                            <div class="h3 fw-bold mb-0"><?= $pacientesCount ?></div>
                        </div>
                        <i class="bi bi-people-fill fs-1 text-success opacity-25"></i>
                    </div>
                    <a href="?r=pacientes" class="stretched-link text-decoration-none"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-primary fw-bold text-uppercase small mb-1">Profesionales</div>
                            <div class="h3 fw-bold mb-0"><?= $profesionalesCount ?></div>
                        </div>
                        <i class="bi bi-person-badge-fill fs-1 text-primary opacity-25"></i>
                    </div>
                    <a href="?r=profesionales" class="stretched-link text-decoration-none"></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 border-start border-4" style="border-color: #6f42c1 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="color: #6f42c1;" class="fw-bold text-uppercase small mb-1">Turnos Registrados</div>
                            <div class="h3 fw-bold mb-0"><?= $turnosCount ?></div>
                        </div>
                        <i class="bi bi-calendar-check-fill fs-1 opacity-25" style="color: #6f42c1;"></i>
                    </div>
                    <a href="?r=turnos" class="stretched-link text-decoration-none"></a>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-list-stars me-2 text-primary"></i>Actividad Reciente</h5>
                    <a href="?r=turnos" class="btn btn-sm btn-light border small">Ver todo</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr class="small text-uppercase text-muted">
                                    <th class="ps-4">Paciente</th>
                                    <th>Profesional</th>
                                    <th>Fecha</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recentTurnos)): ?>
                                    <tr><td colspan="4" class="text-center p-4 text-muted">No hay actividad reciente.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($recentTurnos as $t): 
                                        $pac = $pacModel->find($t['paciente_id']);
                                        $pro = $proModel->find($t['profesional_id']);
                                        $estado = $t['estado'] ?? 'pendiente';
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?= htmlspecialchars($pac['apellido'] ?? 'N/A') ?></td>
                                        <td class="text-muted small"><?= htmlspecialchars($pro['apellido'] ?? 'N/A') ?></td>
                                        <td class="small"><?= date('d/m H:i', strtotime($t['inicio'])) ?> hs</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill <?= ($estado == 'cancelado') ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' ?> small px-2">
                                                <?= strtoupper($estado) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-lightning-charge-fill me-2 text-warning"></i>Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="?r=turnos_create" class="btn btn-lg py-3 shadow-sm d-flex align-items-center justify-content-center" style="background-color: #6f42c1; color: white; border: none; border-radius: 12px;">
                            <i class="bi bi-calendar-plus-fill me-2 fs-4"></i> Nuevo Turno
                        </a>
                        <a href="?r=pacientes_create" class="btn btn-lg btn-success py-3 shadow-sm d-flex align-items-center justify-content-center" style="border-radius: 12px;">
                            <i class="bi bi-person-plus-fill me-2 fs-4"></i> Alta Paciente
                        </a>
                        <a href="?r=turnos_agenda_diaria" class="btn btn-lg btn-outline-primary py-3 d-flex align-items-center justify-content-center" style="border-radius: 12px;">
                            <i class="bi bi-calendar3 me-2 fs-4"></i> Ver Agenda Diaria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';