// modules/infiniteResponsiveSlider.js

/**
 * Inicializa un slider responsivo con bucle infinito, navegación por flechas y puntos de paginación.
 *
 * @param {object} options - Objeto de configuración para el slider.
 * @param {string} options.trackSelector - Selector CSS para el elemento que contiene las tarjetas del slider (el track).
 * @param {string} options.cardSelector - Selector CSS para las tarjetas individuales del slider.
 * @param {string} options.prevArrowSelector - Selector CSS para el botón de flecha "anterior".
 * @param {string} options.nextArrowSelector - Selector CSS para el botón de flecha "siguiente".
 * @param {string} options.dotsContainerSelector - Selector CSS para el contenedor de los puntos de paginación.
 * @param {string} options.dotClass - Clase CSS que se aplicará a cada punto de paginación generado.
 * @param {number} options.desktopBreakpoint - Ancho de ventana en píxeles donde `cardsPerView` cambia a `cardsPerViewDesktop`.
 * @param {number} options.cardsPerViewMobile - Número de tarjetas visibles en dispositivos móviles (debajo del breakpoint).
 * @param {number} options.cardsPerViewDesktop - Número de tarjetas visibles en escritorio (en o por encima del breakpoint).
 */
export function initializeInfiniteResponsiveSlider(options) {
    const {
        trackSelector,
        cardSelector,
        prevArrowSelector,
        nextArrowSelector,
        dotsContainerSelector,
        dotClass,
        desktopBreakpoint,
        cardsPerViewMobile,
        cardsPerViewDesktop
    } = options;

    const sliderTrack = document.querySelector(trackSelector);
    const originalCards = Array.from(document.querySelectorAll(cardSelector));
    const prevArrow = document.querySelector(prevArrowSelector);
    const nextArrow = document.querySelector(nextArrowSelector);
    const sliderDotsContainer = document.querySelector(dotsContainerSelector);

    // Validación inicial
    if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
        console.error(`Error: Uno o más elementos para el slider con track '${trackSelector}' no fueron encontrados. Revisa las clases en tu HTML y JavaScript.`);
        return;
    }

    let cardsPerView = cardsPerViewMobile; // Valor inicial
    const totalCards = originalCards.length;
    let clonedCardsCount = 0;
    let currentIndex = 0;

    /**
     * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
     */
    const updateCardsPerView = () => {
        const previousCardsPerView = cardsPerView;

        if (window.innerWidth >= desktopBreakpoint) {
            cardsPerView = cardsPerViewDesktop;
        } else {
            cardsPerView = cardsPerViewMobile;
        }

        if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
            setupInfiniteSlider();
        }
        generateDots();
        currentIndex = clonedCardsCount;
        updateSliderPosition(false);
    };

    /**
     * Configura el track del slider con clones al principio y al final para un bucle infinito.
     */
    const setupInfiniteSlider = () => {
        const existingClones = sliderTrack.querySelectorAll('.clone');
        existingClones.forEach(clone => clone.remove());

        // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
        sliderTrack.innerHTML = '';
        originalCards.forEach(card => sliderTrack.appendChild(card));

        clonedCardsCount = cardsPerView;

        // Clona tarjetas del principio y las añade al final
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[i % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        }

        // Clona tarjetas del final y las añade al principio
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        }

        currentIndex = clonedCardsCount;
    };

    /**
     * Genera dinámicamente los elementos de puntos de paginación.
     */
    const generateDots = () => {
        sliderDotsContainer.innerHTML = '';
        for (let i = 0; i < totalCards; i++) {
            const dot = document.createElement('div');
            dot.classList.add(dotClass);
            dot.addEventListener('click', () => {
                currentIndex = i + clonedCardsCount;
                updateSliderPosition(true);
            });
            sliderDotsContainer.appendChild(dot);
        }
        updateDots();
    };

    /**
     * Actualiza la posición translateX del `sliderTrack`.
     * @param {boolean} animate - Si la transición debe ser animada.
     */
    const updateSliderPosition = (animate = true) => {
        const firstCard = originalCards[0];
        if (!firstCard) {
            console.warn(`No hay tarjetas originales para calcular el ancho del slider: ${cardSelector}.`);
            return;
        }

        const cardWidth = firstCard.offsetWidth +
            parseFloat(getComputedStyle(firstCard).marginLeft) +
            parseFloat(getComputedStyle(firstCard).marginRight);

        const offset = -currentIndex * cardWidth;

        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${offset}px)`;

        updateDots();
        updateArrows();
    };

    /**
     * Actualiza la clase 'active' del punto de paginación.
     */
    const updateDots = () => {
        const dots = sliderDotsContainer.querySelectorAll(`.${dotClass}`);
        const currentRealCardIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;

        dots.forEach((dot, index) => {
            if (index === currentRealCardIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    /**
     * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
     */
    const updateArrows = () => {
        prevArrow.disabled = false;
        nextArrow.disabled = false;
    };

    // --- Listeners para la navegación con flechas ---
    nextArrow.addEventListener('click', () => {
        currentIndex++;
        updateSliderPosition(true);
    });

    prevArrow.addEventListener('click', () => {
        currentIndex--;
        updateSliderPosition(true);
    });

    // --- Listener para el final de la transición (manejo del bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        let realCardOffset = currentIndex - clonedCardsCount;

        if (realCardOffset >= totalCards) {
            currentIndex = clonedCardsCount + (realCardOffset % totalCards);
            updateSliderPosition(false);
        } else if (realCardOffset < 0) {
            let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
            if (targetRealIndex < 0) targetRealIndex += totalCards;
            currentIndex = clonedCardsCount + targetRealIndex;
            updateSliderPosition(false);
        }
    });

    // --- Listener para el redimensionamiento de la ventana con debounce ---
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateCardsPerView();
            currentIndex = clonedCardsCount;
            updateSliderPosition(false);
        }, 250);
    });

    // --- Inicialización ---
    updateCardsPerView();
}