<?php
// views/pacientes/index.php
$title = 'Gestión de Pacientes';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="fw-bold text-dark h3 mb-0">Pacientes</h1>
        <p class="text-muted small">Administración de la base de datos de pacientes</p>
    </div>
    <?php if ($userRol === 'admin' || $userRol === 'staff'): ?>
    <a class="btn btn-accent shadow-sm" href="?r=pacientes_create">
        <i class="bi bi-person-plus-fill me-1"></i> Nuevo Paciente
    </a>
    <?php endif; ?>
</div>

<?php if (!empty($_GET['msg'])): ?>
    <?php if ($_GET['msg'] === 'created'): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> Paciente registrado con éxito.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($_GET['msg'] === 'deleted'): ?>
        <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-trash-fill me-2"></i> Registro eliminado correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <?php if (empty($pacientes)): ?>
            <div class="p-5 text-center">
                <i class="bi bi-people text-light display-1"></i>
                <p class="text-muted mt-3">No hay pacientes registrados en el sistema.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Paciente</th>
                            <th>DNI</th>
                            <th>Contacto</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($pacientes as $p): ?>
                        <tr>
                            <td class="ps-4 text-muted small">#<?= $p['id'] ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= htmlspecialchars($p['apellido']) ?>, <?= htmlspecialchars($p['nombre']) ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border fw-normal"><?= htmlspecialchars($p['dni']) ?></span></td>
                            <td>
                                <div class="small"><i class="bi bi-telephone text-muted me-1"></i> <?= htmlspecialchars($p['telefono'] ?? '-') ?></div>
                                <div class="small text-muted"><i class="bi bi-envelope text-muted me-1"></i> <?= htmlspecialchars($p['email'] ?? '-') ?></div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group shadow-sm border rounded">
                                    <a href="?r=historial&id_paciente=<?= $p['id'] ?>" class="btn btn-sm btn-white text-primary" title="Ver Historial Clínico">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </a>
                                    
                                    <?php if ($userRol === 'admin' || $userRol === 'staff'): ?>
                                    <a href="?r=pacientes_edit&id=<?= $p['id'] ?>" class="btn btn-sm btn-white text-warning" title="Editar datos">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <?php endif; ?>

                                    <?php if ($userRol === 'admin'): ?>
                                    <button onclick="confirmarEliminar(<?= $p['id'] ?>)" class="btn btn-sm btn-white text-danger" title="Eliminar paciente">
                                        <i class="bi bi-trash3"></i>
                                    </button>
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

<div class="mt-4">
    <a class="btn btn-link text-muted text-decoration-none small p-0" href="?">
        <i class="bi bi-house-door me-1"></i> Volver al panel principal
    </a>
</div>

<script>
function confirmarEliminar(id) {
    if (confirm('¿Está seguro de que desea eliminar este paciente? Esta acción no se puede deshacer.')) {
        window.location.href = '?r=pacientes_delete&id=' + id;
    }
}
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';