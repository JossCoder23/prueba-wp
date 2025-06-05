<?php
/**
 * Tema Personalizado - Configuración del Tema
 *
 * Funciones relacionadas con la configuración inicial del tema.
 */

if ( ! function_exists( 'tu_tema_setup' ) ) {
    function tu_tema_setup() {
        // Habilita el soporte para el título del sitio (requerido para WP 4.1+)
        add_theme_support( 'title-tag' );

        // Registra tus menús de navegación
        register_nav_menus( array(
            'primary' => __( 'Menú Principal', 'tu-tema-personalizado' ),
        ) );

        // Otras configuraciones de tema:
        // add_theme_support( 'post-thumbnails' );
        // add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
        // add_theme_support( 'custom-logo' );
    }
}
add_action( 'after_setup_theme', 'tu_tema_setup' );