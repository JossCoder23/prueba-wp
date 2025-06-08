<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // Esencial: Carga estilos, scripts, metadatos. ?>
</head>
<body <?php body_class(); ?>>
    
    <?php wp_body_open(); // Hook para WordPress 5.2+ ?>

    <header>
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
                        <!-- <div class="menuRight__item menuRight__item--enabled">
                            <h3>Grados y Títulos</h3>
                            <div class="subitem">
                                <a href="#">Seguimiento al egresado</a>
                                <a href="#">Requisitos Académicos</a>
                            </div>
                        </div> -->
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
    </header>

    <?php wp_footer(); // Esencial: Carga scripts JavaScript al final. ?>
</body>
</html>