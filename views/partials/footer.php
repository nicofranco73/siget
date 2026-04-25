<?php
// views/partials/footer.php
// Footer - variante B mejorada: enlaces rápidos en 2 columnas y modales para legales
?>
<footer class="site-footer mt-5" role="contentinfo" aria-label="Footer de SIGET">
  <div class="container py-5">
    <div class="row gy-4">
      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">SIGET</h6>
        <p class="text-muted small mb-0">Sistema de Gestión de Turnos — demo académico.</p>
        <p class="text-muted small mt-2 mb-0">Proyecto: Seminario — Carrera Analista de Sistemas</p>
      </div>

      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Enlaces rápidos</h6>
        <div class="footer-links-two row">
          <div class="col-6">
            <ul class="list-unstyled small mb-0">
              <li><a class="footer-link" href="?r=pacientes">Pacientes</a></li>
              <li><a class="footer-link" href="?r=profesionales">Profesionales</a></li>
              <li><a class="footer-link" href="?r=turnos">Turnos</a></li>
            </ul>
          </div>
          <div class="col-6">
            <ul class="list-unstyled small mb-0">
              <li><a class="footer-link" href="?r=turnos_agenda_diaria">Agenda</a></li>
              <li><a class="footer-link" href="?r=turnos_agenda_semanal">Agenda semanal</a></li>
              <li><a class="footer-link" href="?r=turnos_export&start=<?= date('Y-m-d') ?>" target="_blank" rel="noopener noreferrer">Exportar CSV</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <h6 class="fw-bold">Contacto</h6>
        <div class="small text-muted">
          <a href="mailto:demo@example.com" class="footer-link">demo@example.com</a><br>
          <span class="text-muted">+54 9 11 1234 5678</span>
        </div>
        <div class="mt-3">
          <a class="btn btn-sm btn-outline-secondary me-2" href="https://twitter.com/" aria-label="Twitter (abre en nueva pestaña)" target="_blank" rel="noopener noreferrer"><i class="bi bi-twitter"></i></a>
          <a class="btn btn-sm btn-outline-secondary me-2" href="https://www.linkedin.com/" aria-label="LinkedIn (abre en nueva pestaña)" target="_blank" rel="noopener noreferrer"><i class="bi bi-linkedin"></i></a>
          <a class="btn btn-sm btn-outline-secondary" href="https://github.com/" aria-label="Github (abre en nueva pestaña)" target="_blank" rel="noopener noreferrer"><i class="bi bi-github"></i></a>
        </div>
      </div>
    </div>

    <div class="border-top pt-3 mt-3 d-flex flex-column flex-md-row justify-content-between small text-muted align-items-center">
      <div class="mb-2 mb-md-0">© <?= date('Y') ?> — Hecho por vos</div>
      <div class="d-flex align-items-center">
        <a class="footer-link me-3" href="#" data-bs-toggle="modal" data-bs-target="#modalPrivacy" aria-controls="modalPrivacy">Política de privacidad</a>
        <a class="footer-link me-3" href="#" data-bs-toggle="modal" data-bs-target="#modalTerms" aria-controls="modalTerms">Términos</a>
      </div>
    </div>
  </div>
</footer>

