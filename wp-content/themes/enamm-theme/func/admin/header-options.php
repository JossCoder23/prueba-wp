<?php

/**
 * ESTE CODIGO ES PARA EL BACKEND
 */

// 1. Registrar la página de opciones del header en el menú de administración
function enamm_add_header_options_page() {
    add_menu_page(
        'Opciones del Header', // Título de la página
        'Header',              // Texto en el menú de administración
        'manage_options',      // Capacidad de usuario requerida
        'enamm-header-options', // Slug único de la página
        'enamm_header_options_page_html', // Función que renderiza el contenido
        'dashicons-align-wide', // Icono de Dashicon
        55                     // Posición en el menú (antes del Footer)
    );
}
add_action( 'admin_menu', 'enamm_add_header_options_page' );


// Encolar scripts y estilos para el backend (para la gestión del menú)
function enamm_enqueue_admin_header_scripts() {
    // Asegúrate de que este script solo se carga en tu página de opciones
    if ( 'toplevel_page_enamm-header-options' === get_current_screen()->id ) {
         wp_enqueue_script(
            'sortablejs', // Un identificador único para el script
            'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', // URL del CDN
            array(), // SortableJS no tiene dependencias (al menos, no de jQuery)
            '1.15.0', // Versión de SortableJS
            true // Cargar el script en el footer
        );
        wp_enqueue_script(
            'enamm-menu-builder',
            get_template_directory_uri() . '/assets/js/admin/header-admin.js', // ¡Crearemos este archivo!
            array(), // Necesitamos jQuery UI Sortable para arrastrar y soltar
            '1.0',
            true
        );
        wp_enqueue_style(
            'enamm-admin-styles',
            get_template_directory_uri() . '/assets/css/admin/admin-header.css', // ¡Crearemos este archivo!
            array(),
            '1.0'
        );
    }
}
add_action( 'admin_enqueue_scripts', 'enamm_enqueue_admin_header_scripts' );

//- =========================================================
//- BACKEND ACA =============================================
//- =========================================================

/**
 * Descripción: Define los campos y la interfaz para la página de opciones del header,
 * incluyendo la gestión de un menú anidado personalizado.
 */

// Registrar los ajustes y campos para las opciones del header
function enamm_header_options_init() {
    // 1. Sección para el logo
    add_settings_section(
        'enamm_header_logo_section',
        'Configuración del Logo',
        'enamm_header_logo_section_callback',
        'enamm-header-options'
    );
    add_settings_field(
        'enamm_header_logo_url',
        'URL del Logo',
        'enamm_header_logo_url_callback',
        'enamm-header-options',
        'enamm_header_logo_section'
    );
    register_setting(
        'enamm_header_settings_group',
        'enamm_header_logo_url',
        array(
            'type' => 'string',
            'sanitize_callback' => 'esc_url_raw', // Sanitiza la URL
            'default' => '',
        )
    );

    // 2. Sección para el menú de navegación
    add_settings_section(
        'enamm_header_menu_section',
        'Configuración del Menú de Navegación',
        'enamm_header_menu_section_callback',
        'enamm-header-options'
    );
    add_settings_field(
        'enamm_header_nav_menu', // ID del campo que contendrá todos los ítems del menú
        'Ítems del Menú',
        'enamm_header_nav_menu_callback',
        'enamm-header-options',
        'enamm_header_menu_section'
    );
    // Registra la opción del menú completo (se guardará como un array serializado)
    register_setting(
        'enamm_header_settings_group',
        'enamm_header_nav_menu',
        array(
            'type' => 'array',
            'sanitize_callback' => 'enamm_sanitize_menu_items', // Función para sanitizar todos los datos del menú
            'default' => array(),
        )
    );
}
add_action( 'admin_init', 'enamm_header_options_init' );

// --- Funciones de Callback para renderizar los campos en el panel ---

// Callback para la sección del logo
function enamm_header_logo_section_callback() {
    echo '<p>Introduce la URL de la imagen del logo de tu sitio.</p>';
}

// Callback para el campo de la URL del logo
function enamm_header_logo_url_callback() {
    $logo_url = get_option( 'enamm_header_logo_url' );
    echo '<input type="url" id="enamm_header_logo_url" name="enamm_header_logo_url" value="' . esc_url( $logo_url ) . '" class="regular-text">';
    echo '<p class="description">Por ejemplo: <code>https://tusitio.com/ruta/a/tu-logo.png</code></p>';
}

// Callback para la sección del menú de navegación
function enamm_header_menu_section_callback() {
    echo '<p>Gestiona los ítems de tu menú. Puedes arrastrar y soltar para reordenar y anidar. Usa las clases `menuRight__item--enabled` y `menuRight__item--disabled` para controlar la visibilidad.</p>';
}

// Callback para el campo del menú de navegación (la interfaz de usuario)
function enamm_header_nav_menu_callback() {
    $menu_items = get_option( 'enamm_header_nav_menu', array() ); // Obtiene los ítems guardados

    echo '<div id="enamm-menu-builder-container">';
    echo '<ul id="enamm-menu-sortable" class="enamm-menu-list">';

    // Renderiza los ítems existentes
    if ( ! empty( $menu_items ) ) {
        enamm_render_menu_items_recursive( $menu_items, 'enamm_header_nav_menu', 0 );
    }

    echo '</ul>';
    echo '<button type="button" class="button button-primary" id="add-menu-item">Añadir Nuevo Ítem</button>';
    echo '</div>'; // #enamm-menu-builder-container
}

