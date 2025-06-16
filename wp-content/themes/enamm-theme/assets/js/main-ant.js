document.addEventListener('DOMContentLoaded', function () {
    const mobileButton = document.querySelector('.header__buttonMobile');
    const headerMenu = document.querySelector('.header__menu');
    // Selecciona los títulos de los ítems con submenú
    const menuItemsWithSubmenus = document.querySelectorAll('.menuRight__item h3');

    // --- Lógica para el botón de hamburguesa y el menú principal ---
    if (mobileButton && headerMenu) {
        mobileButton.addEventListener('click', function () {
            // Alternar la clase 'is-active' en el botón (hamburguesa <-> X)
            this.classList.toggle('is-active');

            // Alternar la clase 'is-open' en el contenedor del menú para mostrarlo/ocultarlo
            headerMenu.classList.toggle('is-open');

            // Actualizar atributo aria-expanded para accesibilidad
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !isExpanded);

            // Controlar el scroll del cuerpo para que no se mueva cuando el menú esté abierto
            if (headerMenu.classList.contains('is-open')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = ''; // Restablecer
            }
        });
    }

    // --- Lógica para los submenús (solo en móvil) ---
    menuItemsWithSubmenus.forEach(function (h3) {
        h3.addEventListener('click', function () {
            // Verifica si la pantalla es menor o igual a 769px
            if (window.matchMedia('(max-width: 1020px)').matches) {
                const parentItem = this.closest('.menuRight__item'); // El div.menuRight__item padre
                const submenu = this.nextElementSibling; // El div.subitem o div.subitem2

                if (parentItem && submenu) {
                    // Alternar la clase 'is-open' en el item padre para el CSS (flecha y submenú)
                    parentItem.classList.toggle('is-open');
                    submenu.classList.toggle('is-open');
                }
            }
        });
    });
});

