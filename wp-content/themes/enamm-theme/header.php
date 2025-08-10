<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <?php wp_head(); // Esencial: Carga estilos, scripts, metadatos. ?>
</head>
<body <?php body_class(); ?>>
    
    <?php wp_body_open(); // Hook para WordPress 5.2+ ?>

    <!-- <header>
        <div class="header__container">
            <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014513/ebiwesr325mxt3ifb43w.webp" alt="" class="header__logo">
            <button class="header__buttonMobile" aria-controls="primary-menu" aria-expanded="false">
                <div class="hamburger">
                    <span></span> 
                    <span></span> 
                    <span></span> 
                </div>
            </button>
            <div class="header__menu">
                <div class="menu__left"></div>
                <nav class="menu__right">
                    <div class="menuRight__container">
                        <div class="menuRight__item">
                           <a href="">Home</a>
                        </div>
                        <div class="menuRight__item menuRight__item--disabled">
                            <h3>Nosotros</h3>
                            <div class="subitem">
                                <a href="#">Quiénes somos</a>
                                <a href="#">Autoridades</a>
                                <a href="#">Certificaciones</a>
                                <a href="#">Anticorrupción</a>
                            </div>
                        </div>
                        <div class="menuRight__item menuRight__item--disabled">
                            <a href="">Convenios</a>
                        </div>
                        <div class="menuRight__item">
                            <h3>Admisión</h3>
                            <div class="subitem">
                                <a href="#">Prepárate para el exámen de admisión</a>
                                <a href="#">Descargar la ficha de matricula</a>
                            </div>
                        </div>
                        <div class="menuRight__item">
                            <h3>Programas Académicos</h3>
                            <div class="subitem">
                                <div class="subitem__wrapper"> 
                                    <h3>Centro Pre ENAMM</h3>
                                    <div class="subitem2">
                                        <a href="">Pre Marina Mercante</a>
                                        <a href="">Pre AMP</a>
                                    </div>
                                </div>
                                <div class="subitem__wrapper"> 
                                    <h3>Carreras Pregrado</h3>
                                    <div class="subitem2">
                                        <a href="">Administración Marítima Portuaria</a>
                                        <a href="">Marina Mercante</a>
                                    </div>
                                </div>
                                <div class="subitem__wrapper"> 
                                    <h3>Carreras Posgrado</h3>
                                    <div class="subitem2">
                                        <a href="">Diplomado en Comercio y Finanzas Marítima Portuaria</a>
                                        <a href="">Diplomado en Gestión Marítima, Portuaria y Pesquera</a>
                                        <a href="">Diplomado en medio ambiente y derecho marítimo</a>
                                        <a href="">Doctorado en ciencias marítimas</a>
                                        <a href="">Maestría en Administración Marítima, Portuaria y Pesquera</a>
                                        <a href="">Maestría en Gestión Naviera</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="menuRight__item">
                            <h3>Capacitación</h3>
                            <div class="subitem">
                                <a href="#">Todos los cursos</a>
                                <a href="#">Verificador OMI</a>
                                <a href="#">Intranet Alumno</a>
                                <a href="#">Cronograma anual OMI</a>
                                <a href="#">Certificados por recoger</a>
                            </div>
                        </div>
                        <div class="menuRight__item menuRight__item--enabled">
                            <h3>Grados y Títulos</h3>
                            <div class="subitem">
                                <a href="#">Seguimiento al egresado</a>
                                <a href="#">Requisitos Académicos</a>
                            </div>
                        </div>
                        <div class="menuRight__item menuRight__item--disabled">
                            <a href="">Experiencia ENAMM</a>
                        </div>
                        <div class="menuRight__item menuRight__item--disabled">
                            <a href="">Noticias</a>
                        </div>
                        <div class="menuRight__item">
                            <a href="">Contáctanos</a>
                        </div>
                        <div class="menuRight__item menuRight__item--disabled">
                            <h3>Enlaces de interés</h3>
                            <div class="subitem">
                                <a href="#">Aula Virtual</a>
                                <a href="#">Repositorio Digital</a>
                                <a href="#">Biblioteca Virtual</a>
                                <a href="#">Intranet</a>
                                <a href="#">Calidad Educativa</a>
                                <a href="#">Webmail</a>
                            </div>
                        </div>
                        <div class="menuRight__item">
                            <h3>Traducir</h3>
                            <div class="subitem">
                                <a href="#">English</a>
                                <a href="#">Spanish</a>
                            </div>
                        </div>
                        <div class="menuRight__item">
                            <h3>Investigación</h3>
                            <div class="subitem">
                                <a href="#">Artículos</a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header> -->

    <?php 
    // Función para renderizar el menú (puede ir en functions.php o aquí)
