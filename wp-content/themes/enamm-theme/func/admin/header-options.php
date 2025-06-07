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

// 2. Definir la función que renderiza el contenido HTML de la página de opciones
function enamm_header_options_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    settings_errors( 'enamm_header_messages' ); // Muestra mensajes de error/éxito
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'enamm_header_settings_group' ); // Grupo de opciones registrado
            do_settings_sections( 'enamm-header-options' );   // Slug de la página de opciones
            submit_button( 'Guardar cambios' );
            ?>
        </form>
    </div>
    <?php
}

// 3. Registrar la configuración, secciones y campos para el header
function enamm_header_settings_init() {
    // Registrar el grupo de opciones para el header
    register_setting(
        'enamm_header_settings_group', // Nombre del grupo de opciones
        'enamm_header_options',        // Nombre de la opción en la base de datos (clave del array)
        array(
            'type'              => 'array',
            'sanitize_callback' => 'enamm_sanitize_header_options', // Función de saneamiento
            'default'           => array(
                'logo_url'     => '',
                'site_tagline' => get_bloginfo( 'description' ), // Por defecto, la descripción del sitio
                'phone_header' => '',
                'email_header' => '',
            ),
        )
    );

    // Añadir una sección a la página de opciones del header
    add_settings_section(
        'enamm_header_general_section',     // ID único de la sección
        'Configuración General del Header', // Título de la sección
        'enamm_header_general_section_callback', // Función de callback para descripción
        'enamm-header-options'              // Slug de la página donde se mostrará
    );

    // Añadir campos individuales a la sección
    add_settings_field(
        'enamm_header_logo_field',      // ID único del campo
        'URL del Logo',                 // Etiqueta del campo
        'enamm_header_logo_field_callback', // Función para renderizar el campo
        'enamm-header-options',         // Slug de la página
        'enamm_header_general_section', // ID de la sección a la que pertenece
        array( 'label_for' => 'enamm_header_logo_field' )
    );

    add_settings_field(
        'enamm_header_tagline_field',
        'Lema del Sitio (Tagline)',
        'enamm_header_tagline_field_callback',
        'enamm-header-options',
        'enamm_header_general_section',
        array( 'label_for' => 'enamm_header_tagline_field' )
    );

    add_settings_field(
        'enamm_header_phone_field',
        'Teléfono en Header',
        'enamm_header_phone_field_callback',
        'enamm-header-options',
        'enamm_header_general_section',
        array( 'label_for' => 'enamm_header_phone_field' )
    );

    add_settings_field(
        'enamm_header_email_field',
        'Correo Electrónico en Header',
        'enamm_header_email_field_callback',
        'enamm-header-options',
        'enamm_header_general_section',
        array( 'label_for' => 'enamm_header_email_field' )
    );
}
add_action( 'admin_init', 'enamm_header_settings_init' );

// Función de callback para la descripción de la sección del header
function enamm_header_general_section_callback() {
    echo '<p>Configura los elementos principales que aparecerán en la cabecera de tu sitio.</p>';
}

// Funciones de callback para renderizar los campos individuales del header
function enamm_header_logo_field_callback() {
    $options = get_option( 'enamm_header_options' );
    $value   = isset( $options['logo_url'] ) ? $options['logo_url'] : '';
    ?>
    <input type="text" id="enamm_header_logo_field" name="enamm_header_options[logo_url]" value="<?php echo esc_url( $value ); ?>" class="regular-text">
    <p class="description">Introduce la URL completa de tu logo. Puedes subirla a la biblioteca de medios y copiar la URL.</p>
    <?php
}

function enamm_header_tagline_field_callback() {
    $options = get_option( 'enamm_header_options' );
    $value   = isset( $options['site_tagline'] ) ? $options['site_tagline'] : get_bloginfo( 'description' );
    ?>
    <input type="text" id="enamm_header_tagline_field" name="enamm_header_options[site_tagline]" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
    <p class="description">El lema o descripción corta de tu sitio.</p>
    <?php
}

function enamm_header_phone_field_callback() {
    $options = get_option( 'enamm_header_options' );
    $value   = isset( $options['phone_header'] ) ? $options['phone_header'] : '';
    ?>
    <input type="text" id="enamm_header_phone_field" name="enamm_header_options[phone_header]" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
    <p class="description">Introduce el número de teléfono para el header.</p>
    <?php
}

function enamm_header_email_field_callback() {
    $options = get_option( 'enamm_header_options' );
    $value   = isset( $options['email_header'] ) ? $options['email_header'] : '';
    ?>
    <input type="email" id="enamm_header_email_field" name="enamm_header_options[email_header]" value="<?php echo esc_attr( $value ); ?>" class="regular-text">
    <p class="description">Introduce el correo electrónico para el header.</p>
    <?php
}

// 4. Función de saneamiento de las opciones del header
function enamm_sanitize_header_options( $input ) {
    $output = array();

    if ( isset( $input['logo_url'] ) ) {
        $output['logo_url'] = esc_url_raw( $input['logo_url'] ); // Sanea URLs
    }

    if ( isset( $input['site_tagline'] ) ) {
        $output['site_tagline'] = sanitize_text_field( $input['site_tagline'] );
    }

    if ( isset( $input['phone_header'] ) ) {
        $output['phone_header'] = sanitize_text_field( $input['phone_header'] );
    }

    if ( isset( $input['email_header'] ) ) {
        $output['email_header'] = sanitize_email( $input['email_header'] );
    }

    return $output;
}