<!-- Modal: Política de privacidad -->
<div class="modal fade" id="modalPrivacy" tabindex="-1" aria-labelledby="modalPrivacyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPrivacyLabel">Política de privacidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h6>Resumen</h6>
        <p class="small text-muted">En <strong>SIGET</strong> tratamos la información personal necesaria para gestionar turnos y la comunicación con pacientes y profesionales. Esta política explica qué datos recopilamos, con qué finalidad y qué derechos tenés como titular de los datos.</p>

        <h6>1. Responsable del tratamiento</h6>
        <p class="small text-muted">Responsable: <strong>[NOMBRE DEL PROYECTO / INSTITUCIÓN]</strong>. Contacto: <a href="mailto:demo@example.com">demo@example.com</a>.</p>

        <h6>2. Datos que recopilamos</h6>
        <ul class="small text-muted">
          <li>Datos de identificación: nombre, apellido, DNI o documento, fecha de nacimiento.</li>
          <li>Datos de contacto: teléfono, email.</li>
          <li>Datos de la prestación: motivos de consulta, fechas y horarios de turnos, historial básico de citas.</li>
          <li>Metadatos técnicos: direcciones IP y datos de sesión (para fines de seguridad y diagnóstico).</li>
        </ul>

        <h6>3. Finalidad del tratamiento</h6>
        <p class="small text-muted">Los datos se usan exclusivamente para:</p>
        <ul class="small text-muted">
          <li>Gestionar reservas y agendas de turnos.</li>
          <li>Comunicar recordatorios y notificaciones relacionadas con los turnos.</li>
          <li>Generar listados, estadísticas y reportes internos (agregados y sin identificación directa cuando corresponda).</li>
        </ul>

        <h6>4. Legitimación</h6>
        <p class="small text-muted">El tratamiento se funda en la necesidad de ejecutar el servicio solicitado (gestión de turnos) y en el consentimiento del titular para las comunicaciones asociadas.</p>

        <h6>5. Conservación</h6>
        <p class="small text-muted">Los datos se conservarán durante el tiempo necesario para prestar el servicio y conforme a las obligaciones legales aplicables. Los datos inactivos pueden archivarse y luego suprimirse según políticas internas.</p>

        <h6>6. Cesiones y transferencias</h6>
        <p class="small text-muted">No vendemos datos. Podemos compartir datos con terceros colaboradores únicamente cuando sea necesario para la prestación del servicio (p. ej. sistemas de correo) y con las garantías técnicas y contractuales correspondientes.</p>

        <h6>7. Medidas de seguridad</h6>
        <p class="small text-muted">Implementamos medidas técnicas y organizativas razonables para proteger los datos frente a accesos no autorizados, pérdida o alteración. No obstante, ningún sistema es invulnerable; por eso recomendamos buenas prácticas de contraseñas y protección de dispositivos.</p>

        <h6>8. Derechos del titular</h6>
        <p class="small text-muted">Podés ejercer los derechos de acceso, rectificación, supresión, oposición, limitación y portabilidad dirigendo un email a <a href="mailto:demo@example.com">demo@example.com</a>. Indicá en tu solicitud el derecho que ejercés y, si es aplicable, una copia del documento que acredite tu identidad.</p>

        <h6>9. Cookies y tecnologías similares</h6>
        <p class="small text-muted">Este sistema puede usar cookies técnicas para el correcto funcionamiento. No se emplean cookies de perfilado por defecto en la versión demo.</p>

        <h6>10. Cambios en la política</h6>
        <p class="small text-muted">Podemos actualizar esta política. Publicaremos la versión vigente en el propio sistema y, cuando corresponda, informaremos a los usuarios.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal: Términos -->
<div class="modal fade" id="modalTerms" tabindex="-1" aria-labelledby="modalTermsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTermsLabel">Términos y condiciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <h6>1. Aceptación</h6>
        <p class="small text-muted">El acceso y uso de <strong>SIGET</strong> implica la aceptación de estos Términos. Si no estás conforme, no uses la aplicación.</p>

        <h6>2. Objeto</h6>
        <p class="small text-muted">SIGET es una aplicación para la gestión de turnos médicos y administrativos (reservas, listados, exportaciones). Estos Términos regulan el uso del servicio.</p>

        <h6>3. Acceso y responsabilidades del usuario</h6>
        <ul class="small text-muted">
          <li>El usuario se compromete a proporcionar información veraz y actualizada.</li>
          <li>El usuario es responsable de mantener la confidencialidad de sus credenciales y de cualquier actividad realizada con su cuenta.</li>
          <li>No se permite usar el sistema para fines ilícitos ni con datos de terceros sin su consentimiento.</li>
        </ul>

        <h6>4. Propiedad intelectual</h6>
        <p class="small text-muted">El software, el diseño, los textos y los elementos gráficos son propiedad de [NOMBRE DEL PROYECTO / AUTOR]. Queda prohibida la reproducción total o parcial sin autorización expresa, salvo para fines académicos y copia de respaldo personal.</p>

        <h6>5. Disponibilidad y mantenimiento</h6>
        <p class="small text-muted">Hacemos esfuerzos razonables para mantener el servicio disponible. No obstante, podemos suspender temporalmente el servicio por mantenimiento o causas técnicas sin responsabilidad por daños indirectos.</p>

        <h6>6. Limitación de responsabilidad</h6>
        <p class="small text-muted">En la medida permitida por la ley, [NOMBRE DEL PROYECTO / AUTOR] no será responsable por daños indirectos, pérdida de datos o lucro cesante derivados del uso del sistema. Es responsabilidad del usuario mantener copias de seguridad de la información crítica.</p>

        <h6>7. Modificaciones</h6>
        <p class="small text-muted">Podemos modificar estos Términos. Las versiones actualizadas se publicarán en el sistema. El uso continuado del servicio tras la publicación implica la aceptación de los cambios.</p>

        <h6>8. Duración y terminación</h6>
        <p class="small text-muted">Estos Términos se aplican mientras el usuario use el servicio. Podemos suspender o cancelar el acceso por incumplimiento de los Términos.</p>

        <h6>9. Legislación aplicable y jurisdicción</h6>
        <p class="small text-muted">Estos Términos se rigen por la normativa vigente en [PAÍS / JURISDICCIÓN]. Para cualquier conflicto, las partes se someten a los tribunales competentes de dicha jurisdicción, salvo que la ley establezca otra cosa.</p>

        <h6>10. Contacto</h6>
        <p class="small text-muted">Para consultas relacionadas con estos Términos o con el servicio, escribí a <a href="mailto:demo@example.com">demo@example.com</a>.</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>