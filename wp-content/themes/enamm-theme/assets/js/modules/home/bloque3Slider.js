// modules/bloque3Slider.js
import { initializeInfiniteResponsiveSlider } from './infiniteResponsiveSlider.js';

export function initBloque3Slider() {
    initializeInfiniteResponsiveSlider({
        trackSelector: '.bloque3__slider--track',
        cardSelector: '.bloque3__slider--card',
        prevArrowSelector: '.bloque3__prev--arrow',
        nextArrowSelector: '.bloque3__next--arrow',
        dotsContainerSelector: '.bloque3__slider--dots',
        dotClass: 'bloque3__dot',
        desktopBreakpoint: 1024,
        cardsPerViewMobile: 1,
        cardsPerViewDesktop: 3
    });
}