//- =================================================================
//- =========================BLOQUE1=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    const sliderTrack = document.querySelector('.slider-track');
    const originalCards = Array.from(document.querySelectorAll('.slider-card'));
    const sliderDotsContainer = document.querySelector('.slider-dots');

    const cardsPerView = 1; // Siempre una tarjeta por vista
    let totalCards = originalCards.length;
    let clonedCardsCount = cardsPerView; // Número de tarjetas clonadas a cada lado
    let currentIndex = 0; // Índice de la tarjeta REAL activa

    let isDragging = false;
    let startPos = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;
    let animationId;

    let autoplayInterval; // Variable para controlar el autoplay
    const autoplayDelay = 4000; // 5 segundos para el autoplay

    // --- Funciones de Utilidad ---

    // Función para aplicar la imagen de fondo a cada tarjeta
    const setCardBackgrounds = (cards) => {
        cards.forEach(card => {
            const imageUrl = card.dataset.bgImage;
            if (imageUrl) {
                card.style.backgroundImage = `url('${imageUrl}')`;
            }
        });
    };

    // Configura el slider para el efecto infinito (duplica tarjetas)
    const setupInfiniteSlider = () => {
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
        const cardWidth = window.innerWidth;
        currentTranslate = -currentIndex * cardWidth;

        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${currentTranslate}px)`;

        updateDots();
    };

    // Actualizar el estado activo de los puntos
    const updateDots = () => {
        const dots = document.querySelectorAll('.dot');
        const realIndex = (currentIndex - clonedCardsCount) % totalCards; // Calcula el índice real
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

    // --- Lógica de Arrastre (Mouse) ---

    // Eventos para el inicio del arrastre
    sliderTrack.addEventListener('mousedown', (e) => {
        stopAutoplay(); // Detener autoplay al inicio del arrastre
        isDragging = true;
        startPos = e.clientX;
        prevTranslate = currentTranslate; // Guardar la posición actual
        sliderTrack.style.transition = 'none'; // Desactivar transición durante el arrastre
        cancelAnimationFrame(animationId); // Detener cualquier animación en curso

        // Cambiar cursor a "grabbing"
        sliderTrack.style.cursor = 'grabbing';
    });

    // Eventos para el movimiento del arrastre
    sliderTrack.addEventListener('mousemove', (e) => {
        if (!isDragging) return;

        const currentPosition = e.clientX;
        const diff = currentPosition - startPos; // Diferencia de arrastre
        currentTranslate = prevTranslate + diff;

        sliderTrack.style.transform = `translateX(${currentTranslate}px)`;
    });

    // Eventos para el final del arrastre
    sliderTrack.addEventListener('mouseup', () => {
        isDragging = false;
        const movedBy = currentTranslate - prevTranslate; // Cuánto se movió
        const cardWidth = window.innerWidth;

        // Determinar a qué slide moverse
        if (movedBy < -cardWidth / 4) { // Si se arrastró más de 1/4 de la tarjeta a la izquierda
            currentIndex++;
        } else if (movedBy > cardWidth / 4) { // Si se arrastró más de 1/4 de la tarjeta a la derecha
            currentIndex--;
        }
        // Si no se movió lo suficiente, vuelve al slide actual
        updateSliderPosition(true); // Animar a la posición final
        startAutoplay(); // Reiniciar autoplay al soltar el mouse

        // Restablecer cursor
        sliderTrack.style.cursor = 'grab';
    });

    // Cancelar arrastre si el mouse sale del área
    sliderTrack.addEventListener('mouseleave', () => {
        if (isDragging) {
            isDragging = false;
            updateSliderPosition(true); // Vuelve al slide actual si se sale sin soltar
            startAutoplay();
            sliderTrack.style.cursor = 'grab';
        }
    });

    // --- Listener para el final de la transición (para el bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        const cardWidth = window.innerWidth;

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
        stopAutoplay(); // Detener autoplay durante el redimensionamiento
        setupInfiniteSlider(); // Re-clonar tarjetas y reconfigurar al redimensionar
        updateSliderPosition(false); // Recalcular posición, sin animación
        generateDots(); // Regenerar dots (aunque el número no cambiará, asegura el estado)
        startAutoplay(); // Reiniciar autoplay
    });

    // --- Inicialización del slider ---
    setupInfiniteSlider(); // Configura las tarjetas clonadas y fondos
    generateDots(); // Genera los puntos
    updateSliderPosition(false); // Posiciona el slider al inicio sin animación
    startAutoplay(); // Iniciar el autoplay
});

document.addEventListener('DOMContentLoaded', () => {
    const sliderCards = document.querySelectorAll('.slider-card');

    function setBackgroundImage() {
        const isMobile = window.innerWidth <= 768; // Define tu breakpoint para móvil, por ejemplo, 768px

        sliderCards.forEach(card => {
            let imageUrl;
            if (isMobile) {
                imageUrl = card.dataset.bgImageMobile;
            } else {
                imageUrl = card.dataset.bgImageDesktop;
            }

            if (imageUrl) {
                card.style.backgroundImage = `url('${imageUrl}')`;
            }
        });
    }

    // Ejecutar al cargar la página
    setBackgroundImage();

    // Ejecutar cuando se redimensiona la ventana (para adaptabilidad)
    window.addEventListener('resize', setBackgroundImage);
});
//- =================================================================
//- =======================FIN BLOQUE1===============================
//- =================================================================

//- =================================================================
//- =========================BLOQUE2=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {

    //- =================================================================
    //- =========================BLOQUE2=================================
    //- =================================================================
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
    //- =================================================================
    //- =======================FIN BLOQUE2===============================
    //- =================================================================

    // NOTA: Si tienes otros scripts para bloque3 y bloque7, asegúrate de que también estén dentro de este mismo
    // document.addEventListener('DOMContentLoaded', ...) o en sus propios listeners si prefieres mantenerlos separados.
    // Lo ideal sería usar la función initializeBlock si se ajusta a sus necesidades.

});
//- =================================================================
//- =======================FIN BLOQUE2===============================
//- =================================================================

//- =================================================================
//- =========================BLOQUE3=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Selectores de elementos del DOM con tus clases específicas
    const sliderTrack = document.querySelector('.bloque3__slider--track');
    const originalCards = Array.from(document.querySelectorAll('.bloque3__slider--card'));
    const prevArrow = document.querySelector('.bloque3__prev--arrow');
    const nextArrow = document.querySelector('.bloque3__next--arrow');
    const sliderDotsContainer = document.querySelector('.bloque3__slider--dots');

    // Validación inicial: asegúrate de que todos los elementos existan
    if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
        console.error('Error: Uno o más elementos del slider no fueron encontrados. Revisa que las clases en tu HTML y JavaScript coincidan.');
        return; // Detener la ejecución si faltan elementos cruciales
    }

    // Variables de estado del slider
    let cardsPerView = 1; // Número de tarjetas visibles a la vez (se ajusta con la responsividad)
    const totalCards = originalCards.length; // Cantidad total de tarjetas originales (fija en 9 en tu caso)
    let clonedCardsCount = 0; // Cantidad de tarjetas clonadas a cada lado para el efecto infinito
    let currentIndex = 0; // Índice de la tarjeta activa en el track (incluye clones)

    // Ya no necesitamos `totalPages` como una variable de estado dinámica para los dots,
    // porque siempre serán 9. Pero la mantenemos para depuración si la necesitas.
    // let totalPages = 0; 

    /**
     * @function updateCardsPerView
     * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
     */
    const updateCardsPerView = () => {
        const previousCardsPerView = cardsPerView;

        // Determina cuántas tarjetas se muestran según el ancho de la pantalla
        if (window.innerWidth >= 1024) {
            cardsPerView = 3;
        } else {
            cardsPerView = 1;
        }

        // Si `cardsPerView` ha cambiado o es la primera inicialización, reconfigura los clones.
        if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
            setupInfiniteSlider();
        }

        // No necesitamos `totalPages` para la generación de dots si siempre son 9.
        // Si necesitas saber cuántas "páginas" lógicas hay para otra cosa, podrías calcularlo aquí.
        // totalPages = Math.ceil(totalCards / cardsPerView); 

        generateDots(); // (Re)genera los puntos de paginación.

        // Reposiciona el slider al inicio del primer grupo de tarjetas originales sin animación.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false);
    };

    /**
     * @function setupInfiniteSlider
     * Configura el track del slider con clones al principio y al final para un bucle infinito.
     */
    const setupInfiniteSlider = () => {
        // Elimina cualquier clon existente antes de añadir nuevos.
        const existingClones = sliderTrack.querySelectorAll('.bloque3__slider--card.clone');
        existingClones.forEach(clone => clone.remove());

        // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
        // Esto es vital antes de añadir los clones.
        sliderTrack.innerHTML = '';
        originalCards.forEach(card => sliderTrack.appendChild(card));

        // El número de clones es igual a `cardsPerView` para un bucle fluido.
        clonedCardsCount = cardsPerView;

        // Clona tarjetas del principio y las añade al final del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[i % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        }

        // Clona tarjetas del final y las añade al principio del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        }

        // Establece el `currentIndex` para que apunte a la primera tarjeta original.
        currentIndex = clonedCardsCount;
    };

    /**
     * @function generateDots
     * Genera dinámicamente los elementos de puntos de paginación. **Ahora siempre 9 dots.**
     */
    const generateDots = () => {
        sliderDotsContainer.innerHTML = ''; // Limpia los puntos existentes.

        // Los puntos corresponden a CADA tarjeta original, por lo tanto, siempre `totalCards` (que es 9).
        for (let i = 0; i < totalCards; i++) { // Bucle hasta totalCards para generar 9 dots.
            const dot = document.createElement('div');
            dot.classList.add('bloque3__dot'); // Usa tu clase para los puntos.

            dot.addEventListener('click', () => {
                // Al hacer clic en un punto, el slider se mueve a la tarjeta individual correspondiente.
                currentIndex = i + clonedCardsCount; // 'i' es el índice de la tarjeta original.
                updateSliderPosition(true);
            });
            sliderDotsContainer.appendChild(dot);
        }
        updateDots(); // Actualiza el estado activo del punto recién generado.
    };

    /**
     * @function updateSliderPosition
     * Actualiza la posición translateX del `sliderTrack` para mostrar la tarjeta actual.
     * @param {boolean} animate - Si la transición debe ser animada.
     */
    const updateSliderPosition = (animate = true) => {
        const firstCard = originalCards[0];
        if (!firstCard) {
            console.warn('No hay tarjetas originales para calcular el ancho.');
            return;
        }

        // Calcula el ancho total de una tarjeta, incluyendo sus márgenes.
        const cardWidth = firstCard.offsetWidth +
            parseFloat(getComputedStyle(firstCard).marginLeft) +
            parseFloat(getComputedStyle(firstCard).marginRight);

        // Calcula el desplazamiento horizontal necesario.
        const offset = -currentIndex * cardWidth;

        // Aplica la transición y el desplazamiento.
        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${offset}px)`;

        updateDots(); // Actualiza el estado de los puntos.
        updateArrows(); // Asegura que las flechas estén habilitadas.
    };

    /**
     * @function updateDots
     * Actualiza la clase 'active' del punto de paginación correspondiente a la tarjeta actual. **Ahora cada dot representa una tarjeta.**
     */
    const updateDots = () => {
        const dots = document.querySelectorAll('.bloque3__dot'); // Selecciona los puntos con la nueva clase.

        // Calcula el índice de la tarjeta real que está actualmente visible.
        // Aquí no se usa `cardsPerView` para los dots, solo el índice de la tarjeta individual.
        const currentRealCardIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;

        dots.forEach((dot, index) => {
            if (index === currentRealCardIndex) { // Compara con el índice real de la tarjeta.
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    /**
     * @function updateArrows
     * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
     */
    const updateArrows = () => {
        prevArrow.disabled = false;
        nextArrow.disabled = false;
    };

    // --- Listeners para la navegación con flechas ---
    nextArrow.addEventListener('click', () => {
        // Siempre avanza el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex++;
        updateSliderPosition(true);
    });

    prevArrow.addEventListener('click', () => {
        // Siempre retrocede el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex--;
        updateSliderPosition(true);
    });

    // --- Listener para el final de la transición (manejo del bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        // Calcula el índice de la tarjeta real actual (sin contar los clones).
        let realCardOffset = currentIndex - clonedCardsCount;

        // Si el slider se ha movido más allá del final de las tarjetas reales (a un clon 'end').
        if (realCardOffset >= totalCards) {
            // Salta instantáneamente a la posición equivalente al principio de las tarjetas reales.
            currentIndex = clonedCardsCount + (realCardOffset % totalCards);
            updateSliderPosition(false); // Sin animación para el salto.
        }
        // Si el slider se ha movido antes del principio de las tarjetas reales (a un clon 'start').
        else if (realCardOffset < 0) {
            // Salta instantáneamente a la posición equivalente al final de las tarjetas reales.
            // Asegura que el índice de destino sea positivo y dentro del rango original.
            let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
            if (targetRealIndex < 0) targetRealIndex += totalCards; // Asegura que sea positivo.

            // No necesitamos alinear a `cardsPerView` aquí para los dots, ya que cada dot es individual.
            // Pero si el salto en el bucle te lleva a una posición que visualmente no es el inicio de un grupo,
            // y quieres que el primer dot visible se active, esta línea podría necesitarse.
            // Por simplicidad, si los dots son 1:1 con las tarjetas, no se necesita.
            // targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView; 

            currentIndex = clonedCardsCount + targetRealIndex;
            updateSliderPosition(false); // Sin animación para el salto.
        }
    });

    // --- Listener para el redimensionamiento de la ventana ---
    window.addEventListener('resize', () => {
        updateCardsPerView(); // Reajusta la vista y los clones. Los dots se regenerarán y serán 9.
        // Después de redimensionar, reposiciona el slider al inicio del primer grupo original.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false); // Sin animación durante el redimensionamiento.
    });

    // --- Inicialización del slider ---
    updateCardsPerView(); // Llama a la función principal para configurar el slider al cargar la página.
});
//- =================================================================
//- =======================FIN BLOQUE3===============================
//- =================================================================


