<?php
/**
 * Tema Personalizado - Limpieza de Scripts y Estilos
 *
 * Funciones para remover CSS y JS no deseados.
 */

function tu_tema_remove_unwanted_assets() {
    // CSS de los bloques del core de Gutenberg
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );

    // CSS de bloques de WooCommerce (si lo usas y no lo necesitas en el frontend)
    wp_dequeue_style( 'wc-blocks-vendors-style' );
    wp_dequeue_style( 'wc-blocks-style' );

    // Quitar Dashicons si el usuario no ha iniciado sesión
    // Esto es solo si no usas Dashicons en el frontend cuando el usuario no está logueado.
    if ( ! is_user_logged_in() ) {
        wp_dequeue_style( 'dashicons' );
    }
}
add_action( 'wp_enqueue_scripts', 'tu_tema_remove_unwanted_assets', 100 ); // Prioridad alta para asegurar que se ejecute tarde