import { setupMobileMenu } from './modules/header/mobileMenu.js';
import { setupSubmenus } from './modules/header/submenuHandler.js';

document.addEventListener('DOMContentLoaded', () => {

    // Inicializar la lógica del menú móvil
    setupMobileMenu('.header__buttonMobile', '.header__menu');

    // Inicializar la lógica de los submenús para móvil
    setupSubmenus('.menuRight__item h3', '(max-width: 1020px)');

});