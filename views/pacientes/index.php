<?php
// views/pacientes/index.php
$title = 'Pacientes';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="text-success">
        <h1 class="fw-bold mb-0"><i class="bi bi-people-fill me-2"></i>Gestión de Pacientes</h1>
        <p class="text-muted mb-0 small">Administración de la base de datos de pacientes</p>
    </div>
    <?php if ($userRol === 'admin'): ?>
        <a class="btn btn-success btn-lg shadow-sm px-4" href="?r=pacientes_create">
            <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <?php if (empty($pacientes)): ?>
            <div class="p-5 text-center">
                <i class="bi bi-person-exclamation display-4 text-muted"></i>
                <p class="text-muted mt-3">No hay pacientes registrados en el sistema.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">ID</th>
                            <th class="py-3 text-uppercase small fw-bold">Paciente</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">DNI / Documento</th>
                            <th class="py-3 text-uppercase small fw-bold">Contacto</th>
                            <th class="text-center py-3 text-uppercase small fw-bold" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pacientes as $pa): ?>
                        <tr>
                            <td class="ps-4 text-muted">#<?= $pa['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark fs-5 text-capitalize"><?= htmlspecialchars($pa['apellido']) ?>, <?= htmlspecialchars($pa['nombre']) ?></div>
                                <div class="text-muted small">Registrado: <?= date('d/m/Y', strtotime($pa['created_at'] ?? 'now')) ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3 py-2">
                                    <i class="bi bi-card-text me-1"></i>
                                    <?= htmlspecialchars($pa['dni'] ?? 'Sin DNI') ?>
                                </span>
                            </td>
                            <td>
                                <div class="small mb-1 text-dark"><i class="bi bi-telephone me-2 text-muted"></i><?= htmlspecialchars($pa['telefono'] ?? 'S/T') ?></div>
                                <div class="small text-muted"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($pa['email'] ?? 'S/E') ?></div>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="?r=pacientes_view&id=<?= $pa['id'] ?>" class="btn btn-sm btn-outline-success shadow-sm" title="Ver Ficha">
                                        <i class="bi bi-file-earmark-person"></i>
                                    </a>
                                    <a href="?r=pacientes_edit&id=<?= $pa['id'] ?>" class="btn btn-sm btn-outline-warning shadow-sm" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="?r=pacientes_delete&id=<?= $pa['id'] ?>" class="btn btn-sm btn-outline-danger shadow-sm" 
                                       onclick="return confirm('¿Realmente desea eliminar este paciente?')" title="Eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </a>
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
        <i class="bi bi-house-door-fill me-2 text-success"></i>Panel Principal
    </a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';