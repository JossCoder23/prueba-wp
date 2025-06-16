import { setupMobileMenu } from './modules/header/mobileMenu.js';
import { setupSubmenus } from './modules/header/submenuHandler.js';
import { 
    initSlider,
    initBloque2Slider, 
    initBloque3Slider, 
    initBloque4Slider, 
    initBloque7Slider, 
    initBloque8Slider, 
    initBloque9Slider 
} from './modules/home/index.js'; 

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM completamente cargado y parseado. Inicializando scripts...');

    // Inicializar la lógica del menú móvil
    setupMobileMenu('.header__buttonMobile', '.header__menu');

    // Inicializar la lógica de los submenús para móvil
    setupSubmenus('.menuRight__item h3', '(max-width: 1020px)');

    // Inicializar el slider
    initSlider(); // <-- Llama a la función de inicialización del slider
    initBloque2Slider();
    initBloque3Slider();
    initBloque4Slider();
    initBloque7Slider();
    initBloque8Slider();
    initBloque9Slider();

});