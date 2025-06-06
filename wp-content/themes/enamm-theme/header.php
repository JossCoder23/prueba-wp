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
                    <img src="" alt="">
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
            </nav>
        </div>
    </header>

    <?php wp_footer(); // Esencial: Carga scripts JavaScript al final. ?>
</body>
</html>