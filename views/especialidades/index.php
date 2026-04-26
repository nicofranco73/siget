<?php 
// views/especialidades/index.php
$userRol = $_SESSION['usuario_rol'] ?? 'paciente'; 
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <div class="p-3 bg-primary bg-opacity-10 rounded-3 me-3">
                    <i class="bi bi-grid-3x3-gap-fill text-primary fs-2"></i>
                </div>
                <div>
                    <h2 class="fw-bold text-dark mb-0">Gestión de Especialidades</h2>
                    <p class="text-muted mb-0 small">Configuración de áreas médicas y staff profesional.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php if ($userRol === 'admin'): ?>
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 100;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 text-dark">
                        <i class="bi bi-plus-circle-fill me-2 text-primary"></i>Nueva Especialidad
                    </h5>
                    <form action="?r=especialidades_guardar" method="POST">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nombre del Área</label>
                            <input type="text" name="nombre" class="form-control border-light-subtle bg-light py-2" 
                                   placeholder="Ej: Odontología" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Descripción / Notas</label>
                            <textarea name="descripcion" class="form-control border-light-subtle bg-light" rows="3" 
                                      placeholder="Breve detalle de la especialidad..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 shadow-sm fw-bold">
                            <i class="bi bi-save2 me-2"></i>Registrar Especialidad
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="<?= ($userRol === 'admin') ? 'col-xl-8 col-lg-7' : 'col-12' ?>">
            <div class="row g-3">
                <?php if (!empty($especialidades)): ?>
                    <?php foreach ($especialidades as $e): ?>
                        <div class="col-md-6 col-xl-6">
                            <div class="card h-100 shadow-sm border-0 border-top border-4 <?= ($e['activo'] ?? true) ? 'border-primary' : 'border-secondary' ?> card-especialidad">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-1"><?= htmlspecialchars($e['nombre']) ?></h5>
                                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.65rem;">
                                                ID: #<?= $e['id_especialidad'] ?? $e['id'] ?>
                                            </span>
                                        </div>
                                        <div class="status-indicator">
                                            <span class="badge rounded-pill <?= ($e['activo'] ?? true) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-light text-secondary border' ?> px-3 py-2">
                                                <i class="bi bi-circle-fill me-1 small"></i>
                                                <?= ($e['activo'] ?? true) ? 'ACTIVO' : 'INACTIVO' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <p class="text-muted small mb-4 description-text">
                                        <?= htmlspecialchars($e['descripcion'] ?: 'Sin descripción detallada disponible.') ?>
                                    </p>

                                    <div class="bg-light rounded-4 p-3 mb-4 d-flex align-items-center">
                                        <div class="flex-shrink-0 bg-white shadow-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                            <i class="bi bi-people-fill text-primary"></i>
                                        </div>
                                        <div class="ms-3">
                                            <p class="mb-0 fw-bold small text-dark">Staff Profesional</p>
                                            <p class="mb-0 text-muted small"><?= $e['total_profesionales'] ?? 0 ?> integrantes asignados</p>
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <a href="?r=profesionales&especialidad=<?= $e['id_especialidad'] ?? $e['id'] ?>" class="btn btn-primary btn-sm flex-grow-1 shadow-sm fw-bold py-2">
                                            <i class="bi bi-eye me-1"></i> Ver Staff
                                        </a>
                                        <?php if ($userRol === 'admin'): ?>
                                            <a href="?r=especialidades_edit&id=<?= $e['id_especialidad'] ?? $e['id'] ?>" class="btn btn-outline-secondary btn-sm px-3 py-2" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-5 text-center bg-light">
                            <i class="bi bi-layers text-muted opacity-25 display-1"></i>
                            <h5 class="text-muted mt-3 fw-normal">No hay especialidades registradas aún.</h5>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilo SIGET Moderno */
.card-especialidad {
    transition: all 0.3s ease;
    border-radius: 12px;
}
.card-especialidad:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(13, 110, 253, 0.1) !important;
}
.description-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 3rem;
}
.bg-primary-subtle { background-color: #e7f1ff !important; }
.rounded-4 { border-radius: 1rem !important; }
</style>