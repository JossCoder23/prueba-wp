// modules/bloque2Slider.js

/**
 * Inicializa el slider del bloque 2, que se adapta a móvil y escritorio.
 * En móvil, funciona como un slider con flechas.
 * En escritorio, se comporta como un diseño estático.
 *
 * Requiere los siguientes elementos en el DOM:
 * - Un contenedor con la clase 'bloque2__slider--container'.
 * - Un track con la clase 'bloque2__slider--track'.
 * - Tarjetas con la clase 'bloque2__slider--card'.
 * - Contenidos de las tarjetas con la clase 'bloque2__card--content'.
 * - Flechas con las clases 'bloque2__slider--arrow--left' y 'bloque2__slider--arrow--right'.
 */
export function initBloque2Slider() {
    const sliderContainer = document.querySelector('.bloque2__slider--container');
    const sliderTrack = document.querySelector('.bloque2__slider--track');
    const sliderCards = document.querySelectorAll('.bloque2__slider--card');
    const sliderContents = document.querySelectorAll('.bloque2__card--content');
    const prevArrow = document.querySelector('.bloque2__slider--arrow--left');
    const nextArrow = document.querySelector('.bloque2__slider--arrow--right');

    // Define el breakpoint de escritorio.
    const desktopBreakpoint = 1020;
    let currentIndex = 0;
    let isSliderActive = false; // Controla si la lógica del slider está activa

    // Valida que los elementos esenciales existan.
    if (!sliderTrack || sliderCards.length === 0 || !prevArrow || !nextArrow) {
        console.warn('Bloque2 Slider: Elementos no encontrados o insuficientes. El slider podría no funcionar correctamente.');
        return; // Detiene la ejecución si faltan elementos cruciales.
    }

    /**
     * @function updateBackgroundImage
     * Actualiza la imagen de fondo de las tarjetas según el ancho de la ventana.
     */
    function updateBackgroundImage() {
        const isMobileView = window.innerWidth < desktopBreakpoint;
        sliderContents.forEach(content => {
            const imageUrl = isMobileView ? content.dataset.bgImageMobile : content.dataset.bgImageDesktop;
            if (imageUrl) {
                content.style.backgroundImage = `url('${imageUrl}')`;
            } else {
                content.style.backgroundImage = 'none';
            }
        });
    }

    /**
     * @function moveToSlide
     * Mueve el track del slider a la posición de la tarjeta indicada.
     * Solo se ejecuta si el slider está activo (en vista móvil).
     */
    function moveToSlide(index) {
        if (!isSliderActive) {
            return; // No hace nada si el slider no está activo.
        }

        // Lógica de bucle para el slider móvil.
        if (index < 0) {
            currentIndex = sliderCards.length - 1;
        } else if (index >= sliderCards.length) {
            currentIndex = 0;
        } else {
            currentIndex = index;
        }

        const slideWidth = sliderCards[0].offsetWidth; // Obtiene el ancho actual de una tarjeta.
        const offset = -currentIndex * slideWidth;
        sliderTrack.style.transform = `translateX(${offset}px)`;
    }

    /**
     * @function setupBloque2
     * Configura el comportamiento del bloque 2 según el ancho de la ventana (móvil o desktop).
     */
    function setupBloque2() {
        updateBackgroundImage(); // Siempre actualiza las imágenes de fondo.

        const windowWidth = window.innerWidth;
        const isMobileView = windowWidth < desktopBreakpoint;

        if (isMobileView) {
            // --- ACTIVA el modo slider para móvil ---
            isSliderActive = true;
            sliderTrack.style.transition = 'transform 0.5s ease-in-out';
            sliderTrack.style.display = 'flex'; // Asegura que el track sea flex para el slider.

            // Lógica de ancho de tarjeta para móvil (si es necesaria, como en tu original).
            // Si el CSS ya lo maneja bien con `width: 100%`, puedes simplificar esto.
            let cardWidthPercentage = '100%';
            if (windowWidth >= 320) {
                cardWidthPercentage = '100%'; // Puedes ajustar esto si tienes porcentajes finos.
            }
            sliderCards.forEach(card => {
                card.style.width = cardWidthPercentage;
            });

            // Posiciona el slider al activar o redimensionar.
            moveToSlide(currentIndex);

            prevArrow.style.display = 'block';
            nextArrow.style.display = 'block';

        } else {
            // --- DESACTIVA el modo slider para desktop ---
            isSliderActive = false;
            sliderTrack.style.transform = 'none'; // Elimina cualquier transformación de slider.
            sliderTrack.style.transition = 'none'; // Deshabilita transiciones.
            sliderTrack.style.display = 'flex'; // Mantiene 'flex' para que las reglas CSS de desktop funcionen.

            // Restablece el ancho de las tarjetas para que el CSS en desktop las controle.
            // sliderCards.forEach(card => {
            //     card.style.width = 'auto'; // Deja que el CSS determine el ancho.
            // });

            prevArrow.style.display = 'none'; // Oculta las flechas.
            nextArrow.style.display = 'none';

            currentIndex = 0; // Reinicia el índice al pasar a desktop.
        }
    }

    // Event listeners para las flechas.
    prevArrow.addEventListener('click', () => moveToSlide(currentIndex - 1));
    nextArrow.addEventListener('click', () => moveToSlide(currentIndex + 1));

    // Inicializa el bloque al cargar la página.
    setupBloque2();

    // Listener para el redimensionamiento de la ventana con debounce.
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            setupBloque2(); // Reconfigura el bloque al redimensionar.
        }, 250); // Pequeño retraso para evitar ejecuciones excesivas.
    });
}