//- =================================================================
//- =========================BLOQUE4=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    const sliderImages = document.querySelectorAll('.bloque4__right--card .slider-image');
    const arrowLeft = document.querySelector('.bloque4__slider--arrow--left');
    const arrowRight = document.querySelector('.bloque4__slider--arrow--right');
    let currentImageIndex = 0;

    function showImage(index) {
        sliderImages.forEach((img, i) => {
            if (i === index) {
                img.classList.add('active');
            } else {
                img.classList.remove('active');
            }
        });
    }

    function showNextImage() {
        currentImageIndex = (currentImageIndex + 1) % sliderImages.length;
        showImage(currentImageIndex);
    }

    function showPreviousImage() {
        currentImageIndex = (currentImageIndex - 1 + sliderImages.length) % sliderImages.length;
        showImage(currentImageIndex);
    }

    arrowRight.addEventListener('click', showNextImage);
    arrowLeft.addEventListener('click', showPreviousImage);

    // Muestra la primera imagen al cargar la página
    showImage(currentImageIndex);
});
//- =================================================================
//- =======================FIN BLOQUE4===============================
//- =================================================================


//- =================================================================
//- =========================BLOQUE7=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Selectores de elementos del DOM con tus clases específicas
    const sliderTrack = document.querySelector('.bloque7__slider--track');
    const originalCards = Array.from(document.querySelectorAll('.bloque7__slider--card'));
    const prevArrow = document.querySelector('.bloque7__prev--arrow');
    const nextArrow = document.querySelector('.bloque7__next--arrow');
    const sliderDotsContainer = document.querySelector('.bloque7__slider--dots');

    // Validación inicial: asegúrate de que todos los elementos existan
    if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
        console.error('Error: Uno o más elementos del slider no fueron encontrados. Revisa que las clases en tu HTML y JavaScript coincidan.');
        return; // Detener la ejecución si faltan elementos cruciales
    }

    // Variables de estado del slider
    let cardsPerView = 1; // Número de tarjetas visibles a la vez (se ajusta con la responsividad)
    const totalCards = originalCards.length; // Cantidad total de tarjetas originales (fija en 9 en tu caso)
    let clonedCardsCount = 0; // Cantidad de tarjetas clonadas a cada lado para el efecto infinito
    let currentIndex = 0; // Índice de la tarjeta activa en el track (incluye clones)

    // Ya no necesitamos `totalPages` como una variable de estado dinámica para los dots,
    // porque siempre serán 9. Pero la mantenemos para depuración si la necesitas.
    // let totalPages = 0; 

    /**
     * @function updateCardsPerView
     * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
     */
    const updateCardsPerView = () => {
        const previousCardsPerView = cardsPerView;

        // Determina cuántas tarjetas se muestran según el ancho de la pantalla
        if (window.innerWidth >= 1024) {
            cardsPerView = 3;
        } else {
            cardsPerView = 1;
        }

        // Si `cardsPerView` ha cambiado o es la primera inicialización, reconfigura los clones.
        if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
            setupInfiniteSlider();
        }

        // No necesitamos `totalPages` para la generación de dots si siempre son 9.
        // Si necesitas saber cuántas "páginas" lógicas hay para otra cosa, podrías calcularlo aquí.
        // totalPages = Math.ceil(totalCards / cardsPerView); 

        generateDots(); // (Re)genera los puntos de paginación.

        // Reposiciona el slider al inicio del primer grupo de tarjetas originales sin animación.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false);
    };

    /**
     * @function setupInfiniteSlider
     * Configura el track del slider con clones al principio y al final para un bucle infinito.
     */
    const setupInfiniteSlider = () => {
        // Elimina cualquier clon existente antes de añadir nuevos.
        const existingClones = sliderTrack.querySelectorAll('.bloque7__slider--card.clone');
        existingClones.forEach(clone => clone.remove());

        // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
        // Esto es vital antes de añadir los clones.
        sliderTrack.innerHTML = '';
        originalCards.forEach(card => sliderTrack.appendChild(card));

        // El número de clones es igual a `cardsPerView` para un bucle fluido.
        clonedCardsCount = cardsPerView;

        // Clona tarjetas del principio y las añade al final del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[i % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        }

        // Clona tarjetas del final y las añade al principio del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        }

        // Establece el `currentIndex` para que apunte a la primera tarjeta original.
        currentIndex = clonedCardsCount;
    };

    /**
     * @function generateDots
     * Genera dinámicamente los elementos de puntos de paginación. **Ahora siempre 9 dots.**
     */
    const generateDots = () => {
        sliderDotsContainer.innerHTML = ''; // Limpia los puntos existentes.

        // Los puntos corresponden a CADA tarjeta original, por lo tanto, siempre `totalCards` (que es 9).
        for (let i = 0; i < totalCards; i++) { // Bucle hasta totalCards para generar 9 dots.
            const dot = document.createElement('div');
            dot.classList.add('bloque7__dot'); // Usa tu clase para los puntos.

            dot.addEventListener('click', () => {
                // Al hacer clic en un punto, el slider se mueve a la tarjeta individual correspondiente.
                currentIndex = i + clonedCardsCount; // 'i' es el índice de la tarjeta original.
                updateSliderPosition(true);
            });
            sliderDotsContainer.appendChild(dot);
        }
        updateDots(); // Actualiza el estado activo del punto recién generado.
    };

    /**
     * @function updateSliderPosition
     * Actualiza la posición translateX del `sliderTrack` para mostrar la tarjeta actual.
     * @param {boolean} animate - Si la transición debe ser animada.
     */
    const updateSliderPosition = (animate = true) => {
        const firstCard = originalCards[0];
        if (!firstCard) {
            console.warn('No hay tarjetas originales para calcular el ancho.');
            return;
        }

        // Calcula el ancho total de una tarjeta, incluyendo sus márgenes.
        const cardWidth = firstCard.offsetWidth +
            parseFloat(getComputedStyle(firstCard).marginLeft) +
            parseFloat(getComputedStyle(firstCard).marginRight);

        // Calcula el desplazamiento horizontal necesario.
        const offset = -currentIndex * cardWidth;

        // Aplica la transición y el desplazamiento.
        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${offset}px)`;

        updateDots(); // Actualiza el estado de los puntos.
        updateArrows(); // Asegura que las flechas estén habilitadas.
    };

    /**
     * @function updateDots
     * Actualiza la clase 'active' del punto de paginación correspondiente a la tarjeta actual. **Ahora cada dot representa una tarjeta.**
     */
    const updateDots = () => {
        const dots = document.querySelectorAll('.bloque7__dot'); // Selecciona los puntos con la nueva clase.

        // Calcula el índice de la tarjeta real que está actualmente visible.
        // Aquí no se usa `cardsPerView` para los dots, solo el índice de la tarjeta individual.
        const currentRealCardIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;

        dots.forEach((dot, index) => {
            if (index === currentRealCardIndex) { // Compara con el índice real de la tarjeta.
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    /**
     * @function updateArrows
     * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
     */
    const updateArrows = () => {
        prevArrow.disabled = false;
        nextArrow.disabled = false;
    };

    // --- Listeners para la navegación con flechas ---
    nextArrow.addEventListener('click', () => {
        // Siempre avanza el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex++;
        updateSliderPosition(true);
    });

    prevArrow.addEventListener('click', () => {
        // Siempre retrocede el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex--;
        updateSliderPosition(true);
    });

    // --- Listener para el final de la transición (manejo del bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        // Calcula el índice de la tarjeta real actual (sin contar los clones).
        let realCardOffset = currentIndex - clonedCardsCount;

        // Si el slider se ha movido más allá del final de las tarjetas reales (a un clon 'end').
        if (realCardOffset >= totalCards) {
            // Salta instantáneamente a la posición equivalente al principio de las tarjetas reales.
            currentIndex = clonedCardsCount + (realCardOffset % totalCards);
            updateSliderPosition(false); // Sin animación para el salto.
        }
        // Si el slider se ha movido antes del principio de las tarjetas reales (a un clon 'start').
        else if (realCardOffset < 0) {
            // Salta instantáneamente a la posición equivalente al final de las tarjetas reales.
            // Asegura que el índice de destino sea positivo y dentro del rango original.
            let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
            if (targetRealIndex < 0) targetRealIndex += totalCards; // Asegura que sea positivo.

            // No necesitamos alinear a `cardsPerView` aquí para los dots, ya que cada dot es individual.
            // Pero si el salto en el bucle te lleva a una posición que visualmente no es el inicio de un grupo,
            // y quieres que el primer dot visible se active, esta línea podría necesitarse.
            // Por simplicidad, si los dots son 1:1 con las tarjetas, no se necesita.
            // targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView; 

            currentIndex = clonedCardsCount + targetRealIndex;
            updateSliderPosition(false); // Sin animación para el salto.
        }
    });

    // --- Listener para el redimensionamiento de la ventana ---
    window.addEventListener('resize', () => {
        updateCardsPerView(); // Reajusta la vista y los clones. Los dots se regenerarán y serán 9.
        // Después de redimensionar, reposiciona el slider al inicio del primer grupo original.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false); // Sin animación durante el redimensionamiento.
    });

    // --- Inicialización del slider ---
    updateCardsPerView(); // Llama a la función principal para configurar el slider al cargar la página.
});
//- =================================================================
//- =======================FIN BLOQUE7===============================
//- =================================================================


//- =================================================================
//- =========================BLOQUE8=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Selectores de elementos del DOM con tus clases específicas
    const sliderTrack = document.querySelector('.bloque8__slider--track');
    const originalCards = Array.from(document.querySelectorAll('.bloque8__slider--card'));
    const prevArrow = document.querySelector('.bloque8__prev--arrow');
    const nextArrow = document.querySelector('.bloque8__next--arrow');
    const sliderDotsContainer = document.querySelector('.bloque8__slider--dots');

    // Validación inicial: asegúrate de que todos los elementos existan
    if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
        console.error('Error: Uno o más elementos del slider no fueron encontrados. Revisa que las clases en tu HTML y JavaScript coincidan.');
        return; // Detener la ejecución si faltan elementos cruciales
    }

    // Variables de estado del slider
    let cardsPerView = 1; // Número de tarjetas visibles a la vez (se ajusta con la responsividad)
    const totalCards = originalCards.length; // Cantidad total de tarjetas originales (fija en 9 en tu caso)
    let clonedCardsCount = 0; // Cantidad de tarjetas clonadas a cada lado para el efecto infinito
    let currentIndex = 0; // Índice de la tarjeta activa en el track (incluye clones)

    // Ya no necesitamos `totalPages` como una variable de estado dinámica para los dots,
    // porque siempre serán 9. Pero la mantenemos para depuración si la necesitas.
    // let totalPages = 0; 

    /**
     * @function updateCardsPerView
     * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
     */
    const updateCardsPerView = () => {
        const previousCardsPerView = cardsPerView;

        // Determina cuántas tarjetas se muestran según el ancho de la pantalla
        if (window.innerWidth >= 1024) {
            cardsPerView = 3;
        } else {
            cardsPerView = 1;
        }

        // Si `cardsPerView` ha cambiado o es la primera inicialización, reconfigura los clones.
        if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
            setupInfiniteSlider();
        }

        // No necesitamos `totalPages` para la generación de dots si siempre son 9.
        // Si necesitas saber cuántas "páginas" lógicas hay para otra cosa, podrías calcularlo aquí.
        // totalPages = Math.ceil(totalCards / cardsPerView); 

        generateDots(); // (Re)genera los puntos de paginación.

        // Reposiciona el slider al inicio del primer grupo de tarjetas originales sin animación.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false);
    };

    /**
     * @function setupInfiniteSlider
     * Configura el track del slider con clones al principio y al final para un bucle infinito.
     */
    const setupInfiniteSlider = () => {
        // Elimina cualquier clon existente antes de añadir nuevos.
        const existingClones = sliderTrack.querySelectorAll('.bloque8__slider--card.clone');
        existingClones.forEach(clone => clone.remove());

        // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
        // Esto es vital antes de añadir los clones.
        sliderTrack.innerHTML = '';
        originalCards.forEach(card => sliderTrack.appendChild(card));

        // El número de clones es igual a `cardsPerView` para un bucle fluido.
        clonedCardsCount = cardsPerView;

        // Clona tarjetas del principio y las añade al final del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[i % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        }

        // Clona tarjetas del final y las añade al principio del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        }

        // Establece el `currentIndex` para que apunte a la primera tarjeta original.
        currentIndex = clonedCardsCount;
    };

    /**
     * @function generateDots
     * Genera dinámicamente los elementos de puntos de paginación. **Ahora siempre 9 dots.**
     */
    const generateDots = () => {
        sliderDotsContainer.innerHTML = ''; // Limpia los puntos existentes.

        // Los puntos corresponden a CADA tarjeta original, por lo tanto, siempre `totalCards` (que es 9).
        for (let i = 0; i < totalCards; i++) { // Bucle hasta totalCards para generar 9 dots.
            const dot = document.createElement('div');
            dot.classList.add('bloque8__dot'); // Usa tu clase para los puntos.

            dot.addEventListener('click', () => {
                // Al hacer clic en un punto, el slider se mueve a la tarjeta individual correspondiente.
                currentIndex = i + clonedCardsCount; // 'i' es el índice de la tarjeta original.
                updateSliderPosition(true);
            });
            sliderDotsContainer.appendChild(dot);
        }
        updateDots(); // Actualiza el estado activo del punto recién generado.
    };

    /**
     * @function updateSliderPosition
     * Actualiza la posición translateX del `sliderTrack` para mostrar la tarjeta actual.
     * @param {boolean} animate - Si la transición debe ser animada.
     */
    const updateSliderPosition = (animate = true) => {
        const firstCard = originalCards[0];
        if (!firstCard) {
            console.warn('No hay tarjetas originales para calcular el ancho.');
            return;
        }

        // Calcula el ancho total de una tarjeta, incluyendo sus márgenes.
        const cardWidth = firstCard.offsetWidth +
            parseFloat(getComputedStyle(firstCard).marginLeft) +
            parseFloat(getComputedStyle(firstCard).marginRight);

        // Calcula el desplazamiento horizontal necesario.
        const offset = -currentIndex * cardWidth;

        // Aplica la transición y el desplazamiento.
        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${offset}px)`;

        updateDots(); // Actualiza el estado de los puntos.
        updateArrows(); // Asegura que las flechas estén habilitadas.
    };

    /**
     * @function updateDots
     * Actualiza la clase 'active' del punto de paginación correspondiente a la tarjeta actual. **Ahora cada dot representa una tarjeta.**
     */
    const updateDots = () => {
        const dots = document.querySelectorAll('.bloque8__dot'); // Selecciona los puntos con la nueva clase.

        // Calcula el índice de la tarjeta real que está actualmente visible.
        // Aquí no se usa `cardsPerView` para los dots, solo el índice de la tarjeta individual.
        const currentRealCardIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;

        dots.forEach((dot, index) => {
            if (index === currentRealCardIndex) { // Compara con el índice real de la tarjeta.
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    /**
     * @function updateArrows
     * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
     */
    const updateArrows = () => {
        prevArrow.disabled = false;
        nextArrow.disabled = false;
    };

    // --- Listeners para la navegación con flechas ---
    nextArrow.addEventListener('click', () => {
        // Siempre avanza el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex++;
        updateSliderPosition(true);
    });

    prevArrow.addEventListener('click', () => {
        // Siempre retrocede el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex--;
        updateSliderPosition(true);
    });

    // --- Listener para el final de la transición (manejo del bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        // Calcula el índice de la tarjeta real actual (sin contar los clones).
        let realCardOffset = currentIndex - clonedCardsCount;

        // Si el slider se ha movido más allá del final de las tarjetas reales (a un clon 'end').
        if (realCardOffset >= totalCards) {
            // Salta instantáneamente a la posición equivalente al principio de las tarjetas reales.
            currentIndex = clonedCardsCount + (realCardOffset % totalCards);
            updateSliderPosition(false); // Sin animación para el salto.
        }
        // Si el slider se ha movido antes del principio de las tarjetas reales (a un clon 'start').
        else if (realCardOffset < 0) {
            // Salta instantáneamente a la posición equivalente al final de las tarjetas reales.
            // Asegura que el índice de destino sea positivo y dentro del rango original.
            let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
            if (targetRealIndex < 0) targetRealIndex += totalCards; // Asegura que sea positivo.

            // No necesitamos alinear a `cardsPerView` aquí para los dots, ya que cada dot es individual.
            // Pero si el salto en el bucle te lleva a una posición que visualmente no es el inicio de un grupo,
            // y quieres que el primer dot visible se active, esta línea podría necesitarse.
            // Por simplicidad, si los dots son 1:1 con las tarjetas, no se necesita.
            // targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView; 

            currentIndex = clonedCardsCount + targetRealIndex;
            updateSliderPosition(false); // Sin animación para el salto.
        }
    });

    // --- Listener para el redimensionamiento de la ventana ---
    window.addEventListener('resize', () => {
        updateCardsPerView(); // Reajusta la vista y los clones. Los dots se regenerarán y serán 9.
        // Después de redimensionar, reposiciona el slider al inicio del primer grupo original.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false); // Sin animación durante el redimensionamiento.
    });

    // --- Inicialización del slider ---
    updateCardsPerView(); // Llama a la función principal para configurar el slider al cargar la página.
});
//- =================================================================
//- =======================FIN BLOQUE8===============================
//- =================================================================

