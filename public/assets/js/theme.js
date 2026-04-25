// theme.js - toggle theme (light/dark) with gradient adjustments
(function () {
  const storageKey = 'siget_theme';
  const toggleButton = document.getElementById('themeToggle');

  // Apply theme: 'light' or 'dark'
  function applyTheme(theme) {
    if (theme === 'dark') {
      document.documentElement.classList.add('theme-dark');
      if (toggleButton) toggleButton.innerHTML = '<i class="bi bi-sun"></i>';
    } else {
      document.documentElement.classList.remove('theme-dark');
      if (toggleButton) toggleButton.innerHTML = '<i class="bi bi-moon"></i>';
    }
    try {
      localStorage.setItem(storageKey, theme);
    } catch (e) {
      // ignore storage errors
    }
  }

  // Toggle
  function toggle() {
    const current = (localStorage.getItem(storageKey) || detectSystemPreference());
    applyTheme(current === 'light' ? 'dark' : 'light');
  }

  // Detect system preference
  function detectSystemPreference() {
    try {
      if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        return 'dark';
      }
    } catch (e) {}
    return 'light';
  }

  // On load: apply saved or system
  (function init() {
    const saved = localStorage.getItem(storageKey);
    const theme = saved || detectSystemPreference();
    applyTheme(theme);

    if (toggleButton) {
      toggleButton.addEventListener('click', function (e) {
        e.preventDefault();
        toggle();
      });
    }
  })();
})();

// Menú hamburguesa, Alertas SweetAlert2 y Validaciones
document.addEventListener('DOMContentLoaded', function() {
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  
  if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', function(e) {
          e.preventDefault();
          sidebar.classList.toggle('show');
      });
      
      const sidebarLinks = sidebar.querySelectorAll('a');
      sidebarLinks.forEach(link => {
          link.addEventListener('click', function() {
              sidebar.classList.remove('show');
          });
      });
      
      document.addEventListener('click', function(event) {
          if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
              sidebar.classList.remove('show');
          }
      });
  }

  // --- LÓGICA DE ALERTAS SWEETALERT2 ---
  const urlParams = new URLSearchParams(window.location.search);
  const msg = urlParams.get('msg');

  if (msg) {
      let config = {
          confirmButtonColor: '#4FB6B1',
          timer: 2500,
          timerProgressBar: true
      };

      switch (msg) {
          case 'created':
              config.icon = 'success';
              config.title = '¡Éxito!';
              config.text = 'El registro se ha creado correctamente.';
              break;
          case 'updated':
              config.icon = 'success';
              config.title = 'Actualizado';
              config.text = 'Los cambios fueron guardados.';
              break;
          case 'deleted':
              config.icon = 'warning';
              config.title = 'Eliminado';
              config.text = 'El registro ha sido removido.';
              break;
      }

      if (config.title) {
          Swal.fire(config).then(() => {
              const url = new URL(window.location);
              url.searchParams.delete('msg');
              window.history.replaceState({}, '', url);
          });
      }
  }

  // --- NUEVO: VALIDACIÓN EN TIEMPO REAL (PACIENTES) ---
  const form = document.getElementById('pacienteForm');
  if (form) {
      const inputs = form.querySelectorAll('input');
      
      const validateInput = (input) => {
          let isValid = true;
          const val = input.value.trim();

          // Lógica por tipo de campo
          if (input.hasAttribute('required') && val === '') {
              isValid = false;
          } else if (input.id === 'dni' && val !== '') {
              // DNI: Solo números, entre 7 y 8 dígitos
              isValid = /^\d{7,8}$/.test(val);
          } else if (input.id === 'email' && val !== '') {
              // Email: Formato estándar
              isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
          } else if ((input.id === 'nombre' || input.id === 'apellido') && val !== '') {
              // Nombre/Apellido: No permite números
              isValid = !/\d/.test(val);
          }

          // Aplicar clases de Bootstrap
          if (isValid) {
              input.classList.remove('is-invalid');
              input.classList.add('is-valid');
          } else {
              input.classList.remove('is-valid');
              input.classList.add('is-invalid');
          }
          return isValid;
      };

      // Escuchar mientras el usuario escribe
      inputs.forEach(input => {
          input.addEventListener('input', () => validateInput(input));
      });

      // Validar todo antes de enviar
      form.addEventListener('submit', function(e) {
          let formValid = true;
          inputs.forEach(input => {
              if (!validateInput(input)) formValid = false;
          });

          if (!formValid) {
              e.preventDefault();
              Swal.fire({
                  icon: 'error',
                  title: 'Revisá los datos',
                  text: 'Hay campos vacíos o con errores.',
                  confirmButtonColor: '#d33'
              });
          }
      });
  }
});