/**
 * Función recursiva para renderizar ítems de menú y sus subítems en el backend.
 *
 * @param array  $items Los ítems de menú a renderizar.
 * @param string $field_name El nombre base del campo HTML (ej. 'enamm_header_nav_menu').
 * @param int    $depth La profundidad actual del menú (0 para el nivel superior).
 */
function enamm_render_menu_items_recursive( $items, $field_name, $depth ) {
    foreach ( $items as $index => $item ) {
        $unique_id = uniqid('menu_item_'); // Genera un ID único para cada ítem en el DOM
        ?>
        <li class="enamm-menu-item <?php echo 'depth-' . esc_attr($depth); ?>" data-item-id="<?php echo esc_attr($unique_id); ?>">
            <div class="enamm-menu-item-header">
                <span class="handle dashicons dashicons-move"></span>
                <span class="item-title"><?php echo esc_html( ! empty( $item['title'] ) ? $item['title'] : 'Nuevo Ítem' ); ?></span>
                <button type="button" class="toggle-item-details dashicons dashicons-arrow-down-alt2"></button>
                <button type="button" class="remove-item button button-small dashicons dashicons-trash"></button>
            </div>
            <div class="enamm-menu-item-details" style="display:none;">
                <p>
                    <label for="<?php echo esc_attr($field_name . '[' . $index . '][type]'); ?>">Tipo de Ítem:</label>
                    <select name="<?php echo esc_attr($field_name . '[' . $index . '][type]'); ?>" class="item-type-select">
                        <option value="link" <?php selected( $item['type'], 'link' ); ?>>Enlace</option>
                        <option value="heading" <?php selected( $item['type'], 'heading' ); ?>>Título (para submenú)</option>
                    </select>
                </p>
                <p>
                    <label for="<?php echo esc_attr($field_name . '[' . $index . '][title]'); ?>">Título:</label>
                    <input type="text" name="<?php echo esc_attr($field_name . '[' . $index . '][title]'); ?>" value="<?php echo esc_attr( $item['title'] ); ?>" class="item-title-input regular-text">
                </p>
                <p class="item-url-field <?php echo ($item['type'] === 'heading' ? 'hidden' : ''); ?>">
                    <label for="<?php echo esc_attr($field_name . '[' . $index . '][url]'); ?>">URL:</label>
                    <input type="url" name="<?php echo esc_attr($field_name . '[' . $index . '][url]'); ?>" value="<?php echo esc_url( $item['url'] ); ?>" class="regular-text">
                </p>
                <p>
                    <label for="<?php echo esc_attr($field_name . '[' . $index . '][classes]'); ?>">Clases CSS Adicionales (separadas por espacio):</label>
                    <input type="text" name="<?php echo esc_attr($field_name . '[' . $index . '][classes]'); ?>" value="<?php echo esc_attr( $item['classes'] ); ?>" class="regular-text">
                    <span class="description">Ej: `menuRight__item--enabled`, `solo-escritorio`</span>
                </p>
                <button type="button" class="add-subitem button button-secondary">Añadir Sub-ítem</button>
                <ul class="enamm-submenu-list enamm-menu-list">
                    <?php
                    if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
                        enamm_render_menu_items_recursive( $item['children'], $field_name . '[' . $index . '][children]', $depth + 1 );
                    }
                    ?>
                </ul>
            </div>
        </li>
        <?php
    }
}

/**
 * Función para sanitizar los ítems de menú antes de guardarlos.
 * Se llama recursivamente para sanitizar subítems.
 *
 * @param array $items Los ítems de menú a sanitizar.
 * @return array Los ítems de menú sanitizados.
 */
function enamm_sanitize_menu_items( $items ) {
    $sanitized_items = array();
    if ( ! is_array( $items ) || empty( $items ) ) {
        return $sanitized_items;
    }

    foreach ( $items as $item ) {
        $sanitized_item = array();
        $sanitized_item['type']    = isset( $item['type'] ) && in_array( $item['type'], array('link', 'heading') ) ? sanitize_text_field( $item['type'] ) : 'link';
        $sanitized_item['title']   = isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
        $sanitized_item['url']     = isset( $item['url'] ) ? esc_url_raw( $item['url'] ) : '';
        $sanitized_item['classes'] = isset( $item['classes'] ) ? sanitize_text_field( $item['classes'] ) : '';

        // Si tiene hijos, sanitízalos recursivamente
        if ( isset( $item['children'] ) && is_array( $item['children'] ) ) {
            $sanitized_item['children'] = enamm_sanitize_menu_items( $item['children'] );
        } else {
            $sanitized_item['children'] = array(); // Asegura que siempre es un array
        }
        $sanitized_items[] = $sanitized_item;
    }
    return $sanitized_items;
}

// Función para renderizar la página de opciones del header (la misma que ya tienes)
function enamm_header_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    settings_errors( 'enamm_header_messages' );
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'enamm_header_settings_group' );
            do_settings_sections( 'enamm-header-options' );
            submit_button( 'Guardar cambios' );
            ?>
        </form>
    </div>
    <?php
}






