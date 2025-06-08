document.addEventListener('DOMContentLoaded', function() {
    const mobileButton = document.querySelector('.header__buttonMobile');
    const headerMenu = document.querySelector('.header__menu');
    // Selecciona los títulos de los ítems con submenú
    const menuItemsWithSubmenus = document.querySelectorAll('.menuRight__item h3');

    // --- Lógica para el botón de hamburguesa y el menú principal ---
    if (mobileButton && headerMenu) {
        mobileButton.addEventListener('click', function() {
            // Alternar la clase 'is-active' en el botón (hamburguesa <-> X)
            this.classList.toggle('is-active');

            // Alternar la clase 'is-open' en el contenedor del menú para mostrarlo/ocultarlo
            headerMenu.classList.toggle('is-open');

            // Actualizar atributo aria-expanded para accesibilidad
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);

            // Controlar el scroll del cuerpo para que no se mueva cuando el menú esté abierto
            if (headerMenu.classList.contains('is-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = ''; // Restablecer
            }
        });
    }

    // --- Lógica para los submenús (solo en móvil) ---
    menuItemsWithSubmenus.forEach(function(h3) {
        h3.addEventListener('click', function() {
            // Verifica si la pantalla es menor o igual a 769px
            if (window.matchMedia('(max-width: 769px)').matches) {
                const parentItem = this.closest('.menuRight__item'); // El div.menuRight__item padre
                const submenu = this.nextElementSibling; // El div.subitem o div.subitem2

                if (parentItem && submenu) {
                    // Alternar la clase 'is-open' en el item padre para el CSS (flecha y submenú)
                    parentItem.classList.toggle('is-open');
                    submenu.classList.toggle('is-open');
                }
            }
        });
    });
});