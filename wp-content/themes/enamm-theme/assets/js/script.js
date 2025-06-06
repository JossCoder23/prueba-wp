document.addEventListener('DOMContentLoaded', function() { 

  const menuToggle = document.querySelector('.menu-toggle');
  const mainNavigation = document.getElementById('site-navigation');

  menuToggle.addEventListener('click', function() {
      // Toggle de la clase para mostrar/ocultar el menú principal
      mainNavigation.classList.toggle('toggled-on');
      // Toggle de la clase para animar la hamburguesa y para accesibilidad
      this.classList.toggle('active');

      // Actualizar el atributo aria-expanded para accesibilidad
      const isExpanded = this.getAttribute('aria-expanded') === 'true' || false;
      this.setAttribute('aria-expanded', !isExpanded);
  });

  // Manejar los submenús en móviles (solo si tienen hijos)
  const menuItemsWithChildren = document.querySelectorAll('.main-navigation li.menu-item-has-children > a');

  menuItemsWithChildren.forEach(function(item) {
      item.addEventListener('click', function(event) {
          // Solo prevenir el comportamiento por defecto si estamos en móvil
          // (cuando el menú está desplegado por el toggle)
          if (window.innerWidth <= 768) { // Ajusta el breakpoint si es diferente a tu CSS
              event.preventDefault(); // Previene la navegación inmediata

              const parentLi = this.parentNode;
              // Si el submenú ya está abierto, lo cerramos
              if (parentLi.classList.contains('active')) {
                  parentLi.classList.remove('active');
              } else {
                  // Cierra cualquier otro submenú abierto en el mismo nivel
                  const openSubmenus = parentLi.parentNode.querySelectorAll('.menu-item-has-children.active');
                  openSubmenus.forEach(function(openItem) {
                      if (openItem !== parentLi) { // No cerrar el que acabamos de hacer clic
                          openItem.classList.remove('active');
                      }
                  });
                  // Abre el submenú actual
                  parentLi.classList.add('active');
              }
          }
          // Si el submenú no tiene hijos, o si estamos en escritorio, el enlace funcionará normalmente.
      });
  });

  // Cerrar el menú si se hace clic fuera de él en móvil
  document.addEventListener('click', function(event) {
      if (window.innerWidth <= 768 && mainNavigation.classList.contains('toggled-on')) {
          const isClickInsideMenu = mainNavigation.contains(event.target) || menuToggle.contains(event.target);
          if (!isClickInsideMenu) {
              mainNavigation.classList.remove('toggled-on');
              menuToggle.classList.remove('active');
              menuToggle.setAttribute('aria-expanded', false);

              // Opcional: Cerrar todos los submenús activos al cerrar el menú principal
              document.querySelectorAll('.main-navigation li.menu-item-has-children.active').forEach(function(item) {
                  item.classList.remove('active');
              });
          }
      }
  });

  // Asegurarse de que el menú se resetee si se cambia el tamaño de la ventana
  // de móvil a escritorio y viceversa
  let resizeTimer;
  window.addEventListener('resize', function() {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function() {
          if (window.innerWidth > 768) {
              // Si estamos en escritorio, asegúrate de que el menú esté visible
              mainNavigation.style.display = ''; // Elimina el 'display: none' o 'block' inline
              mainNavigation.classList.remove('toggled-on');
              menuToggle.classList.remove('active');
              menuToggle.setAttribute('aria-expanded', false);
              // Asegúrate de que todos los submenús estén ocultos por defecto en escritorio
              document.querySelectorAll('.main-navigation ul ul').forEach(function(submenu) {
                  submenu.style.display = '';
              });
          } else {
              // Si volvemos a móvil, oculta el menú si no está toggled-on
              if (!mainNavigation.classList.contains('toggled-on')) {
                  mainNavigation.style.display = 'none';
              }
          }
          // Cerrar todos los submenús desplegados en móvil al redimensionar
          document.querySelectorAll('.main-navigation li.menu-item-has-children.active').forEach(function(item) {
              item.classList.remove('active');
          });

      }, 250); // Pequeño retraso para evitar ejecuciones excesivas
  });

})