function enamm_render_frontend_menu( $menu_items ) {
    if ( empty( $menu_items ) || ! is_array( $menu_items ) ) {
        return; // No hay ítems para renderizar
    }

    echo '<div class="menuRight__container">'; // Tu contenedor principal del menú

    foreach ( $menu_items as $item ) {
        $classes = ! empty( $item['classes'] ) ? esc_attr( $item['classes'] ) : '';
        $title = esc_html( $item['title'] );
        $url = esc_url( $item['url'] );
        $type = esc_attr( $item['type'] ); // 'link' o 'heading'

        // Añadir la clase principal del ítem
        $item_classes = 'menuRight__item ' . $classes;

        echo '<div class="' . $item_classes . '">';

        if ( $type === 'heading' || ( $type === 'link' && ! empty( $item['children'] ) ) ) {
            // Si es un "heading" o un link que tiene hijos, usamos h3
            // Si es un link con hijos, el h3 puede actuar como toggle, y el link real iría en un subitem
            // Para tu CSS, los h3 actúan como toggles
            echo '<h3>' . $title . '</h3>';
        } else {
            // Si es un link sin hijos, usamos <a>
            echo '<a href="' . $url . '">' . $title . '</a>';
        }

        // Renderizar submenús recursivamente
        if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
            // Determinar la clase del contenedor del submenú
            $subitem_container_class = '';
            if ( $type === 'heading' || ( $type === 'link' && ! empty( $item['children'] ) ) ) {
                // Si el padre es un heading o un link con hijos, los hijos directos son 'subitem'
                $subitem_container_class = 'subitem';
            } else {
                 // Esto no debería ocurrir si el diseño es consistente
                 // Si por alguna razón un 'link' sin hijos tuviera hijos, esto sería un error de estructura
            }

            // Si el padre es un 'subitem__wrapper' (para el segundo nivel de submenú)
            if ( strpos($item_classes, 'subitem__wrapper') !== false ) {
                $subitem_container_class = 'subitem2';
            }


            echo '<div class="' . esc_attr($subitem_container_class) . '">';
            // Para el segundo nivel de submenú (subitem2), el padre directo es el que tiene la clase subitem__wrapper
            // Por lo tanto, si el ítem actual es un subitem__wrapper, sus hijos serán subitem2
            // No podemos determinar la clase subitem__wrapper del padre de un subitem en esta función recursiva
            // Te sugiero añadir `subitem__wrapper` como una clase CSS adicional en el campo de texto si quieres un segundo nivel de submenú
            // Y entonces, si el ítem actual tiene `subitem__wrapper`, sus hijos serán `subitem2`
            
            enamm_render_frontend_menu_recursive_items( $item['children'], $item_classes ); // Llama a una función auxiliar recursiva
            echo '</div>';
        }

        echo '</div>'; // .menuRight__item
    }

    echo '</div>'; // .menuRight__container
}

// Función auxiliar recursiva para renderizar los ítems del menú
function enamm_render_frontend_menu_recursive_items( $items, $parent_classes ) {
    foreach ( $items as $item ) {
        $classes = ! empty( $item['classes'] ) ? esc_attr( $item['classes'] ) : '';
        $title = esc_html( $item['title'] );
        $url = esc_url( $item['url'] );
        $type = esc_attr( $item['type'] );

        // Añadir la clase principal del ítem
        $item_classes = 'menuRight__item ' . $classes; // Mantener siempre menuRight__item

        // Lógica para 'subitem__wrapper'
        if ( strpos($item_classes, 'subitem__wrapper') !== false ) {
            // Si el ítem es un subitem__wrapper, entonces su H3 o A es su contenido principal
            // y sus hijos serán subitem2
            echo '<div class="' . $item_classes . '">';
            echo '<h3>' . $title . '</h3>'; // Siempre un h3 para el wrapper
            
            if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
                echo '<div class="subitem2">';
                enamm_render_frontend_menu_recursive_items( $item['children'], $item_classes );
                echo '</div>'; // .subitem2
            }
            echo '</div>'; // .menuRight__item
        } else {
            // Elementos de menú normales (enlaces o headings sin ser wrappers)
            echo '<div class="' . $item_classes . '">';
            if ( $type === 'heading' || ! empty( $item['children'] ) ) { // Si es un título o tiene hijos
                echo '<h3>' . $title . '</h3>';
            } else {
                echo '<a href="' . $url . '">' . $title . '</a>';
            }

            if ( ! empty( $item['children'] ) && is_array( $item['children'] ) ) {
                // Asume que los hijos de un 'menuRight__item' normal son 'subitem' o 'subitem2' si el padre es un 'subitem__wrapper'
                // Esto requiere que el CSS y JS del frontend se encarguen de la visibilidad
                echo '<div class="subitem">'; // O .subitem2 si el padre fuera un subitem__wrapper (manejar con JS/CSS)
                enamm_render_frontend_menu_recursive_items( $item['children'], $item_classes );
                echo '</div>';
            }
            echo '</div>'; // .menuRight__item
        }
    }
}
    ?>

    <header>
        <div class="header__container">
            <img src="<?php echo esc_url( get_option( 'enamm_header_logo_url' ) ); ?>" alt="Logo de ENAMM" class="header__logo">
            
            <button class="header__buttonMobile" aria-controls="primary-menu" aria-expanded="false">
                <div class="hamburger">
                    <span></span> 
                    <span></span> 
                    <span></span> 
                </div>
            </button>
            <div class="header__menu">
                <div class="menu__left"></div>
                <nav class="menu__right">
                    <?php
                    // Obtener los ítems del menú guardados
                    $enamm_menu_items = get_option( 'enamm_header_nav_menu', array() );
                    // Renderizar el menú
                    enamm_render_frontend_menu( $enamm_menu_items );
                    ?>
                    <div class="right--transparence">
                        <a href="#">
                            <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1754801721/rfe9s04bj8djj5xmggnn.png" alt="">
                        </a>
                        <a href="#">
                            <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1754801721/mc3cz8mkydfe3y7ebmmc.png" alt="">
                        </a>
                    </div>
                </nav>
                <div class="desktop--trans">
                    <a href="">
                        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1754801721/rfe9s04bj8djj5xmggnn.png" alt="">
                    </a>
                    <a href="">
                        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1754801721/mc3cz8mkydfe3y7ebmmc.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <?php wp_footer(); // Esencial: Carga scripts JavaScript al final. ?>
</body>
</html>