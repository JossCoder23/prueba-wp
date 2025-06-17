<?php
// home-options.php

// Función para añadir el menú principal "Home" como marcador no clicable
function my_custom_home_menu() {
    // Añade el menú principal "Home" como un elemento no clicable (separador)
    add_menu_page(
        'Home Options', // Título de la página (no se mostrará mucho)
        'Home',         // Título del menú que verás
        '', // Capacidad requerida
        'home-options-parent', // Slug único para el padre (puede ser cualquiera)
        '',           // *** ¡IMPORTANTE! Esto lo hace no clicable ***
        'dashicons-admin-home', // Icono
        20 // Posición
    );

    // Añadir el submenú "Block 1"
    add_submenu_page(
        'home-options-parent', // *** Usa el mismo slug del padre no clicable ***
        'Bloque 1 Settings', // Título de la página del submenú
        'Bloque 1',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-1',    // Slug del submenú
        'home_block1_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 2"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 2 Settings', // Título de la página del submenú
        'Bloque 2',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-2',    // Slug del submenú
        'home_block2_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 3"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 3 Settings', // Título de la página del submenú
        'Bloque 3',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-3',    // Slug del submenú
        'home_block3_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 4"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 4 Settings', // Título de la página del submenú
        'Bloque 4',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-4',    // Slug del submenú
        'home_block4_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 5"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 5 Settings', // Título de la página del submenú
        'Bloque 5',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-5',    // Slug del submenú
        'home_block5_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 6"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 6 Settings', // Título de la página del submenú
        'Bloque 6',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-6',    // Slug del submenú
        'home_block6_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 7"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 7 Settings', // Título de la página del submenú
        'Bloque 7',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-7',    // Slug del submenú
        'home_block7_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 8"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 8 Settings', // Título de la página del submenú
        'Bloque 8',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-8',    // Slug del submenú
        'home_block8_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 9"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 9 Settings', // Título de la página del submenú
        'Bloque 9',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-9',    // Slug del submenú
        'home_block9_page_content' // Función que mostrará el contenido de esta página
    );

    // Añadir el submenú "Block 11"
    add_submenu_page(
        'home-options-parent',    // *** Usa el mismo slug del padre no clicable ***
        'Bloque 11 Settings', // Título de la página del submenú
        'Bloque 11',         // Título del submenú
        'manage_options',  // Capacidad requerida
        'home-block-11',    // Slug del submenú
        'home_block11_page_content' // Función que mostrará el contenido de esta página
    );
}
add_action( 'admin_menu', 'my_custom_home_menu' );

// Las funciones para el contenido de los submenús permanecen igual
function home_block1_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock1Options.php';
}
function home_block2_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock2Options.php';
}
function home_block3_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock3Options.php';
}
function home_block4_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock4Options.php';
}
function home_block5_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock5Options.php';
}
function home_block6_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock6Options.php';
}
function home_block7_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock7Options.php';
}
function home_block8_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock8Options.php';
}
function home_block9_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock9Options.php';
}
function home_block11_page_content() {
  include_once __DIR__ . '/home-blocks/HomeBlock11Options.php';
}
