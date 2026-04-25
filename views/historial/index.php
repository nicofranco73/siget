<?php
// views/historial/index.php
// Este archivo ya NO debe incluir el sidebar ni el layout, 
// porque el controlador ya los carga automáticamente.
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">
                <i class="fas fa-file-medical text-primary me-2"></i>Historia Clínica
            </h2>
            <p class="text-muted">Registro detallado de consultas del paciente</p>
        </div>
        <a href="?r=pacientes" class="btn btn-outline-secondary shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Volver a Pacientes
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <?php if (empty($consultas)): ?>
                <div class="card shadow-sm border-0 py-5">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="fas fa-folder-open fa-4x text-light"></i>
                        </div>
                        <h4 class="text-secondary">Sin registros encontrados</h4>
                        <p class="text-muted">No existen consultas médicas cargadas para este paciente en el sistema.</p>
                        <button class="btn btn-primary mt-2" onclick="window.history.back()">
                            Regresar
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <div class="timeline">
                    <?php foreach ($consultas as $c): ?>
                        <div class="card shadow-sm border-0 mb-3 border-start border-primary border-4">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="fw-bold mb-1">
                                            <?= date('d/m/Y', strtotime($c['fecha_consulta'])) ?>
                                        </h5>
                                        <span class="badge bg-info text-dark mb-3">
                                            <?= htmlspecialchars($c['nombre_especialidad'] ?? 'Consulta General') ?>
                                        </span>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="far fa-clock me-1"></i> Registrado
                                    </div>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="text-uppercase fw-bold x-small text-primary d-block">Diagnóstico</label>
                                        <p class="text-dark"><?= nl2br(htmlspecialchars($c['diagnostico'])) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-uppercase fw-bold x-small text-success d-block">Tratamiento</label>
                                        <p class="text-dark"><?= nl2br(htmlspecialchars($c['tratamiento'])) ?></p>
                                    </div>
                                </div>
                                
                                <?php if (!empty($c['observaciones'])): ?>
                                    <div class="mt-2 pt-2 border-top">
                                        <label class="text-muted d-block small">Observaciones adicionales:</label>
                                        <small class="fst-italic"><?= htmlspecialchars($c['observaciones']) ?></small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .x-small { font-size: 0.7rem; letter-spacing: 1px; }
    .border-primary { border-color: #0d6efd !important; }
</style>