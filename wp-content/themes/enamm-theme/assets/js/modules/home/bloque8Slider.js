// modules/bloque8Slider.js
import { initializeInfiniteResponsiveSlider } from './infiniteResponsiveSlider.js';

/**
 * Inicializa el slider del Bloque 8 utilizando la lógica genérica de slider infinito y responsivo.
 */
export function initBloque8Slider() {
    initializeInfiniteResponsiveSlider({
        trackSelector: '.bloque8__slider--track',
        cardSelector: '.bloque8__slider--card',
        prevArrowSelector: '.bloque8__prev--arrow',
        nextArrowSelector: '.bloque8__next--arrow',
        dotsContainerSelector: '.bloque8__slider--dots',
        dotClass: 'bloque8__dot', // Asegúrate de que esta clase coincida con tu CSS
        desktopBreakpoint: 1024,
        cardsPerViewMobile: 1,
        cardsPerViewDesktop: 3
    });
}