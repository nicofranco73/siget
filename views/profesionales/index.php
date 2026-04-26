<?php
// views/profesionales/index.php
$title = 'Profesionales';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="text-primary">
        <h1 class="fw-bold mb-0"><i class="bi bi-person-badge-fill me-2"></i>Gestión de Profesionales</h1>
        <p class="text-muted mb-0 small">Administración de la base de datos de profesionales médicos</p>
    </div>
    <?php if ($userRol === 'admin'): ?>
        <a class="btn btn-primary btn-lg shadow-sm px-4" href="?r=profesionales_create" style="background-color: #0d6efd; border: none;">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Profesional
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <?php if (empty($profesionales)): ?>
            <div class="p-5 text-center">
                <i class="bi bi-person-exclamation display-4 text-muted"></i>
                <p class="text-muted mt-3">No hay profesionales registrados en el sistema.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold">ID</th>
                            <th class="py-3 text-uppercase small fw-bold">Profesional</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Especialidad</th>
                            <th class="py-3 text-uppercase small fw-bold">Contacto</th>
                            <th class="text-center py-3 text-uppercase small fw-bold" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($profesionales as $pr): ?>
                        <tr>
                            <td class="ps-4 text-muted">#<?= $pr['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark fs-5"><?= htmlspecialchars($pr['apellido']) ?>, <?= htmlspecialchars($pr['nombre']) ?></div>
                                <div class="text-muted small">Matrícula: MN-<?= str_pad($pr['id'], 5, "0", STR_PAD_LEFT) ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-primary-subtle text-primary border border-primary-subtle px-3 py-2">
                                    <i class="bi bi-patch-check-fill me-1"></i>
                                    <?= htmlspecialchars($pr['especialidad'] ?? 'General') ?>
                                </span>
                            </td>
                            <td>
                                <div class="small mb-1 text-dark"><i class="bi bi-telephone me-2 text-muted"></i><?= htmlspecialchars($pr['telefono'] ?? 'S/T') ?></div>
                                <div class="small text-muted"><i class="bi bi-envelope me-2"></i><?= htmlspecialchars($pr['email'] ?? 'S/E') ?></div>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="?r=profesionales_view&id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-primary shadow-sm" title="Ver Ficha">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </a>
                                    <a href="?r=profesionales_edit&id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-warning shadow-sm" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="?r=profesionales_delete&id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-danger shadow-sm" 
                                       onclick="return confirm('¿Desea eliminar este profesional?')" title="Eliminar">
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
        <i class="bi bi-house-door-fill me-2 text-primary"></i>Panel Principal
    </a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';