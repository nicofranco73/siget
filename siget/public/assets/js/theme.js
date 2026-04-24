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

// Menú hamburguesa
document.addEventListener('DOMContentLoaded', function() {
  const sidebarToggle = document.getElementById('sidebarToggle');
  const sidebar = document.getElementById('sidebar');
  
  if (sidebarToggle && sidebar) {
      sidebarToggle.addEventListener('click', function(e) {
          e.preventDefault();
          sidebar.classList.toggle('show');
      });
      
      // Cerrar sidebar al hacer clic en un link
      const sidebarLinks = sidebar.querySelectorAll('a');
      sidebarLinks.forEach(link => {
          link.addEventListener('click', function() {
              sidebar.classList.remove('show');
          });
      });
      
      // Cerrar sidebar al hacer clic fuera de él
      document.addEventListener('click', function(event) {
          if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
              sidebar.classList.remove('show');
          }
      });
  }
});