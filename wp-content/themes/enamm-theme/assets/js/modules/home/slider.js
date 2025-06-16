// modules/slider.js

/**
 * Inicializa un slider de imágenes con funcionalidades de autoplay, drag y bucle infinito.
 * Requiere los siguientes elementos en el DOM:
 * - Un contenedor con la clase 'slider-track' para las tarjetas.
 * - Elementos con la clase 'slider-card' dentro del 'slider-track'.
 * - Un contenedor con la clase 'slider-dots' para los indicadores de paginación.
 */
export function initSlider() {
    const sliderTrack = document.querySelector('.slider-track');
    // Si no encontramos el track, no inicializamos el slider.
    if (!sliderTrack) {
        console.warn('Slider track element not found. Skipping slider initialization.');
        return;
    }

    const originalCards = Array.from(document.querySelectorAll('.slider-card'));
    const sliderDotsContainer = document.querySelector('.slider-dots');

    if (originalCards.length === 0) {
        console.warn('No slider cards found. Skipping slider initialization.');
        return;
    }
    if (!sliderDotsContainer) {
        console.warn('Slider dots container not found. Slider dots functionality will be limited.');
    }


    const cardsPerView = 1; // Siempre una tarjeta por vista
    let totalCards = originalCards.length;
    let clonedCardsCount = cardsPerView; // Número de tarjetas clonadas a cada lado
    let currentIndex = 0; // Índice de la tarjeta REAL activa

    let isDragging = false;
    let startPos = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationId; // Variable para requestAnimationFrame si se usara para arrastre suave

    let autoplayInterval; // Variable para controlar el autoplay
    const autoplayDelay = 4000; // 4 segundos para el autoplay

    // --- Funciones de Utilidad ---

    // Función para aplicar la imagen de fondo a cada tarjeta
    const setCardBackgrounds = (cards) => {
        const isMobile = window.innerWidth <= 1020; // Define tu breakpoint para móvil

        cards.forEach(card => {
            let imageUrl;
            if (isMobile) {
                imageUrl = card.dataset.bgImageMobile; // Usa data-bg-image-mobile
            } else {
                imageUrl = card.dataset.bgImageDesktop; // Usa data-bg-image-desktop
            }

            if (imageUrl) {
                card.style.backgroundImage = `url('${imageUrl}')`;
            } else {
                // Si no hay una imagen específica para el breakpoint,
                // usa la imagen por defecto (si existe data-bg-image)
                imageUrl = card.dataset.bgImage;
                if (imageUrl) {
                    card.style.backgroundImage = `url('${imageUrl}')`;
                } else {
                    // O limpia la imagen si no hay ninguna definida
                    card.style.backgroundImage = '';
                }
            }
        });
    };

    // Configura el slider para el efecto infinito (duplica tarjetas)
    const setupInfiniteSlider = () => {
        // Eliminar clones existentes para evitar duplicados en resize
        const existingClones = sliderTrack.querySelectorAll('.clone');
        existingClones.forEach(clone => clone.remove());

        // Clonar tarjetas al final para el inicio virtual
        originalCards.slice(0, clonedCardsCount).forEach(card => {
            const clone = card.cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        });

        // Clonar tarjetas al principio para el final virtual
        originalCards.slice(totalCards - clonedCardsCount).reverse().forEach(card => {
            const clone = card.cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        });

        // Aplicar fondos a todas las tarjetas (originales y clones)
        setCardBackgrounds(Array.from(sliderTrack.querySelectorAll('.slider-card')));

        // Ajustar el currentIndex para que la primera tarjeta real esté visible
        currentIndex = clonedCardsCount; // Empieza en la primera tarjeta real
    };

    // Generar los botones de paginación (puntos)
    const generateDots = () => {
        if (!sliderDotsContainer) return; // No generar si no existe el contenedor
        sliderDotsContainer.innerHTML = ''; // Limpiar puntos existentes
        for (let i = 0; i < totalCards; i++) {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            dot.dataset.index = i; // Guardar el índice real en el dataset del dot
            dot.addEventListener('click', () => {
                stopAutoplay(); // Detener autoplay al interactuar con los dots
                currentIndex = i + clonedCardsCount; // Ir a la tarjeta real correspondiente al punto
                updateSliderPosition(true);
                startAutoplay(); // Reiniciar autoplay después de la interacción
            });
            sliderDotsContainer.appendChild(dot);
        }
    };

    // Actualizar la posición del slider y los puntos
    const updateSliderPosition = (animate = true) => {
        const cardWidth = window.innerWidth; // Calcula el ancho de una tarjeta
        currentTranslate = -currentIndex * cardWidth;

        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${currentTranslate}px)`;

        updateDots();
    };

    // Actualizar el estado activo de los puntos
    const updateDots = () => {
        if (!sliderDotsContainer) return;
        const dots = sliderDotsContainer.querySelectorAll('.dot');
        const realIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards; // Calcula el índice real de forma segura
        dots.forEach(dot => {
            if (parseInt(dot.dataset.index) === realIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    // --- Lógica del Autoplay ---
    const startAutoplay = () => {
        stopAutoplay(); // Asegurarse de que no haya múltiples intervalos
        autoplayInterval = setInterval(() => {
            currentIndex++;
            updateSliderPosition(true);
        }, autoplayDelay);
    };

    const stopAutoplay = () => {
        clearInterval(autoplayInterval);
    };

    // --- Lógica de Arrastre (Mouse y Touch) ---

    // Función unificada para inicio de arrastre
    const dragStart = (e) => {
        stopAutoplay();
        isDragging = true;
        startPos = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        prevTranslate = currentTranslate;
        sliderTrack.style.transition = 'none';
        cancelAnimationFrame(animationId);
        sliderTrack.style.cursor = 'grabbing';
    };

    // Función unificada para movimiento de arrastre
    const dragMove = (e) => {
        if (!isDragging) return;
        const currentPosition = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
        const diff = currentPosition - startPos;
        currentTranslate = prevTranslate + diff;
        sliderTrack.style.transform = `translateX(${currentTranslate}px)`;
    };

    // Función unificada para fin de arrastre
    const dragEnd = () => {
        if (!isDragging) return; // Asegurarse de que realmente hubo un arrastre
        isDragging = false;
        const movedBy = currentTranslate - prevTranslate;
        const cardWidth = sliderTrack.offsetWidth / (totalCards + (2 * clonedCardsCount));

        if (movedBy < -cardWidth / 4) {
            currentIndex++;
        } else if (movedBy > cardWidth / 4) {
            currentIndex--;
        }
        updateSliderPosition(true);
        startAutoplay();
        sliderTrack.style.cursor = 'grab';
    };

    // Eventos de Mouse
    sliderTrack.addEventListener('mousedown', dragStart);
    sliderTrack.addEventListener('mousemove', dragMove);
    sliderTrack.addEventListener('mouseup', dragEnd);
    sliderTrack.addEventListener('mouseleave', () => { // Manejar si el mouse se sale sin soltar
        if (isDragging) {
            dragEnd(); // Tratarlo como un fin de arrastre
        }
    });

    // Eventos de Touch para dispositivos móviles
    sliderTrack.addEventListener('touchstart', dragStart, { passive: true });
    sliderTrack.addEventListener('touchmove', dragMove, { passive: true });
    sliderTrack.addEventListener('touchend', dragEnd);
    sliderTrack.addEventListener('touchcancel', dragEnd); // En caso de que se cancele el toque

    // --- Listener para el final de la transición (para el bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        // Calcula el ancho de una tarjeta una vez más para asegurar precisión
        const cardWidth = sliderTrack.offsetWidth / (totalCards + (2 * clonedCardsCount));

        // Si estamos en una tarjeta clonada del final (al ir hacia adelante)
        if (currentIndex >= totalCards + clonedCardsCount) {
            currentIndex = clonedCardsCount; // Saltar a la primera tarjeta real
            updateSliderPosition(false); // Sin animación para el salto
        }
        // Si estamos en una tarjeta clonada del inicio (al ir hacia atrás)
        else if (currentIndex < clonedCardsCount) {
            currentIndex = totalCards + clonedCardsCount - 1; // Saltar a la última tarjeta real
            updateSliderPosition(false); // Sin animación para el salto
        }
        // Después de cada transición (incluyendo los saltos invisibles), actualizamos los dots
        updateDots();
    });

    // --- Event listener para redimensionamiento de la ventana ---
    window.addEventListener('resize', () => {
        stopAutoplay();
        // Llamada a setCardBackgrounds aquí para que las imágenes cambien al redimensionar
        setCardBackgrounds(Array.from(sliderTrack.querySelectorAll('.slider-card'))); // Asegura que se actualicen las imágenes
        setupInfiniteSlider();
        updateSliderPosition(false);
        generateDots();
        startAutoplay();
    });

    // --- Inicialización del slider ---
    // Pequeña mejora: si el track está vacío, lo inicializamos y luego hacemos el setup.
    // Esto es útil si las tarjetas se cargan dinámicamente, aunque aquí parece que están en el HTML.
    if (sliderTrack.children.length === 0 && originalCards.length > 0) {
         // Si el track está vacío pero hay originalCards, agregar las originales primero
         originalCards.forEach(card => sliderTrack.appendChild(card.cloneNode(true)));
    }


    setupInfiniteSlider(); // Configura las tarjetas clonadas y fondos
    generateDots(); // Genera los puntos
    updateSliderPosition(false); // Posiciona el slider al inicio sin animación
    startAutoplay(); // Iniciar el autoplay
}