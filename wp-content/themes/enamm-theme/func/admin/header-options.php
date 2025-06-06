<?php

function enamm_enqueue_admin_header_scripts( $hook_suffix ) {
    if ( 'toplevel_page_enamm-header-options' !== $hook_suffix ) {
        return;
    }

    wp_enqueue_script(
        'enamm-header-admin-script',
        get_template_directory_uri() . '/assets/js/admin/header-admin.js',
        array(), // ¡Aquí ya no hay dependencia de jQuery!
        filemtime( get_template_directory() . '/assets/js/admin/header-admin.js' ),
        true
    );
}
add_action( 'admin_enqueue_scripts', 'enamm_enqueue_admin_header_scripts' );