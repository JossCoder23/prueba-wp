/**
 * Inicializa la funcionalidad del botón de menú móvil.
 * @param {string} buttonSelector - Selector CSS para el botón de hamburguesa.
 * @param {string} menuSelector - Selector CSS para el contenedor del menú.
 */
export function setupMobileMenu(buttonSelector, menuSelector) {
    const mobileButton = document.querySelector(buttonSelector);
    const headerMenu = document.querySelector(menuSelector);

    if (!mobileButton || !headerMenu) {
        console.warn('Mobile menu elements not found. Skipping setup.');
        return;
    }

    mobileButton.addEventListener('click', function () {
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