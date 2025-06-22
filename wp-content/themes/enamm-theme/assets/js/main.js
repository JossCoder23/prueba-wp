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

    // Inicializar el slider
    initSlider(); // <-- Llama a la función de inicialización del slider
    initBloque2Slider();
    initBloque3Slider();
    initBloque4Slider();
    initBloque7Slider();
    initBloque8Slider();
    initBloque9Slider();

});