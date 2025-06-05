<?php
/**
 * Tema Personalizado - Opciones del Footer en el Panel de Administración
 *
 * Funciones para registrar la página de opciones del footer, sus campos y callbacks.
 */

//====================================================================================
//- CREACION DE ITEM EN PANEL
//====================================================================================
function enamm_add_footer_options_page() {
    add_menu_page(
        'Opciones del Footer',
        'Footer',
        'manage_options',
        'enamm-footer-options',
        'enamm_footer_options_page_html',
        'dashicons-admin-settings',
        60
    );
}
add_action( 'admin_menu', 'enamm_add_footer_options_page' );

/**
 * Función callback para renderizar el HTML de la página de opciones del Footer.
 */
function enamm_footer_options_page_html() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'enamm_footer_settings_group' );
            do_settings_sections( 'enamm-footer-options' );
            submit_button( 'Guardar Cambios' );
            ?>
        </form>
    </div>
    <?php
}

function enamm_register_footer_settings() {
    register_setting(
        'enamm_footer_settings_group',
        'enamm_footer_options',
        'enamm_footer_options_sanitize'
    );

    // --- SECCIÓN: Top del Footer ---
    add_settings_section(
        'enamm_footer_top_section',
        'Sección Superior del Footer',
        'enamm_footer_top_section_callback',
        'enamm-footer-options'
    );

    // Campo: Logo del Footer
    add_settings_field(
        'enamm_footer_logo',
        'Logo del Footer',
        'enamm_footer_logo_callback',
        'enamm-footer-options',
        'enamm_footer_top_section'
    );

    add_settings_field( 'enamm_footer_legal_title', 'Título Aspectos Legales', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_top_section', array( 'label_for' => 'enamm_footer_legal_title', 'name' => 'footer_legal_title' ) );
    add_settings_field( 'enamm_footer_services_title', 'Título Nuestros Servicios', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_top_section', array( 'label_for' => 'enamm_footer_services_title', 'name' => 'footer_services_title' ) );
    add_settings_field( 'enamm_footer_interest_title', 'Título Enlaces de Interés', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_top_section', array( 'label_for' => 'enamm_footer_interest_title', 'name' => 'footer_interest_title' ) );
    add_settings_field( 'enamm_footer_centro_pre_title', 'Título Centro Pre ENAMM', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_top_section', array( 'label_for' => 'enamm_footer_centro_pre_title', 'name' => 'footer_centro_pre_title' ) );


    // Repetidor de Enlaces: Aspectos Legales
    add_settings_field(
        'enamm_footer_legal_links',
        'Enlaces Aspectos Legales',
        'enamm_footer_links_repeater_callback',
        'enamm-footer-options',
        'enamm_footer_top_section',
        array(
            'label_for' => 'enamm_footer_legal_links',
            'name'      => 'footer_legal_links',
            'field_id'  => 'legal_links_repeater'
        )
    );

    // Repetidor de Enlaces: Nuestros Servicios
    add_settings_field(
        'enamm_footer_services_links',
        'Enlaces Nuestros Servicios',
        'enamm_footer_links_repeater_callback',
        'enamm-footer-options',
        'enamm_footer_top_section',
        array(
            'label_for' => 'enamm_footer_services_links',
            'name'      => 'footer_services_links',
            'field_id'  => 'services_links_repeater'
        )
    );

    // Repetidor de Enlaces: Enlaces de Interés
    add_settings_field(
        'enamm_footer_interest_links',
        'Enlaces de Interés',
        'enamm_footer_links_repeater_callback',
        'enamm-footer-options',
        'enamm_footer_top_section',
        array(
            'label_for' => 'enamm_footer_interest_links',
            'name'      => 'footer_interest_links',
            'field_id'  => 'interest_links_repeater'
        )
    );

    // Repetidor de Enlaces: Centro Pre ENAMM
    add_settings_field(
        'enamm_footer_centro_pre_links',
        'Enlaces Centro Pre ENAMM',
        'enamm_footer_links_repeater_callback',
        'enamm-footer-options',
        'enamm_footer_top_section',
        array(
            'label_for' => 'enamm_footer_centro_pre_links',
            'name'      => 'footer_centro_pre_links',
            'field_id'  => 'centro_pre_links_repeater'
        )
    );

    // --- SECCIÓN: Bottom del Footer (Contactos, Admisión) ---
    add_settings_section(
        'enamm_footer_bottom_section',
        'Sección Inferior del Footer (Contactos / Admisión)',
        'enamm_footer_bottom_section_callback',
        'enamm-footer-options'
    );

    // Campo: Título Contáctanos
    add_settings_field( 'enamm_footer_contact_title', 'Título Contáctanos', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_contact_title', 'name' => 'footer_contact_title' ) );
    // Campos de Contacto
    add_settings_field( 'enamm_footer_contact_address', 'Dirección Contacto', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_contact_address', 'name' => 'footer_contact_address' ) );
    add_settings_field( 'enamm_footer_contact_phone', 'Teléfono Contacto', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_contact_phone', 'name' => 'footer_contact_phone' ) );
    add_settings_field( 'enamm_footer_contact_email', 'Email Contacto', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_contact_email', 'name' => 'footer_contact_email' ) );
    add_settings_field( 'enamm_footer_contact_hours_title', 'Título Horario Contacto', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_contact_hours_title', 'name' => 'footer_contact_hours_title' ) );
    add_settings_field( 'enamm_footer_contact_hours_time', 'Horario de Atención', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_contact_hours_time', 'name' => 'footer_contact_hours_time' ) );

    // Campo: Título Admisión ENAMM
    add_settings_field( 'enamm_footer_admission_title', 'Título Admisión ENAMM', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_admission_title', 'name' => 'footer_admission_title' ) );
    // Campos de Admisión
    add_settings_field( 'enamm_footer_admission_phone', 'Teléfono Admisión', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_admission_phone', 'name' => 'footer_admission_phone' ) );
    add_settings_field( 'enamm_footer_admission_email', 'Email Admisión', 'enamm_footer_text_input_callback', 'enamm-footer-options', 'enamm_footer_bottom_section', array( 'label_for' => 'enamm_footer_admission_email', 'name' => 'footer_admission_email' ) );
}
add_action( 'admin_init', 'enamm_register_footer_settings' );

// Funciones Callback para renderizar secciones y campos.
function enamm_footer_top_section_callback() {
    echo '<p>Configura la información para la parte superior de tu footer.</p>';
}

function enamm_footer_bottom_section_callback() {
    echo '<p>Configura la información de contacto y admisión para la parte inferior de tu footer.</p>';
}

function enamm_footer_logo_callback() {
    $options = get_option( 'enamm_footer_options' );
    $logo_url = isset( $options['footer_logo'] ) ? esc_url( $options['footer_logo'] ) : '';
    ?>
    <input type="url" id="enamm_footer_logo" name="enamm_footer_options[footer_logo]" value="<?php echo $logo_url; ?>" class="large-text">
    <p class="description">Introduce la URL del logo del footer (puedes subirlo a la biblioteca de medios y copiar la URL).</p>
    <?php
}

function enamm_footer_text_input_callback( $args ) {
    $options = get_option( 'enamm_footer_options' );
    $value = isset( $options[ $args['name'] ] ) ? esc_attr( $options[ $args['name'] ] ) : '';
    ?>
    <input type="text" id="<?php echo esc_attr( $args['label_for'] ); ?>" name="enamm_footer_options[<?php echo esc_attr( $args['name'] ); ?>]" value="<?php echo $value; ?>" class="large-text">
    <?php
}

// Función de saneamiento y validación para los datos guardados.
function enamm_footer_options_sanitize( $input ) {
    $new_input = array();

    // Sanear logo URL
    if ( isset( $input['footer_logo'] ) ) {
        $new_input['footer_logo'] = esc_url_raw( $input['footer_logo'] );
    }

    // Sanear títulos (texto simple)
    $text_fields = array(
        'footer_legal_title', 'footer_services_title', 'footer_interest_title', 'footer_centro_pre_title',
        'footer_contact_title', 'footer_contact_address', 'footer_contact_phone', 'footer_contact_email',
        'footer_contact_hours_title', 'footer_contact_hours_time',
        'footer_admission_title', 'footer_admission_phone', 'footer_admission_email'
    );
    foreach ( $text_fields as $field ) {
        if ( isset( $input[ $field ] ) ) {
            $new_input[ $field ] = sanitize_text_field( $input[ $field ] );
        }
    }

    // Sanear y URLs para enlaces
    $json_fields = array( // Cambiado de $html_fields a $json_fields para reflejar que son JSON
        'footer_legal_links', 'footer_services_links', 'footer_interest_links', 'footer_centro_pre_links'
    );
    foreach ( $json_fields as $field ) {
        if ( isset( $input[ $field ] ) ) {
            $links_data = json_decode( stripslashes( $input[ $field ] ), true ); // Decodificar el JSON
            $sanitized_links = array();

            if ( is_array( $links_data ) ) {
                foreach ( $links_data as $link ) {
                    if ( isset( $link['text'] ) && isset( $link['url'] ) ) {
                        $sanitized_links[] = array(
                            'text' => sanitize_text_field( $link['text'] ),
                            'url'  => esc_url_raw( $link['url'] ),
                        );
                    }
                }
            }
            $new_input[ $field ] = json_encode( $sanitized_links ); // Guardar como JSON saneado
        }
    }

    return $new_input;
}

// Encola los scripts JS para la página de opciones del Footer.
function enamm_enqueue_admin_scripts( $hook_suffix ) {
    if ( 'toplevel_page_enamm-footer-options' !== $hook_suffix ) {
        return;
    }

    wp_enqueue_script(
        'enamm-footer-admin-script',
        get_template_directory_uri() . '/assets/js/admin/footer-admin.js',
        array(), // ¡Aquí ya no hay dependencia de jQuery!
        filemtime( get_template_directory() . '/assets/js/admin/footer-admin.js' ),
        true
    );
}
add_action( 'admin_enqueue_scripts', 'enamm_enqueue_admin_scripts' );

// Callback para renderizar el repetidor de enlaces (manejo JS).
function enamm_footer_links_repeater_callback( $args ) {
    $options = get_option( 'enamm_footer_options' );
    $links_json = isset( $options[ $args['name'] ] ) ? $options[ $args['name'] ] : '[]';
    ?>
    <div id="<?php echo esc_attr( $args['field_id'] ); ?>" class="enamm-links-repeater-container">
        <input type="hidden"
               id="<?php echo esc_attr( $args['label_for'] ); ?>"
               name="enamm_footer_options[<?php echo esc_attr( $args['name'] ); ?>]"
               value="<?php echo esc_attr( $links_json ); ?>"
               class="enamm-links-data-input" />
        <div class="enamm-links-list">
            </div>
        <button type="button" class="button enamm-add-link-button">Añadir Enlace</button>
    </div>
    <p class="description">Añade el texto y la URL para cada enlace.</p>
    <?php
}