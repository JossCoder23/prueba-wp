// modules/bloque7Slider.js
import { initializeInfiniteResponsiveSlider } from './infiniteResponsiveSlider.js';

export function initBloque7Slider() {
    initializeInfiniteResponsiveSlider({
        trackSelector: '.bloque7__slider--track',
        cardSelector: '.bloque7__slider--card',
        prevArrowSelector: '.bloque7__prev--arrow',
        nextArrowSelector: '.bloque7__next--arrow',
        dotsContainerSelector: '.bloque7__slider--dots',
        dotClass: 'bloque7__dot', // Asegúrate de que esta clase coincida con tu CSS
        desktopBreakpoint: 1024,
        cardsPerViewMobile: 1,
        cardsPerViewDesktop: 3
    });
}