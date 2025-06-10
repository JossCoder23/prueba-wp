document.addEventListener('DOMContentLoaded', function() {
    const mobileButton = document.querySelector('.header__buttonMobile');
    const headerMenu = document.querySelector('.header__menu');
    // Selecciona los títulos de los ítems con submenú
    const menuItemsWithSubmenus = document.querySelectorAll('.menuRight__item h3');

    // --- Lógica para el botón de hamburguesa y el menú principal ---
    if (mobileButton && headerMenu) {
        mobileButton.addEventListener('click', function() {
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
    menuItemsWithSubmenus.forEach(function(h3) {
        h3.addEventListener('click', function() {
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

document.addEventListener('DOMContentLoaded', () => {
    const sliderContainer = document.querySelector('.bloque2__slider--container');
    const sliderTrack = document.querySelector('.bloque2__slider--track');
    const sliderContents = document.querySelectorAll('.bloque2__card--content'); // Selecciona los elementos de contenido directamente
    const prevArrow = document.querySelector('.bloque2__slider--arrow--left');
    const nextArrow = document.querySelector('.bloque2__slider--arrow--right');

    let currentIndex = 0;
    const desktopBreakpoint = 1020; // Define tu breakpoint para escritorio

    // --- Funciones para la Lógica del Slider ---

    function updateBackgroundImage() {
        const isMobile = window.innerWidth < desktopBreakpoint;
        sliderContents.forEach(content => { // Itera sobre los elementos de contenido
            let imageUrl = isMobile ? content.dataset.bgImageMobile : content.dataset.bgImageDesktop;
            if (imageUrl) {
                content.style.backgroundImage = `url('${imageUrl}')`;
            } else {
                content.style.backgroundImage = 'none';
            }
        });
    }

    function moveToSlide(index) {
        // Solo mover si estamos en vista móvil (slider activo)
        if (window.innerWidth >= desktopBreakpoint || !sliderTrack || sliderContents.length === 0) {
            return;
        }

        if (index < 0) {
            currentIndex = sliderContents.length - 1; // Volver al último slide
        } else if (index >= sliderContents.length) {
            currentIndex = 0; // Volver al primer slide
        } else {
            currentIndex = index;
        }

        // El desplazamiento se basa en el ancho de la .bloque2__slider--card (que es 100vw en móvil)
        // Ya que cada .bloque2__slider--card es una "slide"
        if (sliderContents.length > 0) {
            const slideWidth = document.querySelector('.bloque2__slider--card').offsetWidth;
            const offset = -currentIndex * slideWidth;
            sliderTrack.style.transform = `translateX(${offset}px)`;
        }
    }

    // --- Lógica de Inicialización y Redimensionamiento ---

    function initializeBloque2() {
        updateBackgroundImage(); // Aplica las imágenes de fondo correctas
        const isMobile = window.innerWidth < desktopBreakpoint;

        // Mostrar/ocultar elementos del slider y activar/desactivar su funcionalidad
        if (isMobile) {
            // Activar modo slider
            sliderTrack.style.transition = 'transform 0.5s ease-in-out';
            sliderTrack.style.display = 'flex'; // Asegura que el track sea flex
            moveToSlide(currentIndex); // Posiciona el slider en el slide actual
            if (prevArrow) prevArrow.style.display = 'block';
            if (nextArrow) nextArrow.style.display = 'block';
            // Ajustar el ancho de las .bloque2__slider--card para que sean 100vw
            document.querySelectorAll('.bloque2__slider--card').forEach(card => {
                card.style.width = '100vw';
            });
        } else {
            // Desactivar modo slider
            sliderTrack.style.transform = 'none'; // Elimina cualquier transformación de slider
            sliderTrack.style.transition = 'none'; // Desactiva la transición
            sliderTrack.style.display = 'contents'; // Permite que el grid padre controle el layout
            if (prevArrow) prevArrow.style.display = 'none';
            if (nextArrow) nextArrow.style.display = 'none';
            // Asegurarse de que las .bloque2__slider--card tengan ancho automático para el grid
            document.querySelectorAll('.bloque2__slider--card').forEach(card => {
                card.style.width = 'auto';
            });
            currentIndex = 0; // Reiniciar índice para la próxima transición a móvil
        }
    }

    // --- Event Listeners ---
    if (prevArrow) {
        prevArrow.addEventListener('click', () => moveToSlide(currentIndex - 1));
    }
    if (nextArrow) {
        nextArrow.addEventListener('click', () => moveToSlide(currentIndex + 1));
    }

    // Inicializar al cargar la página
    initializeBloque2();

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            initializeBloque2();
        }, 250); // Debounce para optimizar el rendimiento al redimensionar
    });
});

//- =================================================================
//- =========================BLOQUE3=================================
//- =================================================================
// document.addEventListener('DOMContentLoaded', () => {
//     const sliderTrack = document.querySelector('.bloque3__slider--track');
//     const originalCards = Array.from(document.querySelectorAll('.bloque3__slider--card'));
//     const prevArrow = document.querySelector('.bloque3__prev--arrow');
//     const nextArrow = document.querySelector('.bloque3__next--arrow');
//     const sliderDotsContainer = document.querySelector('.bloque3__slider--dots');

//     if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
//         console.error('Uno o más elementos del slider no fueron encontrados. Asegúrate de que tu HTML esté bien estructurado.');
//         return; 
//     }
//     console.log('Todos los elementos del slider encontrados.');
//     console.log('Número de tarjetas originales:', originalCards.length);

//     let cardsPerView = 1;
//     let totalCards = originalCards.length;
//     let clonedCardsCount = 0;
//     let currentIndex = 0;
//     let totalPages = 0;

//     const updateCardsPerView = () => {
//         const previousCardsPerView = cardsPerView;

//         if (window.innerWidth >= 1024) {
//             cardsPerView = 3;
//         } else if (window.innerWidth >= 768) {
//             cardsPerView = 3;
//         } else {
//             cardsPerView = 1;
//         }
//         console.log('cardsPerView actualizado a:', cardsPerView);

//         if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
//             setupInfiniteSlider();
//         }
        
//         totalPages = Math.ceil(totalCards / cardsPerView);
//         console.log('Total de tarjetas:', totalCards, 'Tarjetas por vista:', cardsPerView, 'Total de páginas (dots):', totalPages);

//         generateDots();
//         currentIndex = clonedCardsCount; 
//         updateSliderPosition(false);
//     };

//     const setupInfiniteSlider = () => {
//         const existingClones = sliderTrack.querySelectorAll('.clone');
//         existingClones.forEach(clone => clone.remove());
//         console.log('Clones existentes eliminados.');

//         clonedCardsCount = cardsPerView; 
//         totalCards = originalCards.length;

//         sliderTrack.innerHTML = '';
//         originalCards.forEach(card => sliderTrack.appendChild(card));
//         console.log('Tarjetas originales añadidas al track.');

//         for (let i = 0; i < clonedCardsCount; i++) {
//             const clone = originalCards[i % totalCards].cloneNode(true);
//             clone.classList.add('clone', 'clone-end');
//             sliderTrack.appendChild(clone);
//         }
//         console.log(`${clonedCardsCount} clones añadidos al final.`);

//         for (let i = 0; i < clonedCardsCount; i++) {
//             const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
//             clone.classList.add('clone', 'clone-start');
//             sliderTrack.prepend(clone);
//         }
//         console.log(`${clonedCardsCount} clones añadidos al principio.`);

//         currentIndex = clonedCardsCount; 
//         console.log('currentIndex inicializado a (con clones):', currentIndex);
//     };

//     const generateDots = () => {
//         sliderDotsContainer.innerHTML = '';
//         console.log('Generando dots. Total páginas:', totalPages);
//         for (let i = 0; i < totalPages; i++) {
//             const dot = document.createElement('div');
//             dot.classList.add('bloque3__dot'); // Changed from 'dot' to 'bloque3__dot'
//             dot.addEventListener('click', () => {
//                 currentIndex = (i * cardsPerView) + clonedCardsCount;
//                 console.log('Dot clicado. Yendo al currentIndex (con clones):', currentIndex);
//                 updateSliderPosition(true);
//             });
//             sliderDotsContainer.appendChild(dot);
//             console.log('Dot creado y añadido:', i + 1);
//         }
//         updateDots();
//     };

//     const updateSliderPosition = (animate = true) => {
//         const firstCard = originalCards[0];
//         if (!firstCard) {
//             console.warn('No hay tarjetas para calcular el ancho.');
//             return;
//         }
        
//         const cardStyle = getComputedStyle(firstCard);
//         const cardWidth = firstCard.offsetWidth + 
//                           parseFloat(cardStyle.marginLeft) + 
//                           parseFloat(cardStyle.marginRight);

//         const offset = -currentIndex * cardWidth;

//         sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
//         sliderTrack.style.transform = `translateX(${offset}px)`;
//         console.log(`Slider posicionado a translateX(${offset}px) para currentIndex: ${currentIndex}`);

//         updateDots();
//         updateArrows();
//     };

//     const updateDots = () => {
//         const dots = document.querySelectorAll('.bloque3__dot'); // Changed from '.dot' to '.bloque3__dot'
//         const currentRealIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;
//         const currentPageIndex = Math.floor(currentRealIndex / cardsPerView);

//         console.log('Actualizando dots. currentIndex (con clones):', currentIndex, ' -> currentRealIndex:', currentRealIndex, ' -> currentPageIndex:', currentPageIndex);

//         dots.forEach((dot, index) => {
//             if (index === currentPageIndex) {
//                 dot.classList.add('active');
//             } else {
//                 dot.classList.remove('active');
//             }
//         });
//     };

//     const updateArrows = () => {
//         prevArrow.disabled = false;
//         nextArrow.disabled = false;
//     };

//     nextArrow.addEventListener('click', () => {
//         currentIndex += cardsPerView;
//         console.log('Next clicado. Nuevo currentIndex:', currentIndex);
//         updateSliderPosition(true);
//     });

//     prevArrow.addEventListener('click', () => {
//         currentIndex -= cardsPerView;
//         console.log('Prev clicado. Nuevo currentIndex:', currentIndex);
//         updateSliderPosition(true);
//     });

//     sliderTrack.addEventListener('transitionend', () => {
//         let realCardOffset = currentIndex - clonedCardsCount;

//         if (realCardOffset >= totalCards) {
//             currentIndex = clonedCardsCount + (realCardOffset % totalCards);
//             console.log('Límite final alcanzado, saltando a currentIndex:', currentIndex);
//             updateSliderPosition(false);
//         } else if (realCardOffset < 0) {
//             let targetRealIndex = (totalCards - ((-realCardOffset) % totalCards)) % totalCards;
//             if (targetRealIndex === 0 && realCardOffset < 0 && Math.abs(realCardOffset) >= totalCards) {
//                  targetRealIndex = totalCards;
//             }

//             targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView;
//             currentIndex = clonedCardsCount + targetRealIndex;

//             console.log('Límite inicial alcanzado, saltando a currentIndex:', currentIndex);
//             updateSliderPosition(false);
//         }
//     });

//     window.addEventListener('resize', () => {
//         console.log('Ventana redimensionada.');
//         updateCardsPerView();
//         currentIndex = clonedCardsCount; 
//         updateSliderPosition(false); 
//     });

//     updateCardsPerView();
// });
// document.addEventListener('DOMContentLoaded', () => {
//     const sliderTrack = document.querySelector('.bloque3__slider--track');
//     const originalCards = Array.from(document.querySelectorAll('.bloque3__slider--card'));
//     const prevArrow = document.querySelector('.bloque3__prev--arrow');
//     const nextArrow = document.querySelector('.bloque3__next--arrow');
//     const sliderDotsContainer = document.querySelector('.bloque3__slider--dots');

//     if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
//         console.error('Uno o más elementos del slider no fueron encontrados. Asegúrate de que tu HTML esté bien estructurado.');
//         return; 
//     }
//     console.log('Todos los elementos del slider encontrados.');
//     console.log('Número de tarjetas originales:', originalCards.length);

//     let cardsPerView = 1;
//     let totalCards = originalCards.length;
//     let clonedCardsCount = 0;
//     let currentIndex = 0;
//     let totalPages = 0;

//     // Función para actualizar el número de tarjetas visibles y configurar el slider
//     const updateCardsPerView = () => {
//         const previousCardsPerView = cardsPerView;

//         if (window.innerWidth >= 1024) {
//             cardsPerView = 3;
//         } else if (window.innerWidth >= 768) {
//             cardsPerView = 3; // Mantener en 3 para tablets/escritorio intermedio
//         } else {
//             cardsPerView = 1;
//         }
//         console.log('cardsPerView actualizado a:', cardsPerView);

//         // Si cardsPerView cambia o es la primera vez, reconfiguramos los clones
//         if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
//             setupInfiniteSlider();
//         }
        
//         // El totalPages se calcula en base a los GRUPOS de tarjetas (cardsPerView)
//         totalPages = Math.ceil(totalCards / cardsPerView);
//         console.log('Total de tarjetas:', totalCards, 'Tarjetas por vista:', cardsPerView, 'Total de páginas (dots):', totalPages);

//         generateDots();
//         // Asegúrate de que el currentIndex esté en una posición válida después de cambiar cardsPerView
//         // Volvemos al inicio del primer grupo de tarjetas reales
//         currentIndex = clonedCardsCount; 
//         updateSliderPosition(false); // No transicionar al inicio
//     };

//     // Configura el slider para el efecto infinito (duplica tarjetas)
//     const setupInfiniteSlider = () => {
//         // Limpiar duplicados previos si los hay
//         const existingClones = sliderTrack.querySelectorAll('.clone');
//         existingClones.forEach(clone => clone.remove());
//         console.log('Clones existentes eliminados.');

//         // El número de clones debe ser al menos cardsPerView para un buen bucle,
//         // o más si necesitas un buffer más grande. Usaremos cardsPerView.
//         clonedCardsCount = cardsPerView; 
//         totalCards = originalCards.length;

//         // Limpiar el track y añadir las tarjetas originales de nuevo para asegurar el orden
//         sliderTrack.innerHTML = '';
//         originalCards.forEach(card => sliderTrack.appendChild(card));
//         console.log('Tarjetas originales añadidas al track.');

//         // Clonar tarjetas al final para el inicio virtual
//         for (let i = 0; i < clonedCardsCount; i++) {
//             const clone = originalCards[i % totalCards].cloneNode(true);
//             clone.classList.add('clone', 'clone-end');
//             sliderTrack.appendChild(clone);
//         }
//         console.log(`${clonedCardsCount} clones añadidos al final.`);

//         // Clonar tarjetas al principio para el final virtual
//         for (let i = 0; i < clonedCardsCount; i++) {
//             const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
//             clone.classList.add('clone', 'clone-start');
//             sliderTrack.prepend(clone);
//         }
//         console.log(`${clonedCardsCount} clones añadidos al principio.`);

//         // Ajustar el currentIndex para que la primera tarjeta real esté visible
//         // currentIndex ahora incluye las tarjetas clonadas al inicio
//         currentIndex = clonedCardsCount; // Empieza en la primera tarjeta real
//         console.log('currentIndex inicializado a (con clones):', currentIndex);
//     };

//     // Generar los botones de paginación (puntos)
//     const generateDots = () => {
//         sliderDotsContainer.innerHTML = ''; // Limpiar puntos existentes
//         console.log('Generando dots. Total páginas:', totalPages);
//         for (let i = 0; i < totalPages; i++) { // Iterar sobre el número de páginas
//             const dot = document.createElement('div');
//             dot.classList.add('bloque3__dot'); // Usando la clase renombrada
//             dot.addEventListener('click', () => {
//                 // Al hacer clic en un dot, vamos directamente al inicio de ese grupo de tarjetas
//                 currentIndex = (i * cardsPerView) + clonedCardsCount;
//                 console.log('Dot clicado. Yendo al currentIndex (con clones):', currentIndex);
//                 updateSliderPosition(true);
//             });
//             sliderDotsContainer.appendChild(dot);
//             console.log('Dot creado y añadido:', i + 1);
//         }
//         updateDots(); // Asegura que el dot activo se establezca al generarlos
//     };

//     // Actualizar la posición del slider
//     const updateSliderPosition = (animate = true) => {
//         // Asegúrate de que las tarjetas tienen un ancho definido para calcular offset
//         const firstCard = originalCards[0];
//         if (!firstCard) {
//             console.warn('No hay tarjetas para calcular el ancho.');
//             return;
//         }
        
//         const cardStyle = getComputedStyle(firstCard);
//         const cardWidth = firstCard.offsetWidth + 
//                           parseFloat(cardStyle.marginLeft) + 
//                           parseFloat(cardStyle.marginRight);

//         // El offset se basa en el currentIndex (que incluye los clones) y el ancho de la tarjeta
//         const offset = -currentIndex * cardWidth;

//         sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
//         sliderTrack.style.transform = `translateX(${offset}px)`;
//         console.log(`Slider posicionado a translateX(${offset}px) para currentIndex: ${currentIndex}`);

//         updateDots();
//         updateArrows();
//     };

//     // Actualizar el estado activo de los puntos
//     const updateDots = () => {
//         const dots = document.querySelectorAll('.bloque3__dot'); // Usando la clase renombrada
//         // Calcula el índice de la "página" actual
//         // currentRealIndex es el índice de la primera tarjeta REAL visible
//         const currentRealIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;
//         // currentPageIndex es el índice del dot que debe estar activo
//         const currentPageIndex = Math.floor(currentRealIndex / cardsPerView);

//         console.log('Actualizando dots. currentIndex (con clones):', currentIndex, ' -> currentRealIndex:', currentRealIndex, ' -> currentPageIndex:', currentPageIndex);

//         dots.forEach((dot, index) => {
//             if (index === currentPageIndex) {
//                 dot.classList.add('active');
//             } else {
//                 dot.classList.remove('active');
//             }
//         });
//     };

//     // Las flechas siempre están habilitadas en un slider infinito
//     const updateArrows = () => {
//         prevArrow.disabled = false;
//         nextArrow.disabled = false;
//     };

//     // Navegación con flechas
//     nextArrow.addEventListener('click', () => {
//         // *** CAMBIO CLAVE AQUÍ: Siempre avanza de 1 en 1 ***
//         currentIndex++; 
//         console.log('Next clicado. Nuevo currentIndex:', currentIndex);
//         updateSliderPosition(true);
//     });

//     prevArrow.addEventListener('click', () => {
//         // *** CAMBIO CLAVE AQUÍ: Siempre retrocede de 1 en 1 ***
//         currentIndex--; 
//         console.log('Prev clicado. Nuevo currentIndex:', currentIndex);
//         updateSliderPosition(true);
//     });

//     // Listener para el final de la transición
//     // Aquí es donde hacemos el "salto" instantáneo para el bucle infinito
//     sliderTrack.addEventListener('transitionend', () => {
//         // Calcular el índice de la primera tarjeta real visible
//         let realCardOffset = currentIndex - clonedCardsCount;

//         // Si estamos en una tarjeta clonada del final (al ir hacia adelante)
//         if (realCardOffset >= totalCards) {
//             // Saltamos al índice real equivalente al principio de las tarjetas originales
//             currentIndex = clonedCardsCount + (realCardOffset % totalCards);
//             console.log('Límite final alcanzado, saltando a currentIndex:', currentIndex);
//             updateSliderPosition(false); // Sin animación para el salto
//         }
//         // Si estamos en una tarjeta clonada del inicio (al ir hacia atrás)
//         else if (realCardOffset < 0) {
//             // Saltamos al índice real equivalente al final de las tarjetas originales
//             let targetRealIndex = (totalCards - ((-realCardOffset) % totalCards)) % totalCards;
            
//             // Caso especial si el salto hacia atrás nos lleva exactamente a la última tarjeta real
//             if (targetRealIndex === 0 && realCardOffset < 0 && Math.abs(realCardOffset) >= totalCards) {
//                  targetRealIndex = totalCards; 
//             }
            
//             // Para asegurar que el dot se actualice correctamente cuando se muestra un grupo,
//             // aunque las flechas avancen de 1 en 1, el dot se activa por grupos.
//             // Aseguramos que el targetRealIndex sea el inicio de un grupo válido.
//             targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView;
            
//             currentIndex = clonedCardsCount + targetRealIndex;
//             console.log('Límite inicial alcanzado, saltando a currentIndex:', currentIndex);
//             updateSliderPosition(false); // Sin animación para el salto
//         }
//     });

//     // Event listener para redimensionamiento de la ventana
//     window.addEventListener('resize', () => {
//         console.log('Ventana redimensionada.');
//         updateCardsPerView(); // Esto reajustará el slider y los puntos
//         // Después de redimensionar, el currentIndex debe apuntar al inicio del primer grupo de tarjetas originales
//         currentIndex = clonedCardsCount; 
//         updateSliderPosition(false); // Sin animación en el resize
//     });

//     // Inicialización del slider
//     updateCardsPerView(); // Esto llamará a setupInfiniteSlider, generateDots y updateSliderPosition
// });
// document.addEventListener('DOMContentLoaded', () => {
//     // Selectores de elementos del DOM con tus clases específicas
//     const sliderTrack = document.querySelector('.bloque3__slider--track');
//     const originalCards = Array.from(document.querySelectorAll('.bloque3__slider--card'));
//     const prevArrow = document.querySelector('.bloque3__prev--arrow');
//     const nextArrow = document.querySelector('.bloque3__next--arrow');
//     const sliderDotsContainer = document.querySelector('.bloque3__slider--dots');

//     // Validación inicial: asegúrate de que todos los elementos existan
//     if (!sliderTrack || !originalCards.length || !prevArrow || !nextArrow || !sliderDotsContainer) {
//         console.error('Error: Uno o más elementos del slider no fueron encontrados. Revisa que las clases en tu HTML y JavaScript coincidan.');
//         return; // Detener la ejecución si faltan elementos cruciales
//     }

//     // Variables de estado del slider
//     let cardsPerView = 1; // Número de tarjetas visibles a la vez (se ajusta con la responsividad)
//     let totalCards = originalCards.length; // Cantidad total de tarjetas originales
//     let clonedCardsCount = 0; // Cantidad de tarjetas clonadas a cada lado para el efecto infinito
//     let currentIndex = 0; // Índice de la tarjeta activa en el track (incluye clones)
//     let totalPages = 0; // Número de "páginas" o grupos de tarjetas para los puntos

//     /**
//      * @function updateCardsPerView
//      * Ajusta `cardsPerView` según el ancho de la ventana y reconfigura el slider.
//      */
//     const updateCardsPerView = () => {
//         const previousCardsPerView = cardsPerView;

//         // Determina cuántas tarjetas se muestran según el ancho de la pantalla
//         if (window.innerWidth >= 1024) {
//             cardsPerView = 3;
//         } else if (window.innerWidth >= 768) {
//             cardsPerView = 3;
//         } else {
//             cardsPerView = 1;
//         }

//         // Si `cardsPerView` ha cambiado o es la primera inicialización, reconfigura los clones.
//         if (cardsPerView !== previousCardsPerView || clonedCardsCount === 0) {
//             setupInfiniteSlider();
//         }
        
//         // Calcula el número total de "páginas" (grupos de tarjetas) para los puntos.
//         totalPages = Math.ceil(totalCards / cardsPerView);
        
//         generateDots(); // (Re)genera los puntos de paginación.
        
//         // Reposiciona el slider al inicio del primer grupo de tarjetas originales sin animación.
//         currentIndex = clonedCardsCount; 
//         updateSliderPosition(false);
//     };

//     /**
//      * @function setupInfiniteSlider
//      * Configura el track del slider con clones al principio y al final para un bucle infinito.
//      */
//     const setupInfiniteSlider = () => {
//         // Elimina cualquier clon existente antes de añadir nuevos.
//         const existingClones = sliderTrack.querySelectorAll('.bloque3__slider--card.clone');
//         existingClones.forEach(clone => clone.remove());

//         // Limpia el track y añade las tarjetas originales de nuevo para asegurar el orden.
//         sliderTrack.innerHTML = '';
//         originalCards.forEach(card => sliderTrack.appendChild(card));

//         // El número de clones es igual a `cardsPerView` para un bucle fluido.
//         clonedCardsCount = cardsPerView; 

//         // Clona tarjetas del principio y las añade al final del track (para el "salto" hacia adelante).
//         for (let i = 0; i < clonedCardsCount; i++) {
//             const clone = originalCards[i % totalCards].cloneNode(true);
//             clone.classList.add('clone', 'clone-end');
//             sliderTrack.appendChild(clone);
//         }

//         // Clona tarjetas del final y las añade al principio del track (para el "salto" hacia atrás).
//         for (let i = 0; i < clonedCardsCount; i++) {
//             const clone = originalCards[(totalCards - 1 - i + totalCards) % totalCards].cloneNode(true);
//             clone.classList.add('clone', 'clone-start');
//             sliderTrack.prepend(clone);
//         }

//         // Establece el `currentIndex` para que apunte a la primera tarjeta original (después de los clones iniciales).
//         currentIndex = clonedCardsCount;
//     };

//     /**
//      * @function generateDots
//      * Genera dinámicamente los elementos de puntos de paginación.
//      */
//     const generateDots = () => {
//         sliderDotsContainer.innerHTML = ''; // Limpia los puntos existentes.
        
//         // Crea un punto por cada "página" (grupo de `cardsPerView` tarjetas).
//         for (let i = 0; i < totalPages; i++) {
//             const dot = document.createElement('div');
//             dot.classList.add('bloque3__dot'); // Usa tu nueva clase para los puntos.

//             dot.addEventListener('click', () => {
//                 // Al hacer clic en un punto, el slider se mueve al inicio del grupo de tarjetas correspondiente.
//                 currentIndex = (i * cardsPerView) + clonedCardsCount;
//                 updateSliderPosition(true);
//             });
//             sliderDotsContainer.appendChild(dot);
//         }
//         updateDots(); // Actualiza el estado activo del punto recién generado.
//     };

//     /**
//      * @function updateSliderPosition
//      * Actualiza la posición translateX del `sliderTrack` para mostrar la tarjeta actual.
//      * @param {boolean} animate - Si la transición debe ser animada.
//      */
//     const updateSliderPosition = (animate = true) => {
//         const firstCard = originalCards[0];
//         if (!firstCard) {
//             console.warn('No hay tarjetas originales para calcular el ancho.');
//             return;
//         }
        
//         // Calcula el ancho total de una tarjeta, incluyendo sus márgenes.
//         const cardWidth = firstCard.offsetWidth + 
//                           parseFloat(getComputedStyle(firstCard).marginLeft) + 
//                           parseFloat(getComputedStyle(firstCard).marginRight);
        
//         // Calcula el desplazamiento horizontal necesario.
//         const offset = -currentIndex * cardWidth;

//         // Aplica la transición y el desplazamiento.
//         sliderTrack.style.transition = animate ? 'transform 0.5s ease-in-out' : 'none';
//         sliderTrack.style.transform = `translateX(${offset}px)`;

//         updateDots(); // Actualiza el estado de los puntos.
//         updateArrows(); // Asegura que las flechas estén habilitadas.
//     };

//     /**
//      * @function updateDots
//      * Actualiza la clase 'active' del punto de paginación correspondiente a la vista actual.
//      */
//     const updateDots = () => {
//         const dots = document.querySelectorAll('.bloque3__dot'); // Selecciona los puntos con la nueva clase.
        
//         // Calcula el índice de la tarjeta real más a la izquierda que es visible.
//         const currentRealIndex = (currentIndex - clonedCardsCount + totalCards) % totalCards;
        
//         // Calcula el índice de la "página" o grupo actual para activar el dot correcto.
//         const currentPageIndex = Math.floor(currentRealIndex / cardsPerView);

//         dots.forEach((dot, index) => {
//             if (index === currentPageIndex) {
//                 dot.classList.add('active');
//             } else {
//                 dot.classList.remove('active');
//             }
//         });
//     };

//     /**
//      * @function updateArrows
//      * Asegura que las flechas de navegación no estén deshabilitadas en un slider infinito.
//      */
//     const updateArrows = () => {
//         prevArrow.disabled = false;
//         nextArrow.disabled = false;
//     };

//     // --- Listeners para la navegación con flechas ---
//     nextArrow.addEventListener('click', () => {
//         // Siempre avanza el slider una tarjeta a la vez, independientemente de `cardsPerView`.
//         currentIndex++; 
//         updateSliderPosition(true);
//     });

//     prevArrow.addEventListener('click', () => {
//         // Siempre retrocede el slider una tarjeta a la vez, independientemente de `cardsPerView`.
//         currentIndex--; 
//         updateSliderPosition(true);
//     });

//     // --- Listener para el final de la transición (manejo del bucle infinito) ---
//     sliderTrack.addEventListener('transitionend', () => {
//         // Calcula el índice de la tarjeta real actual (sin contar los clones).
//         let realCardOffset = currentIndex - clonedCardsCount;

//         // Si el slider se ha movido más allá del final de las tarjetas reales (a un clon 'end').
//         if (realCardOffset >= totalCards) {
//             // Salta instantáneamente a la posición equivalente al principio de las tarjetas reales.
//             currentIndex = clonedCardsCount + (realCardOffset % totalCards);
//             updateSliderPosition(false); // Sin animación para el salto.
//         }
//         // Si el slider se ha movido antes del principio de las tarjetas reales (a un clon 'start').
//         else if (realCardOffset < 0) {
//             // Salta instantáneamente a la posición equivalente al final de las tarjetas reales.
//             // La lógica asegura que el destino sea el inicio de un grupo completo de tarjetas.
//             let targetRealIndex = (totalCards + (realCardOffset % totalCards)) % totalCards;
//             if (targetRealIndex < 0) targetRealIndex += totalCards; // Asegura que sea positivo.

//             // Alinear `targetRealIndex` al inicio del grupo para mantener la consistencia con los dots.
//             targetRealIndex = Math.floor(targetRealIndex / cardsPerView) * cardsPerView;

//             currentIndex = clonedCardsCount + targetRealIndex;
//             updateSliderPosition(false); // Sin animación para el salto.
//         }
//     });

//     // --- Listener para el redimensionamiento de la ventana ---
//     window.addEventListener('resize', () => {
//         updateCardsPerView(); // Reajusta la vista, los clones y los puntos.
//         // Después de redimensionar, reposiciona el slider al inicio del primer grupo original.
//         currentIndex = clonedCardsCount;
//         updateSliderPosition(false); // Sin animación durante el redimensionamiento.
//     });

//     // --- Inicialización del slider ---
//     updateCardsPerView(); // Llama a la función principal para configurar el slider al cargar la página.
// });
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
        } else if (window.innerWidth >= 768) {
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