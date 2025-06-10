<?php
/**
 * Tema Personalizado - Encolado de Scripts y Estilos
 *
 * Funciones para registrar y cargar hojas de estilo y scripts.
 */

function tu_tema_enqueue_frontend_assets() {

    // 1. Encolar normalize.css - Debe ir primero
    wp_enqueue_style(
        'enamm-normalize', // Un handle único para normalize
        get_template_directory_uri() . '/assets/css/global/normalize.css', // Ruta al archivo
        array(), // normalize.css no tiene dependencias de otros CSS
        filemtime( get_template_directory() . '/assets/css/global/normalize.css' ) // Versión para cache-busting
    );

    // 2. Encolar base.css - Depende de normalize.css
    wp_enqueue_style(
        'enamm-base', // Un handle único para base.css
        get_template_directory_uri() . '/assets/css/global/base.css', // Ruta al archivo
        array('enamm-normalize'), // base.css depende de normalize.css, así que se carga después.
        filemtime( get_template_directory() . '/assets/css/global/base.css' ) // Versión para cache-busting
    );

    // 3. Encolar los estilos del footer (depende de base.css)
    wp_enqueue_style(
        'enamm-footer-styles', // Un handle único para tus estilos del footer
        get_template_directory_uri() . '/assets/css/footer/footer.css', // Ruta al archivo footer.css
        array('enamm-base'), // Asegura que se cargue después de tus estilos base
        filemtime( get_template_directory() . '/assets/css/footer/footer.css' ) // Versión para cache-busting
    );

    wp_enqueue_style(
        'enamm-header-styles', // Un handle único para tus estilos del footer
        get_template_directory_uri() . '/assets/css/header/header.css', // Ruta al archivo header.css
        array('enamm-base'), // Asegura que se cargue después de tus estilos base
        filemtime( get_template_directory() . '/assets/css/header/header.css' ) // Versión para cache-busting
    );
 
    wp_enqueue_style(
        'enamm-home-styles', // Handle único para los estilos de la página de inicio
        get_template_directory_uri() . '/assets/css/home/home.css', // Ruta al archivo home.css consolidado
        array('enamm-base'), // Asegura que se cargue después de tus estilos base
        filemtime( get_template_directory() . '/assets/css/home/home.css' ) // Versión para cache-busting
    );

    // 4. Encolar tu style.css principal (si lo usas para estilos generales del tema)
    wp_enqueue_style( 'tu-tema-style', get_stylesheet_uri(), array('enamm-footer-styles', 'enamm-header-styles'), filemtime( get_stylesheet_directory() . '/style.css' ) );
    // wp_enqueue_style( 'tu-tema-style', get_stylesheet_uri(), array('enamm-header-styles'), filemtime( get_stylesheet_directory() . '/style.css' ) );

    // 5. Encolar tu archivo CSS adicional en assets/css/main.css (si aplica)
    wp_enqueue_style( 'tu-tema-main', get_template_directory_uri() . '/assets/css/main.css', array('tu-tema-style'), filemtime( get_template_directory() . '/assets/css/main.css' ) );

    // 6. Encolar tus fuentes de Google Fonts
    $google_fonts_url = 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
    wp_enqueue_style( 'tu-tema-google-fonts', $google_fonts_url, array(), null );

    // Opcional: Añadir precarga para optimización (los "preconnect" de Google Fonts)
    add_filter( 'wp_resource_hints', function( $urls, $relation_type ) {
        if ( 'preconnect' === $relation_type ) {
            $urls[] = 'https://fonts.googleapis.com';
            $urls[] = 'https://fonts.gstatic.com';
        }
        return $urls;
    }, 10, 2 );

    // 7. Encolar tu archivo JS en assets/js/script.js
    wp_enqueue_script( 'tu-tema-script', get_template_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0.0', true );
   
    // wp_enqueue_script(
    //     'enamm-header-script',
    //     get_template_directory_uri() . '/assets/js/admin/header-admin.js',
    //     array('sortablejs'), // ¡Aquí ya no hay dependencia de jQuery!
    //     filemtime( get_template_directory() . '/assets/js/admin/header-admin.js' ),
    //     true
    // );
}
add_action( 'wp_enqueue_scripts', 'tu_tema_enqueue_frontend_assets' ); // Usamos un nombre más descriptivo