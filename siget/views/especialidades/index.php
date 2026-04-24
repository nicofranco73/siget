<?php $userRol = $_SESSION['usuario_rol'] ?? 'paciente'; ?>

<div class="row g-4">
    <div class="col-12">
        <h2 class="fw-bold mb-0">Gestión de Especialidades</h2>
        <p class="text-muted">Administración de áreas médicas del sistema SIGET</p>
    </div>

    <?php if ($userRol === 'admin'): ?>
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title fw-bold mb-4 text-accent">Nueva Especialidad</h5>
                <form action="index.php?r=especialidades_guardar" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nombre</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Cardiología" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Opcional..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-accent w-100 py-2">
                        <i class="bi bi-plus-circle me-2"></i>Guardar Especialidad
                    </button>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="<?= ($userRol === 'admin') ? 'col-md-8' : 'col-12' ?>">
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold">ID</th>
                                <th class="py-3 text-muted small fw-bold">NOMBRE</th>
                                <th class="py-3 text-muted small fw-bold">DESCRIPCIÓN</th>
                                <th class="py-3 text-muted small fw-bold text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($especialidades)): ?>
                                <?php foreach ($especialidades as $e): ?>
                                <tr>
                                    <td class="ps-4 text-muted">#<?php echo $e['id_especialidad']; ?></td>
                                    <td><span class="fw-semibold text-dark"><?php echo htmlspecialchars($e['nombre']); ?></span></td>
                                    <td class="text-muted small"><?php echo htmlspecialchars($e['descripcion']); ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-success-subtle text-success border border-success-subtle">Activo</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">No hay especialidades registradas aún.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>