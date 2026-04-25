<?php
// views/profesionales/index.php - protegido por rol
$title = 'Profesionales';
$userRol = $_SESSION['usuario_rol'] ?? 'paciente';
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-person-badge me-2"></i>Profesionales</h1>
    <?php if ($userRol === 'admin'): ?>
        <a class="btn btn-primary shadow-sm" href="?r=profesionales_create">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Profesional
        </a>
    <?php endif; ?>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0"> <?php if (empty($profesionales)): ?>
            <div class="p-4 text-center">
                <p class="text-muted">No hay profesionales registrados.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Apellido y Nombre</th>
                            <th>Especialidad</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($profesionales as $pr): ?>
                        <tr>
                            <td class="ps-4"><?= $pr['id'] ?></td>
                            <td class="fw-bold">
                                <?= htmlspecialchars($pr['apellido']) ?>, <?= htmlspecialchars($pr['nombre']) ?>
                            </td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($pr['especialidad']) ?></span></td>
                            <td><?= htmlspecialchars($pr['telefono']) ?></td>
                            <td><?= htmlspecialchars($pr['email']) ?></td>
                            <td class="text-end pe-4">
                                <button class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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
    <a class="btn btn-outline-secondary" href="?">
        <i class="bi bi-house-door me-1"></i> Volver al inicio
    </a>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';