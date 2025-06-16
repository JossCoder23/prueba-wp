// modules/bloque9Slider.js
import { initializeInfiniteResponsiveSlider } from './infiniteResponsiveSlider.js';

/**
 * Inicializa el slider del Bloque 9 utilizando la lógica genérica de slider infinito y responsivo.
 */
export function initBloque9Slider() {
    initializeInfiniteResponsiveSlider({
        trackSelector: '.bloque9__slider--track',
        cardSelector: '.bloque9__slider--card',
        prevArrowSelector: '.bloque9__prev--arrow',
        nextArrowSelector: '.bloque9__next--arrow',
        dotsContainerSelector: '.bloque9__slider--dots',
        dotClass: 'bloque9__dot', // Asegúrate de que esta clase coincida con tu CSS
        desktopBreakpoint: 1024,
        cardsPerViewMobile: 1,
        cardsPerViewDesktop: 3
    });
}