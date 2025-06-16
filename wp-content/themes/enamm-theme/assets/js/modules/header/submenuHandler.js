/**
 * Inicializa la funcionalidad de expansión/colapso para los submenús en dispositivos móviles.
 * @param {string} menuItemSelector - Selector CSS para los títulos de los ítems con submenú (e.g., '.menuRight__item h3').
 * @param {string} mediaQuery - La media query para la cual esta lógica debe activarse (e.g., '(max-width: 1020px)').
 */
export function setupSubmenus(menuItemSelector, mediaQuery) {
    const menuItemsWithSubmenus = document.querySelectorAll(menuItemSelector);
    const mediaQueryList = window.matchMedia(mediaQuery);

    menuItemsWithSubmenus.forEach(function (h3) {
        h3.addEventListener('click', function () {
            // Verifica si la media query coincide con el tamaño actual de la pantalla
            if (mediaQueryList.matches) {
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
}