document.addEventListener('DOMContentLoaded', function() {

    // Selecciona todos los contenedores de repetidor de enlaces
    const repeaterContainers = document.querySelectorAll('.enamm-links-repeater-container');

    repeaterContainers.forEach(container => {
        const dataInput = container.querySelector('.enamm-links-data-input');
        const linksList = container.querySelector('.enamm-links-list');
        const addButton = container.querySelector('.enamm-add-link-button');
        const form = dataInput.closest('form');

        let links = [];
        try {
            // Asegúrate de que JSON.parse reciba una cadena JSON válida
            links = JSON.parse(dataInput.value || '[]');
        } catch (e) {
            console.error('Error parsing JSON for links:', e);
            links = [];
        }

        /**
         * Crea y devuelve un elemento HTML para un solo campo de enlace.
         * @param {string} linkText - El texto del enlace.
         * @param {string} linkUrl - La URL del enlace.
         * @returns {HTMLElement} El elemento div que contiene los inputs y el botón.
         */
        function renderLinkField(linkText = '', linkUrl = '') {
            const linkItem = document.createElement('div');
            linkItem.classList.add('enamm-link-item');

            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.classList.add('enamm-link-text', 'large-text');
            textInput.placeholder = 'Texto del Enlace';
            textInput.value = linkText;
            linkItem.appendChild(textInput);

            const urlInput = document.createElement('input');
            urlInput.type = 'url';
            urlInput.classList.add('enamm-link-url', 'large-text');
            urlInput.placeholder = 'URL del Enlace';
            urlInput.value = linkUrl;
            linkItem.appendChild(urlInput);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.classList.add('button', 'button-secondary', 'enamm-remove-link-button');
            removeButton.textContent = 'Eliminar';
            linkItem.appendChild(removeButton);

            return linkItem;
        }

        /**
         * Actualiza el valor del input oculto con los datos actuales de los enlaces.
         */
        function updateDataInput() {
            const currentLinks = [];
            linksList.querySelectorAll('.enamm-link-item').forEach(item => {
                const text = item.querySelector('.enamm-link-text').value;
                const url = item.querySelector('.enamm-link-url').value;
                if (text || url) { // Solo añadir si hay texto o URL
                    currentLinks.push({ text: text, url: url });
                }
            });
            dataInput.value = JSON.stringify(currentLinks);
        }

        // Renderizar enlaces existentes al cargar la página
        if (links.length > 0) {
            links.forEach(link => {
                linksList.appendChild(renderLinkField(link.text, link.url));
            });
        } else {
            // Si no hay enlaces, añadir uno vacío por defecto para que sea más fácil empezar
            linksList.appendChild(renderLinkField());
        }

        // --- Event Listeners ---

        // Evento para añadir un nuevo enlace
        addButton.addEventListener('click', function() {
            linksList.appendChild(renderLinkField());
            updateDataInput(); // Actualizar el input oculto después de añadir
        });

        // Evento para eliminar un enlace (usa delegación de eventos)
        linksList.addEventListener('click', function(event) {
            if (event.target.classList.contains('enamm-remove-link-button')) {
                event.target.closest('.enamm-link-item').remove();
                updateDataInput(); // Actualizar el input oculto después de eliminar
            }
        });

        // Evento para actualizar el input oculto cuando los valores de los inputs cambian (usa delegación de eventos)
        linksList.addEventListener('input', function(event) {
            if (event.target.classList.contains('enamm-link-text') || event.target.classList.contains('enamm-link-url')) {
                updateDataInput();
            }
        });

        // Asegurarse de que el input oculto se actualice justo antes de enviar el formulario
        if (form) {
            form.addEventListener('submit', updateDataInput);
        }
    });
});