//- =================================================================
//- =========================BLOQUE9=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Selectores de elementos del DOM con tus clases específicas
    const sliderTrack = document.querySelector('.bloque9__slider--track');
    const originalCards = Array.from(document.querySelectorAll('.bloque9__slider--card'));
    const prevArrow = document.querySelector('.bloque9__prev--arrow');
    const nextArrow = document.querySelector('.bloque9__next--arrow');
    const sliderDotsContainer = document.querySelector('.bloque9__slider--dots');

    // Validación inicial: asegúrate de que todos los elementos existan
    if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
        console.error('Error: Uno o más elementos del slider no fueron encontrados. Revisa que las clases en tu HTML y JavaScript coincidan.');
        return; // Detener la ejecución si faltan elementos cruciales
    }

    // Variables de estado del slider
    let cardsPerView = 1; // Número de tarjetas visibles a la vez (se ajusta con la responsividad)
    const totalCards = originalCards.length; // Cantidad total de tarjetas originales (fija en 9 en tu caso)
    let clonedCardsCount = 0; // Cantidad de tarjetas clonadas a cada lado para el efecto infinito
    let currentIndex = 0; // Índice de la tarjeta activa en el track (incluye clones)

    // Ya no necesitamos `totalPages` como una variable de estado dinámica para los dots,
    // porque siempre serán 9. Pero la mantenemos para depuración si la necesitas.
    // let totalPages = 0; 

    /**
     * @function updateCardsPerView
     * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
     */
    const updateCardsPerView = () => {
        const previousCardsPerView = cardsPerView;

        // Determina cuántas tarjetas se muestran según el ancho de la pantalla
        if (window.innerWidth >= 1024) {
            cardsPerView = 3;
        } else {
            cardsPerView = 1;
        }

        // Si `cardsPerView` ha cambiado o es la primera inicialización, reconfigura los clones.
        if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
            setupInfiniteSlider();
        }

        // No necesitamos `totalPages` para la generación de dots si siempre son 9.
        // Si necesitas saber cuántas "páginas" lógicas hay para otra cosa, podrías calcularlo aquí.
        // totalPages = Math.ceil(totalCards / cardsPerView); 

        generateDots(); // (Re)genera los puntos de paginación.

        // Reposiciona el slider al inicio del primer grupo de tarjetas originales sin animación.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false);
    };

    /**
     * @function setupInfiniteSlider
     * Configura el track del slider con clones al principio y al final para un bucle infinito.
     */
    const setupInfiniteSlider = () => {
        // Elimina cualquier clon existente antes de añadir nuevos.
        const existingClones = sliderTrack.querySelectorAll('.bloque9__slider--card.clone');
        existingClones.forEach(clone => clone.remove());

        // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
        // Esto es vital antes de añadir los clones.
        sliderTrack.innerHTML = '';
        originalCards.forEach(card => sliderTrack.appendChild(card));

        // El número de clones es igual a `cardsPerView` para un bucle fluido.
        clonedCardsCount = cardsPerView;

        // Clona tarjetas del principio y las añade al final del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[i % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        }

        // Clona tarjetas del final y las añade al principio del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        }

        // Establece el `currentIndex` para que apunte a la primera tarjeta original.
        currentIndex = clonedCardsCount;
    };

    /**
     * @function generateDots
     * Genera dinámicamente los elementos de puntos de paginación. **Ahora siempre 9 dots.**
     */
    const generateDots = () => {
        sliderDotsContainer.innerHTML = ''; // Limpia los puntos existentes.

        // Los puntos corresponden a CADA tarjeta original, por lo tanto, siempre `totalCards` (que es 9).
        for (let i = 0; i < totalCards; i++) { // Bucle hasta totalCards para generar 9 dots.
            const dot = document.createElement('div');
            dot.classList.add('bloque9__dot'); // Usa tu clase para los puntos.

            dot.addEventListener('click', () => {
                // Al hacer clic en un punto, el slider se mueve a la tarjeta individual correspondiente.
                currentIndex = i + clonedCardsCount; // 'i' es el índice de la tarjeta original.
                updateSliderPosition(true);
            });
            sliderDotsContainer.appendChild(dot);
        }
        updateDots(); // Actualiza el estado activo del punto recién generado.
    };

    /**
     * @function updateSliderPosition
     * Actualiza la posición translateX del `sliderTrack` para mostrar la tarjeta actual.
     * @param {boolean} animate - Si la transición debe ser animada.
     */
    const updateSliderPosition = (animate = true) => {
        const firstCard = originalCards[0];
        if (!firstCard) {
            console.warn('No hay tarjetas originales para calcular el ancho.');
            return;
        }

        // Calcula el ancho total de una tarjeta, incluyendo sus márgenes.
        const cardWidth = firstCard.offsetWidth +
            parseFloat(getComputedStyle(firstCard).marginLeft) +
            parseFloat(getComputedStyle(firstCard).marginRight);

        // Calcula el desplazamiento horizontal necesario.
        const offset = -currentIndex * cardWidth;

        // Aplica la transición y el desplazamiento.
        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${offset}px)`;

        updateDots(); // Actualiza el estado de los puntos.
        updateArrows(); // Asegura que las flechas estén habilitadas.
    };

    /**
     * @function updateDots
     * Actualiza la clase 'active' del punto de paginación correspondiente a la tarjeta actual. **Ahora cada dot representa una tarjeta.**
     */
    const updateDots = () => {
        const dots = document.querySelectorAll('.bloque9__dot'); // Selecciona los puntos con la nueva clase.

        // Calcula el índice de la tarjeta real que está actualmente visible.
        // Aquí no se usa `cardsPerView` para los dots, solo el índice de la tarjeta individual.
        const currentRealCardIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;

        dots.forEach((dot, index) => {
            if (index === currentRealCardIndex) { // Compara con el índice real de la tarjeta.
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    /**
     * @function updateArrows
     * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
     */
    const updateArrows = () => {
        prevArrow.disabled = false;
        nextArrow.disabled = false;
    };

    // --- Listeners para la navegación con flechas ---
    nextArrow.addEventListener('click', () => {
        // Siempre avanza el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex++;
        updateSliderPosition(true);
    });

    prevArrow.addEventListener('click', () => {
        // Siempre retrocede el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex--;
        updateSliderPosition(true);
    });

    // --- Listener para el final de la transición (manejo del bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        // Calcula el índice de la tarjeta real actual (sin contar los clones).
        let realCardOffset = currentIndex - clonedCardsCount;

        // Si el slider se ha movido más allá del final de las tarjetas reales (a un clon 'end').
        if (realCardOffset >= totalCards) {
            // Salta instantáneamente a la posición equivalente al principio de las tarjetas reales.
            currentIndex = clonedCardsCount + (realCardOffset % totalCards);
            updateSliderPosition(false); // Sin animación para el salto.
        }
        // Si el slider se ha movido antes del principio de las tarjetas reales (a un clon 'start').
        else if (realCardOffset < 0) {
            // Salta instantáneamente a la posición equivalente al final de las tarjetas reales.
            // Asegura que el índice de destino sea positivo y dentro del rango original.
            let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
            if (targetRealIndex < 0) targetRealIndex += totalCards; // Asegura que sea positivo.

            // No necesitamos alinear a `cardsPerView` aquí para los dots, ya que cada dot es individual.
            // Pero si el salto en el bucle te lleva a una posición que visualmente no es el inicio de un grupo,
            // y quieres que el primer dot visible se active, esta línea podría necesitarse.
            // Por simplicidad, si los dots son 1:1 con las tarjetas, no se necesita.
            // targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView; 

            currentIndex = clonedCardsCount + targetRealIndex;
            updateSliderPosition(false); // Sin animación para el salto.
        }
    });

    // --- Listener para el redimensionamiento de la ventana ---
    window.addEventListener('resize', () => {
        updateCardsPerView(); // Reajusta la vista y los clones. Los dots se regenerarán y serán 9.
        // Después de redimensionar, reposiciona el slider al inicio del primer grupo original.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false); // Sin animación durante el redimensionamiento.
    });

    // --- Inicialización del slider ---
    updateCardsPerView(); // Llama a la función principal para configurar el slider al cargar la página.
});
//- =================================================================
//- =======================FIN BLOQUE9===============================
//- =================================================================


//- =================================================================
//- =========================BLOQUE910=================================
//- =================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Selectores de elementos del DOM con tus clases específicas
    const sliderTrack = document.querySelector('.bloque10__slider--track');
    const originalCards = Array.from(document.querySelectorAll('.bloque10__slider--card'));
    const prevArrow = document.querySelector('.bloque10__prev--arrow');
    const nextArrow = document.querySelector('.bloque10__next--arrow');
    const sliderDotsContainer = document.querySelector('.bloque10__slider--dots');

    // Validación inicial: asegúrate de que todos los elementos existan
    if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
        console.error('Error: Uno o más elementos del slider no fueron encontrados. Revisa que las clases en tu HTML y JavaScript coincidan.');
        return; // Detener la ejecución si faltan elementos cruciales
    }

    // Variables de estado del slider
    let cardsPerView = 1; // Número de tarjetas visibles a la vez (se ajusta con la responsividad)
    const totalCards = originalCards.length; // Cantidad total de tarjetas originales (fija en 9 en tu caso)
    let clonedCardsCount = 0; // Cantidad de tarjetas clonadas a cada lado para el efecto infinito
    let currentIndex = 0; // Índice de la tarjeta activa en el track (incluye clones)

    // Ya no necesitamos `totalPages` como una variable de estado dinámica para los dots,
    // porque siempre serán 9. Pero la mantenemos para depuración si la necesitas.
    // let totalPages = 0; 

    /**
     * @function updateCardsPerView
     * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
     */
    const updateCardsPerView = () => {
        const previousCardsPerView = cardsPerView;

        // Determina cuántas tarjetas se muestran según el ancho de la pantalla
        if (window.innerWidth >= 1024) {
            cardsPerView = 3;
        } else {
            cardsPerView = 1;
        }

        // Si `cardsPerView` ha cambiado o es la primera inicialización, reconfigura los clones.
        if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
            setupInfiniteSlider();
        }

        // No necesitamos `totalPages` para la generación de dots si siempre son 9.
        // Si necesitas saber cuántas "páginas" lógicas hay para otra cosa, podrías calcularlo aquí.
        // totalPages = Math.ceil(totalCards / cardsPerView); 

        generateDots(); // (Re)genera los puntos de paginación.

        // Reposiciona el slider al inicio del primer grupo de tarjetas originales sin animación.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false);
    };

    /**
     * @function setupInfiniteSlider
     * Configura el track del slider con clones al principio y al final para un bucle infinito.
     */
    const setupInfiniteSlider = () => {
        // Elimina cualquier clon existente antes de añadir nuevos.
        const existingClones = sliderTrack.querySelectorAll('.bloque10__slider--card.clone');
        existingClones.forEach(clone => clone.remove());

        // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
        // Esto es vital antes de añadir los clones.
        sliderTrack.innerHTML = '';
        originalCards.forEach(card => sliderTrack.appendChild(card));

        // El número de clones es igual a `cardsPerView` para un bucle fluido.
        clonedCardsCount = cardsPerView;

        // Clona tarjetas del principio y las añade al final del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[i % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-end');
            sliderTrack.appendChild(clone);
        }

        // Clona tarjetas del final y las añade al principio del track.
        for (let i = 0; i < clonedCardsCount; i++) {
            const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
            clone.classList.add('clone', 'clone-start');
            sliderTrack.prepend(clone);
        }

        // Establece el `currentIndex` para que apunte a la primera tarjeta original.
        currentIndex = clonedCardsCount;
    };

    /**
     * @function generateDots
     * Genera dinámicamente los elementos de puntos de paginación. **Ahora siempre 9 dots.**
     */
    const generateDots = () => {
        sliderDotsContainer.innerHTML = ''; // Limpia los puntos existentes.

        // Los puntos corresponden a CADA tarjeta original, por lo tanto, siempre `totalCards` (que es 9).
        for (let i = 0; i < totalCards; i++) { // Bucle hasta totalCards para generar 9 dots.
            const dot = document.createElement('div');
            dot.classList.add('bloque10__dot'); // Usa tu clase para los puntos.

            dot.addEventListener('click', () => {
                // Al hacer clic en un punto, el slider se mueve a la tarjeta individual correspondiente.
                currentIndex = i + clonedCardsCount; // 'i' es el índice de la tarjeta original.
                updateSliderPosition(true);
            });
            sliderDotsContainer.appendChild(dot);
        }
        updateDots(); // Actualiza el estado activo del punto recién generado.
    };

    /**
     * @function updateSliderPosition
     * Actualiza la posición translateX del `sliderTrack` para mostrar la tarjeta actual.
     * @param {boolean} animate - Si la transición debe ser animada.
     */
    const updateSliderPosition = (animate = true) => {
        const firstCard = originalCards[0];
        if (!firstCard) {
            console.warn('No hay tarjetas originales para calcular el ancho.');
            return;
        }

        // Calcula el ancho total de una tarjeta, incluyendo sus márgenes.
        const cardWidth = firstCard.offsetWidth +
            parseFloat(getComputedStyle(firstCard).marginLeft) +
            parseFloat(getComputedStyle(firstCard).marginRight);

        // Calcula el desplazamiento horizontal necesario.
        const offset = -currentIndex * cardWidth;

        // Aplica la transición y el desplazamiento.
        sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
        sliderTrack.style.transform = `translateX(${offset}px)`;

        updateDots(); // Actualiza el estado de los puntos.
        updateArrows(); // Asegura que las flechas estén habilitadas.
    };

    /**
     * @function updateDots
     * Actualiza la clase 'active' del punto de paginación correspondiente a la tarjeta actual. **Ahora cada dot representa una tarjeta.**
     */
    const updateDots = () => {
        const dots = document.querySelectorAll('.bloque10__dot'); // Selecciona los puntos con la nueva clase.

        // Calcula el índice de la tarjeta real que está actualmente visible.
        // Aquí no se usa `cardsPerView` para los dots, solo el índice de la tarjeta individual.
        const currentRealCardIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;

        dots.forEach((dot, index) => {
            if (index === currentRealCardIndex) { // Compara con el índice real de la tarjeta.
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    };

    /**
     * @function updateArrows
     * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
     */
    const updateArrows = () => {
        prevArrow.disabled = false;
        nextArrow.disabled = false;
    };

    // --- Listeners para la navegación con flechas ---
    nextArrow.addEventListener('click', () => {
        // Siempre avanza el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex++;
        updateSliderPosition(true);
    });

    prevArrow.addEventListener('click', () => {
        // Siempre retrocede el slider una tarjeta a la vez, independientemente de `cardsPerView`.
        currentIndex--;
        updateSliderPosition(true);
    });

    // --- Listener para el final de la transición (manejo del bucle infinito) ---
    sliderTrack.addEventListener('transitionend', () => {
        // Calcula el índice de la tarjeta real actual (sin contar los clones).
        let realCardOffset = currentIndex - clonedCardsCount;

        // Si el slider se ha movido más allá del final de las tarjetas reales (a un clon 'end').
        if (realCardOffset >= totalCards) {
            // Salta instantáneamente a la posición equivalente al principio de las tarjetas reales.
            currentIndex = clonedCardsCount + (realCardOffset % totalCards);
            updateSliderPosition(false); // Sin animación para el salto.
        }
        // Si el slider se ha movido antes del principio de las tarjetas reales (a un clon 'start').
        else if (realCardOffset < 0) {
            // Salta instantáneamente a la posición equivalente al final de las tarjetas reales.
            // Asegura que el índice de destino sea positivo y dentro del rango original.
            let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
            if (targetRealIndex < 0) targetRealIndex += totalCards; // Asegura que sea positivo.

            // No necesitamos alinear a `cardsPerView` aquí para los dots, ya que cada dot es individual.
            // Pero si el salto en el bucle te lleva a una posición que visualmente no es el inicio de un grupo,
            // y quieres que el primer dot visible se active, esta línea podría necesitarse.
            // Por simplicidad, si los dots son 1:1 con las tarjetas, no se necesita.
            // targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView; 

            currentIndex = clonedCardsCount + targetRealIndex;
            updateSliderPosition(false); // Sin animación para el salto.
        }
    });

    // --- Listener para el redimensionamiento de la ventana ---
    window.addEventListener('resize', () => {
        updateCardsPerView(); // Reajusta la vista y los clones. Los dots se regenerarán y serán 9.
        // Después de redimensionar, reposiciona el slider al inicio del primer grupo original.
        currentIndex = clonedCardsCount;
        updateSliderPosition(false); // Sin animación durante el redimensionamiento.
    });

    // --- Inicialización del slider ---
    updateCardsPerView(); // Llama a la función principal para configurar el slider al cargar la página.
});
//- =================================================================
//- =======================FIN BLOQUE10===============================
//- =================================================================