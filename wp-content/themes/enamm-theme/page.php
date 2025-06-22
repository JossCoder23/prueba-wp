<?php
/**
 * La plantilla para mostrar todas las páginas individuales.
 *
 * Esta plantilla se utilizará para cualquier página estándar de WordPress
 * (como tu página "Hola") a menos que se asigne una plantilla más específica.
 */

get_header(); // Esto incluye el contenido de header.php
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <?php
        // El bucle de WordPress para mostrar el contenido de la página del editor
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                ?>

                    <?php
                    the_content(); // Esto muestra el contenido que ingreses en el editor de páginas de WordPress
                    // Cualquier código específico que quieras para TODAS las páginas estándar puede ir aquí
                    ?>
            
                <?php
                // Si tu tema soporta comentarios en las páginas (poco común pero posible)
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // Fin del bucle.
        else :
            // Retorno si no se encuentra contenido (ej. una página 404 para una página estándar)
            get_template_part( 'template-parts/content', 'none' ); // Asume que tienes content-none.php
        endif;
        ?>

    </main></div><?php
get_footer(); // Esto incluye el contenido de footer.php