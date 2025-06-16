// modules/bloque4Slider.js

/**
 * Inicializa un slider de imágenes simple para el Bloque 4.
 * Muestra una imagen a la vez y permite navegar entre ellas con flechas.
 *
 * Requiere los siguientes elementos en el DOM:
 * - Imágenes con la clase 'slider-image' dentro de '.bloque4__right--card'.
 * - Flechas de navegación con las clases 'bloque4__slider--arrow--left' y 'bloque4__slider--arrow--right'.
 */
export function initBloque4Slider() {
    const sliderImages = document.querySelectorAll('.bloque4__right--card .slider-image');
    const arrowLeft = document.querySelector('.bloque4__slider--arrow--left');
    const arrowRight = document.querySelector('.bloque4__slider--arrow--right');
    let currentImageIndex = 0;

    // Validación inicial: asegúrate de que los elementos esenciales existan
    if (sliderImages.length === 0 || !arrowLeft || !arrowRight) {
        console.warn('Bloque4 Slider: No se encontraron imágenes o flechas para el slider. La funcionalidad no se inicializará.');
        return;
    }

    /**
     * Muestra la imagen en el índice especificado y oculta las demás.
     * @param {number} index - El índice de la imagen a mostrar.
     */
    function showImage(index) {
        sliderImages.forEach((img, i) => {
            if (i === index) {
                img.classList.add('active');
            } else {
                img.classList.remove('active');
            }
        });
    }

    /**
     * Avanza a la siguiente imagen en el slider, haciendo un bucle al principio si se llega al final.
     */
    function showNextImage() {
        currentImageIndex = (currentImageIndex + 1) % sliderImages.length;
        showImage(currentImageIndex);
    }

    /**
     * Retrocede a la imagen anterior en el slider, haciendo un bucle al final si se llega al principio.
     */
    function showPreviousImage() {
        currentImageIndex = (currentImageIndex - 1 + sliderImages.length) % sliderImages.length;
        showImage(currentImageIndex);
    }

    // --- Event Listeners para las flechas de navegación ---
    arrowRight.addEventListener('click', showNextImage);
    arrowLeft.addEventListener('click', showPreviousImage);

    // --- Inicialización del slider ---
    // Muestra la primera imagen al cargar la página
    showImage(currentImageIndex);
}