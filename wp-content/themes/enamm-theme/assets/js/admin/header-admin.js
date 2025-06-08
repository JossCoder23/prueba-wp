// ARCHIVO: js/enamm-menu-builder.js (en la raíz de tu tema, dentro de la carpeta 'js')

document.addEventListener('DOMContentLoaded', function() {
    alert("Hola")
    const menuBuilderContainer = document.getElementById('enamm-menu-builder-container');
    const menuList = document.getElementById('enamm-menu-sortable');

    console.log('menuBuilderContainer:', menuBuilderContainer);
    console.log('menuList:', menuList);

    // Contador para asegurar nombres de campo únicos cuando se añaden nuevos ítems
    let itemCounter = 0;

    /**
     * Genera el HTML para un nuevo ítem de menú.
     * @param {string} parentFieldName - El nombre del campo del padre (ej. 'enamm_header_nav_menu' o 'enamm_header_nav_menu[0][children]').
     * @param {number} depth - La profundidad del ítem.
     * @param {object} itemData - Datos iniciales para el ítem (opcional).
     * @returns {string} El HTML del ítem.
     */
    function getMenuItemHtml(parentFieldName, depth, itemData) {
        const id = itemCounter++; // Incrementa el contador para un ID único
        const title = itemData && itemData.title ? itemData.title : 'Nuevo Ítem';
        const url = itemData && itemData.url ? itemData.url : '';
        const type = itemData && itemData.type ? itemData.type : 'link';
        const classes = itemData && itemData.classes ? itemData.classes : '';
        const unique_id = 'menu_item_' + id + '_' + Date.now(); // Más robusto

        const urlFieldDisplay = (type === 'heading') ? 'display:none;' : '';

        const html = `
            <li class="enamm-menu-item depth-${depth}" data-item-id="${unique_id}">
                <div class="enamm-menu-item-header">
                    <span class="handle dashicons dashicons-move"></span>
                    <span class="item-title">${title}</span>
                    <button type="button" class="toggle-item-details dashicons dashicons-arrow-down-alt2"></button>
                    <button type="button" class="remove-item button button-small dashicons dashicons-trash"></button>
                </div>
                <div class="enamm-menu-item-details" style="display:none;">
                    <p>
                        <label for="${parentFieldName}[${id}][type]">Tipo de Ítem:</label>
                        <select name="${parentFieldName}[${id}][type]" class="item-type-select">
                            <option value="link" ${type === 'link' ? 'selected' : ''}>Enlace</option>
                            <option value="heading" ${type === 'heading' ? 'selected' : ''}>Título (para submenú)</option>
                        </select>
                    </p>
                    <p>
                        <label for="${parentFieldName}[${id}][title]">Título:</label>
                        <input type="text" name="${parentFieldName}[${id}][title]" value="${title}" class="item-title-input regular-text">
                    </p>
                    <p class="item-url-field" style="${urlFieldDisplay}">
                        <label for="${parentFieldName}[${id}][url]">URL:</label>
                        <input type="url" name="${parentFieldName}[${id}][url]" value="${url}" class="regular-text">
                    </p>
                    <p>
                        <label for="${parentFieldName}[${id}][classes]">Clases CSS Adicionales (separadas por espacio):</label>
                        <input type="text" name="${parentFieldName}[${id}][classes]" value="${classes}" class="regular-text">
                        <span class="description">Ej: \`menuRight__item--enabled\`, \`solo-escritorio\`</span>
                    </p>
                    <button type="button" class="add-subitem button button-secondary">Añadir Sub-ítem</button>
                    <ul class="enamm-submenu-list enamm-menu-list"></ul>
                </div>
            </li>
        `;
        return html;
    }

    /**
     * Inicializa Sortable para un elemento de lista dado.
     * @param {HTMLElement} listElement - El elemento UL o OL que será sortable.
     */
    function initSortable(listElement) {
        if (!listElement) return; // Asegurarse de que el elemento exista

        new Sortable(listElement, {
            animation: 150,
            handle: '.handle',
            group: 'nested', // Permite arrastrar entre listas
            fallbackOnBody: true,
            swapThreshold: 0.65,
            draggable: '.enamm-menu-item', // Asegura que solo los LIs son arrastrables
            onEnd: function (evt) {
                // Cuando se suelta un elemento, actualiza su clase de profundidad
                const item = evt.item;
                const parentList = item.closest('.enamm-menu-list');
                // Determinar la profundidad basada en el número de ancestros .enamm-menu-item
                let depth = 0;
                let currentParent = parentList.parentElement;
                while (currentParent && currentParent.classList.contains('enamm-menu-item')) {
                    depth++;
                    currentParent = currentParent.parentElement.closest('.enamm-menu-item');
                }
                
                item.className = item.className.replace(/(^|\s)depth-\S+/g, '');
                item.classList.add('depth-' + depth);
                reindexFormFields();
            }
        });
    }

    // Llamada inicial para los menús existentes
    initSortable(menuList);
    document.querySelectorAll('.enamm-submenu-list').forEach(function(list) {
        initSortable(list);
    });
     console.log('SortableJS inicializado para listas existentes.');

    // --- Eventos ---

    // Añadir nuevo ítem principal
    document.getElementById('add-menu-item').addEventListener('click', function() {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = getMenuItemHtml('enamm_header_nav_menu', 0);
        const newItem = tempDiv.firstElementChild;
        menuList.appendChild(newItem);
        initSortable(newItem.querySelector('.enamm-submenu-list')); // Inicializar sortable para el nuevo submenú
        reindexFormFields();
    });

    // Añadir sub-ítem
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('add-subitem')) {
            const parentButton = event.target;
            const parentItem = parentButton.closest('.enamm-menu-item');
            const parentList = parentButton.nextElementSibling; // El ul.enamm-submenu-list
            
            let currentDepth = 0;
            const depthMatch = parentItem.className.match(/depth-(\d+)/);
            if (depthMatch) {
                currentDepth = parseInt(depthMatch[1]);
            }
            const newDepth = currentDepth + 1;

            // Obtener el nombre del campo del padre para la indexación
            const parentInput = parentItem.querySelector('input[type="text"]');
            let baseFieldName = '';
            if (parentInput) {
                const parentName = parentInput.getAttribute('name');
                const matches = parentName.match(/^([a-zA-Z_\[\]]+)\[(\d+)\]/);
                if (matches) {
                    baseFieldName = `${matches[1]}[${matches[2]}][children]`;
                } else {
                    // Fallback si no encuentra el patrón (no debería ocurrir con una estructura correcta)
                    baseFieldName = 'enamm_header_nav_menu[new_item][children]'; // Esto será reindexado
                }
            } else {
                 baseFieldName = 'enamm_header_nav_menu[new_item][children]'; // Fallback
            }

            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = getMenuItemHtml(baseFieldName, newDepth);
            const newItem = tempDiv.firstElementChild;
            parentList.appendChild(newItem);
            initSortable(newItem.querySelector('.enamm-submenu-list')); // Inicializar sortable para el nuevo sub-submenú
            reindexFormFields();
        }
    });

     // --- Eventos ---

    const addButton = document.getElementById('add-menu-item');
    console.log('Botón Añadir Ítem:', addButton);

    if (addButton) {
        addButton.addEventListener('click', function() {
            console.log('¡Clic en el botón Añadir Ítem detectado!'); // <-- ¡Aquí!
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = getMenuItemHtml('enamm_header_nav_menu', 0);
            const newItem = tempDiv.firstElementChild;
            
            if (menuList) { // Asegúrate de que menuList existe antes de intentar añadir
                menuList.appendChild(newItem);
                console.log('Nuevo ítem principal añadido al DOM.');
                initSortable(newItem.querySelector('.enamm-submenu-list')); // Inicializar sortable para el nuevo submenú
                reindexFormFields();
                console.log('Campos reindexados.');
            } else {
                console.error('ERROR: #enamm-menu-sortable no encontrado, no se pudo añadir el ítem.');
            }
        });
    } else {
        console.error('ERROR: Botón #add-menu-item no encontrado en el DOM.');
    }


    // Toggle para mostrar/ocultar detalles del ítem
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('toggle-item-details')) {
            const button = event.target;
            const details = button.closest('.enamm-menu-item-header').nextElementSibling; // enamm-menu-item-details

            // Implementación básica de slideToggle nativo
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.transition = 'height 300ms ease-in-out';
                details.style.overflow = 'hidden';
                details.style.height = '0';
                details.style.display = 'block';
                const height = details.scrollHeight + 'px'; // Obtener la altura total
                setTimeout(() => {
                    details.style.height = height;
                }, 10); // Pequeño retraso para que la transición funcione

                details.addEventListener('transitionend', function handler() {
                    details.style.height = ''; // Eliminar altura fija
                    details.style.overflow = '';
                    button.classList.remove('dashicons-arrow-down-alt2');
                    button.classList.add('dashicons-arrow-up-alt2');
                    details.removeEventListener('transitionend', handler);
                });
            } else {
                details.style.transition = 'height 300ms ease-in-out';
                details.style.overflow = 'hidden';
                details.style.height = details.scrollHeight + 'px'; // Establecer altura explícita
                setTimeout(() => {
                    details.style.height = '0';
                }, 10);

                details.addEventListener('transitionend', function handler() {
                    details.style.display = 'none';
                    details.style.height = ''; // Resetear altura
                    details.style.overflow = '';
                    button.classList.remove('dashicons-arrow-up-alt2');
                    button.classList.add('dashicons-arrow-down-alt2');
                    details.removeEventListener('transitionend', handler);
                });
            }
        }
    });

    // Eliminar ítem
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            if (confirm('¿Estás seguro de que quieres eliminar este ítem de menú y todos sus subítems?')) {
                event.target.closest('.enamm-menu-item').remove();
                reindexFormFields();
            }
        }
    });

    // Actualizar título en el encabezado del ítem al escribir
    document.addEventListener('keyup', function(event) {
        if (event.target.classList.contains('item-title-input')) {
            const title = event.target.value;
            const itemHeader = event.target.closest('.enamm-menu-item-details').previousElementSibling; // enamm-menu-item-header
            const itemTitleSpan = itemHeader.querySelector('.item-title');
            itemTitleSpan.textContent = title || 'Nuevo Ítem';
        }
    });

    // Cambiar visibilidad del campo URL según el tipo de ítem
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('item-type-select')) {
            const selectedType = event.target.value;
            const urlField = event.target.closest('p').nextElementSibling; // el <p> con .item-url-field
            const urlInput = urlField.querySelector('input');

            // Implementación básica de slideUp/slideDown nativo
            if (selectedType === 'heading') {
                urlField.style.transition = 'height 200ms ease-in-out, opacity 200ms ease-in-out';
                urlField.style.overflow = 'hidden';
                urlField.style.height = urlField.scrollHeight + 'px'; // Establecer altura explícita
                urlField.style.opacity = '1';
                setTimeout(() => {
                    urlField.style.height = '0';
                    urlField.style.opacity = '0';
                }, 10);

                urlField.addEventListener('transitionend', function handler() {
                    urlField.style.display = 'none';
                    urlField.style.height = ''; // Resetear altura
                    urlField.style.opacity = '';
                    urlField.style.overflow = '';
                    urlInput.value = ''; // Limpiar URL cuando el tipo es heading
                    urlField.removeEventListener('transitionend', handler);
                });
            } else {
                urlField.style.transition = 'height 200ms ease-in-out, opacity 200ms ease-in-out';
                urlField.style.overflow = 'hidden';
                urlField.style.height = '0';
                urlField.style.opacity = '0';
                urlField.style.display = 'block';
                const height = urlField.scrollHeight + 'px';
                setTimeout(() => {
                    urlField.style.height = height;
                    urlField.style.opacity = '1';
                }, 10);

                urlField.addEventListener('transitionend', function handler() {
                    urlField.style.height = ''; // Eliminar altura fija
                    urlField.style.opacity = '';
                    urlField.style.overflow = '';
                    urlField.removeEventListener('transitionend', handler);
                });
            }
        }
    });

    /**
     * Reindexa todos los nombres de los campos del formulario después de añadir/eliminar/reordenar ítems.
     * Esto es CRUCIAL para que WordPress procese correctamente los arrays anidados.
     */
    function reindexFormFields() {
        Array.from(menuList.children).forEach(function(item, index) {
            reindexItem(item, 'enamm_header_nav_menu', index);
        });
    }

    /**
     * Función recursiva para reindexar un ítem y sus hijos.
     * @param {HTMLElement} item - El elemento HTML del ítem de menú.
     * @param {string} parentFieldName - El nombre del campo del padre.
     * @param {number} index - El índice actual del ítem dentro de su lista padre.
     */
    function reindexItem(item, parentFieldName, index) {
        const newFieldName = `${parentFieldName}[${index}]`;

        // Actualizar nombres de campos directos del ítem
        item.querySelectorAll(':scope > .enamm-menu-item-details input, :scope > .enamm-menu-item-details select').forEach(function(input) {
            const currentName = input.getAttribute('name');
            if (currentName) {
                // Extraer el nombre de la propiedad (ej. 'title', 'url', 'type', 'classes')
                const propMatch = currentName.match(/\[(title|url|type|classes)\]$/);
                if (propMatch && propMatch[1]) {
                    const propName = propMatch[1];
                    input.setAttribute('name', `${newFieldName}[${propName}]`);
                    input.setAttribute('id', `${newFieldName}[${propName}]`); // También el ID para las labels
                }
            }
        });

        // Reindexar hijos recursivamente
        const submenuList = item.querySelector(':scope > .enamm-menu-item-details > .enamm-submenu-list');
        if (submenuList) {
            Array.from(submenuList.children).forEach(function(childItem, childIndex) {
                reindexItem(childItem, `${newFieldName}[children]`, childIndex);
            });
        }
    }

    // Llamada inicial para reindexar al cargar la página (útil si hay ítems precargados)
    reindexFormFields();
    console.log('Reindexación inicial de campos completada.');
});