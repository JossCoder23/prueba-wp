<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // Esencial: Carga estilos, scripts, metadatos. ?>
</head>
<body <?php body_class(); ?>>
    
    <?php wp_body_open(); // Hook para WordPress 5.2+ ?>

    <header class="site-header">
        <div class="header-container">
            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/logo.png' ); ?>" alt="Logo de tu sitio">
                    </a>
            </div>
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="screen-reader-text">Abrir menú</span>
                <div class="hamburger">
                    <span>Hola</span>
                    <span>Hola</span>
                    <span>Hola</span>
                    <span>Hola</span>
                </div>
            </button>

            <nav id="site-navigation" class="main-navigation">
                <h3>hola</h3>
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'primary', // Registra esta ubicación en functions.php
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'main-menu',
                    'depth'          => 3, // Puedes ajustar la profundidad de los submenús
                ) );
                ?>
            </nav>
        </div>
    </header>

    <?php wp_footer(); // Esencial: Carga scripts JavaScript al final. ?>
</body>
</html>