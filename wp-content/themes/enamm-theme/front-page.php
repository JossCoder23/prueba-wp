<?php
/**
 * La plantilla para mostrar la página de inicio estática.
 *
 * @package Tu_Tema_Personalizado
 */

get_header(); // Incluye el contenido de header.php
$home_sliders = get_option( 'my_theme_home_sliders', array() );  // Recupera el array de sliders
// --- RECUPERAR DATOS DEL BLOQUE 2 ---
// $bloque2_main_title = get_option( 'my_theme_bloque2_main_title', 'Conoce nuestras carreras' );
// $bloque2_cards = get_option( 'my_theme_bloque2_cards', array() );
$main_title = get_option('my_theme_bloque2_main_title', 'Conoce nuestras carreras');
$background_image_url = get_option('my_theme_bloque2_background_image', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1752339712/v29japwwpzbacnjf7i31.png');
$arrow_left_url = get_option('my_theme_bloque2_arrow_left', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749555263/vl4xio3v6pfebgxdhzou.png');
$arrow_right_url = get_option('my_theme_bloque2_arrow_right', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749555263/o4zvs6lbdd2jgz3su7en.png');
$cards = get_option('my_theme_bloque2_cards', array());
// --- RECUPERAR DATOS DEL BLOQUE 3 ---
$bloque3_main_title = get_option( 'my_theme_bloque3_main_title', 'Programas de Posgrado' );
$bloque3_cards = get_option( 'my_theme_bloque3_cards', array() );
// --- RECUPERAR DATOS DEL BLOQUE 4 ---
$bloque4_h4 = get_option( 'my_theme_bloque4_h4_text', 'Curso' );
$bloque4_h3 = get_option( 'my_theme_bloque4_h3_text', 'Capacitación y entrenamiento' );
$bloque4_p = get_option( 'my_theme_bloque4_p_text', 'Somos un centro homologado por la Dirección General de Capitanías y Guardacostas, para impartir los cursos de especialidad marítima. Con la garantía y homologación de:' );
$bloque4_logos = get_option( 'my_theme_bloque4_logos', array() );
$bloque4_slider_images = get_option( 'my_theme_bloque4_slider_images', array() );
// --- RECUPERAR DATOS DEL BLOQUE 5 ---
$bloque5_backimage_top = get_option( 'my_theme_bloque5_backimage_top', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/idekvlaltcopvre1zoh4.webp' );
$bloque5_backimage_bottom = get_option( 'my_theme_bloque5_backimage_bottom', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/zkrvisvy9iv7inogxhsq.webp' );
$bloque5_left_image = get_option( 'my_theme_bloque5_left_image', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/hkbp5qejgqbz8350z5la.webp' );
$bloque5_items = get_option( 'my_theme_bloque5_items', array() );
// --- RETRIEVE BLOCK 6 DATA ---
$mobile_image_url = get_option( 'my_theme_bloque6_mobile_image', '' );
$desktop_image_url = get_option( 'my_theme_bloque6_desktop_image', '' );
// --- RECUPERAR DATOS DEL BLOQUE 7 ---
$bloque7_main_title = get_option( 'my_theme_bloque7_main_title', 'Próximos Eventos' );
$bloque7_cards = get_option( 'my_theme_bloque7_cards', array() );
// --- RECUPERAR DATOS DEL BLOQUE 8 ---
$bloque8_main_title = get_option( 'my_theme_bloque8_main_title', 'Comunicados' );
$bloque8_cards = get_option( 'my_theme_bloque8_cards', array() );
// --- RECUPERAR DATOS DEL BLOQUE 9 ---
$bloque9_main_title = get_option( 'my_theme_bloque9_main_title', 'Noticias' );
$bloque9_cards = get_option( 'my_theme_bloque9_cards', array() );
$bloque9_view_all_text = get_option( 'my_theme_bloque9_view_all_text', 'Ver Todo' );
$bloque9_view_all_link = get_option( 'my_theme_bloque9_view_all_link', '#' );
$bloque9_view_all_icon = get_option( 'my_theme_bloque9_view_all_icon', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/z9p1ukgynzqqojbvxboy.webp' );
// --- RETRIEVE BLOCK 11 DATA ---
$bloque11_title = get_option( 'my_theme_bloque11_title', 'Los mejores profesionales del sector Instituciones y entidades colaboradoras' );
$bloque11_images = get_option( 'my_theme_bloque11_images', array() );

?>

<main>

    <!-- <div class="slider-container">
        <div class="slider-wrapper">
            <div class="slider-track">
                <div class="slider-card"
                    data-bg-image-mobile="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/ck18czqqem2ekcmwsnan.webp"
                    data-bg-image-desktop="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/icsez5rowewz6kz0iz3x.webp">
                    <div class="card-content">
                        <h3>Bienvenidos a la Escuela</h3>
                        <h2>Nacional de Marina <br> Mercante "Almirante <br> Miguel Grau"</h2>
                    </div>
                </div>
                <div class="slider-card"
                    data-bg-image-mobile="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/ck18czqqem2ekcmwsnan.webp"
                    data-bg-image-desktop="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/icsez5rowewz6kz0iz3x.webp">
                    <div class="card-content">
                        <h3>Bienvenidos a la Escuela</h3>
                        <h2>Nacional de Marina <br> Mercante "Almirante <br> Miguel Grau"</h2>
                    </div>
                </div>
                <div class="slider-card"
                    data-bg-image-mobile="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/ck18czqqem2ekcmwsnan.webp"
                    data-bg-image-desktop="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/icsez5rowewz6kz0iz3x.webp">
                    <div class="card-content">
                        <h3>Bienvenidos a la Escuela</h3>
                        <h2>Nacional de Marina <br> Mercante "Almirante <br> Miguel Grau"</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="slider-dots"></div>
    </div> -->

    <div class="slider-container">
        <div class="slider-wrapper">
            <div class="slider-track">
                <?php if ( ! empty( $home_sliders ) ) : ?>
                    <?php foreach ( $home_sliders as $slider_card ) : ?>
                        <div class="slider-card"
                            data-bg-image-mobile="<?php echo esc_url( $slider_card['data_bg_image_mobile'] ); ?>"
                            data-bg-image-desktop="<?php echo esc_url( $slider_card['data_bg_image_desktop'] ); ?>">
                            <div class="card-content">
                                <h3><?php echo esc_html( stripslashes( $slider_card['h3_text'] ) ); ?></h3>
                                <h2><?php echo wp_kses_post( stripslashes( $slider_card['h2_text'] ) ); ?></h2>
                                <?php // wp_kses_post permite etiquetas HTML básicas como <br> ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="slider-card"
                        data-bg-image-mobile="https://via.placeholder.com/600x400?text=Movil+Default"
                        data-bg-image-desktop="https://via.placeholder.com/1200x800?text=Desktop+Default">
                        <div class="card-content">
                            <h3>Bienvenido</h3>
                            <h2>Crea tus sliders desde el administrador.</h2>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="slider-dots"></div>
    </div>

    <!-- <div class="bloque2">
        <img class="bloque2__background" src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1752339712/v29japwwpzbacnjf7i31.png" alt="">
        <div class="bloque2__container">
            <div class="bloque2__slider">
                <h3 class="bloque2__slider--title">Conoce nuestras carreras</h3>

                <div class="bloque2__slider--container">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749555263/vl4xio3v6pfebgxdhzou.png" alt="Anterior" class="bloque2__slider--arrow bloque2__slider--arrow--left">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749555263/o4zvs6lbdd2jgz3su7en.png" alt="Siguiente" class="bloque2__slider--arrow bloque2__slider--arrow--right">

                    <div class="bloque2__slider--wrapper">
                        <div class="bloque2__slider--track">
                            <a href="https://google.com" class="bloque2__slider--card">
                                <div class="bloque2__card--content"
                                    data-bg-image-mobile="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/tcg9egos8ao3poo3bm6v.webp"
                                    data-bg-image-desktop="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/tcg9egos8ao3poo3bm6v.webp">
                                    <h3>Programa Académico</h3>
                                    <h2>Marina Mercante</h2>
                                </div>
                            </a>

                            <a href="https://google.com" class="bloque2__slider--card">
                                <div class="bloque2__card--content"
                                    data-bg-image-mobile="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/trpja609dypx1v7ldgfq.webp"
                                    data-bg-image-desktop="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/trpja609dypx1v7ldgfq.webp">
                                    <h3>Programa Académico</h3>
                                    <h2>Administración <br> Marítima y Portuaria</h2> 
                                </div>
                            </a>

                        </div> 
                    </div> 
                </div> 
            </div> 
        </div> 
    </div> -->


    <div class="bloque2">
        <img class="bloque2__background" src="<?php echo esc_url($background_image_url); ?>" alt="">
        <div class="bloque2__container">
            <div class="bloque2__slider">
                <h3 class="bloque2__slider--title"><?php echo esc_html($main_title); ?></h3>

                <div class="bloque2__slider--container">
                    <img src="<?php echo esc_url($arrow_left_url); ?>" alt="Anterior" class="bloque2__slider--arrow bloque2__slider--arrow--left">
                    <img src="<?php echo esc_url($arrow_right_url); ?>" alt="Siguiente" class="bloque2__slider--arrow bloque2__slider--arrow--right">

                    <div class="bloque2__slider--wrapper">
                        <div class="bloque2__slider--track">
                            <?php
                            // Itera sobre las tarjetas de carrera
                            if (!empty($cards)) {
                                foreach ($cards as $card) {
                                    // Asegúrate de que al menos una imagen exista para renderizar la tarjeta
                                    if (!empty($card['data_bg_image_mobile']) || !empty($card['data_bg_image_desktop'])) {
                                        ?>
                                        <a href="<?php echo esc_url($card['href']); ?>" class="bloque2__slider--card">
                                            <div class="bloque2__card--content"
                                                data-bg-image-mobile="<?php echo esc_url($card['data_bg_image_mobile']); ?>"
                                                data-bg-image-desktop="<?php echo esc_url($card['data_bg_image_desktop']); ?>">
                                                <h3><?php echo esc_html($card['h3_text']); ?></h3>
                                                <h2><?php echo esc_html($card['h2_text']); ?></h2>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- <div class="bloque3">
        <div class="bloque3background"></div>
        <div class="bloque3__container">
            <h3 class="bloque3__title">Programas de Posgrado</h3>
            <div class="bloque3__slider">
                <div class="bloque3__slider--wrapper">
                    <div class="bloque3__slider--track">
                        <div class="bloque3__slider--card">
                            <div class="bloque3__slider--content">
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/vi1pg9jsiwmmsmzkzpkg.webp" alt=""> ===
                                <h3><span>Maestría en</span> <br> Gestión Naviera</h3>
                                <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque3__slider--card">
                            <div class="bloque3__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/gbtq3flbxn5iyhd0kg8t.webp" alt=""> ===
                               <h3><span>Maestría en</span> <br> Administración Marítima Portuaria y Pesquera</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque3__slider--card">
                            <div class="bloque3__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/vh5w1d9fejsgdiserctf.webp" alt=""> ===
                               <h3><span>Doctorado en</span> <br> Ciencias Marítimas</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque3__slider--card">
                            <div class="bloque3__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/juegraqfddyuayvfi9cs.webp" alt=""> ===
                               <h3><span>Diplomado en</span> <br> Medio Ambiente y Derecho Marítimo</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque3__slider--card">
                            <div class="bloque3__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/bm6xvvf50pu24ahvchdo.webp" alt="">
                               <h3><span>Diplomado en</span> <br> Gestión Marítima Portuaria y Pesquera</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque3__slider--card">
                            <div class="bloque3__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/lsc5ba1emu1mgafdxq5f.webp" alt="">
                               <h3><span>Diplomado en</span> <br> Comercio y Finanzas Marítima Portuaria</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bloque3__slider--arrow bloque3__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/nm5llpdj22jw3dfgxblc.png" alt=""></button>
                <button class="bloque3__slider--arrow bloque3__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/dhfmoox4hmjnkwknlioz.png" alt=""></button>
                <div class="bloque3__slider--dots">
                </div>
            </div>
        </div>
    </div> -->

    <div class="bloque3">
        <div class="bloque3background"></div>
        <div class="bloque3__container">
            <h3 class="bloque3__title"><?php echo esc_html( $bloque3_main_title ); ?></h3>
            <div class="bloque3__slider">
                <div class="bloque3__slider--wrapper">
                    <div class="bloque3__slider--track">
                        <?php if ( ! empty( $bloque3_cards ) ) : ?>
                            <?php foreach ( $bloque3_cards as $card ) : ?>
                                <div class="bloque3__slider--card">
                                    <div class="bloque3__slider--content">
                                        <img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['h3_br_text'] ); ?>">
                                        <h3><span><?php echo esc_html( $card['h3_span_text'] ); ?></span> <br> <?php echo esc_html( $card['h3_br_text'] ); ?></h3>
                                        <button onclick="window.location.href='<?php echo esc_url( $card['button_link'] ); ?>'"><?php echo esc_html( $card['button_text'] ); ?></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bloque3__slider--card">
                                <div class="bloque3__slider--content">
                                    <img src="https://via.placeholder.com/150?text=Posgrado+Default" alt="Programa por defecto">
                                    <h3><span>Maestría en</span> <br> (No configurado)</h3>
                                    <button>Ingresar</button>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="bloque3__slider--arrow bloque3__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/nm5llpdj22jw3dfgxblc.png" alt=""></button>
                <button class="bloque3__slider--arrow bloque3__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/dhfmoox4hmjnkwknlioz.png" alt=""></button>
                <div class="bloque3__slider--dots"></div>
            </div>
        </div>
    </div>

    <!-- <div class="bloque4">
        <div class="bloque4Container">
            <div class="bloque4__left">
                <h4>Curso</h4>
                <h3>Capacitación y entrenamiento</h3>
                <p>Somos un centro homologado por la Dirección General de Capitanías y Guardacostas, para impartir los cursos de especialidad marítima. Con la garantía y homologación de:</p>
                <div class="bloque4__left--content">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014489/veva6lm3vtgyu6wrq3zt.webp" alt="">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014489/vo44ihfat9onegilhyhp.webp" alt="">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014489/xwiticwc9eyvgidqzpee.webp" alt="">
                </div>
            </div>
            <div class="bloque4__right">
                <div class="bloque4__right--wrapper">
                    <div class="bloque4__right--card">
                        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014490/bzuwb6wj2pdb6aytvjre.webp" alt="Imagen 1" class="slider-image active">
                        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014490/xhpssz0u75u08qobkv7b.webp" alt="Imagen 2" class="slider-image">
                        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014490/da0xtemqpsqrrbtrviyl.webp" alt="Imagen 3" class="slider-image">
                    </div>
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/phfrqlfusszh4r17cyvo.webp" alt="Anterior" class="bloque4__slider--arrow bloque4__slider--arrow--left">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014490/wh4ij8lmsns2unwohzxf.webp" alt="Siguiente" class="bloque4__slider--arrow bloque4__slider--arrow--right">
                </div>
            </div>
        </div>
    </div> -->

    <div class="bloque4">
        <div class="bloque4Container">
            <div class="bloque4__left">
                <h4><?php echo esc_html( $bloque4_h4 ); ?></h4>
                <h3><?php echo esc_html( $bloque4_h3 ); ?></h3>
                <p><?php echo esc_html( $bloque4_p ); ?></p>
                <div class="bloque4__left--content">
                    <?php if ( ! empty( $bloque4_logos ) ) : ?>
                        <?php foreach ( $bloque4_logos as $logo ) : ?>
                            <img src="<?php echo esc_url( $logo['url'] ); ?>" alt="Logo de certificación">
                        <?php endforeach; ?>
                    <?php else : ?>
                        <img src="https://via.placeholder.com/100x50?text=Logo+1" alt="Logo por defecto 1">
                        <img src="https://via.placeholder.com/100x50?text=Logo+2" alt="Logo por defecto 2">
                        <img src="https://via.placeholder.com/100x50?text=Logo+3" alt="Logo por defecto 3">
                    <?php endif; ?>
                </div>
            </div>
            <div class="bloque4__right">
                <div class="bloque4__right--wrapper">
                    <div class="bloque4__right--card">
                        <?php if ( ! empty( $bloque4_slider_images ) ) : ?>
                            <?php foreach ( $bloque4_slider_images as $index => $image ) : ?>
                                <img src="<?php echo esc_url( $image['url'] ); ?>" alt="Imagen slider <?php echo $index + 1; ?>" class="slider-image <?php echo ( $index === 0 ) ? 'active' : ''; ?>">
                            <?php endforeach; ?>
                        <?php else : ?>
                            <img src="https://via.placeholder.com/400x300?text=Slider+1" alt="Slider por defecto 1" class="slider-image active">
                            <img src="https://via.placeholder.com/400x300?text=Slider+2" alt="Slider por defecto 2" class="slider-image">
                        <?php endif; ?>
                    </div>
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/phfrqlfusszh4r17cyvo.webp" alt="Anterior" class="bloque4__slider--arrow bloque4__slider--arrow--left">
                    <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014490/wh4ij8lmsns2unwohzxf.webp" alt="Siguiente" class="bloque4__slider--arrow bloque4__slider--arrow--right">
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="bloque5">
        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/idekvlaltcopvre1zoh4.webp" class="bloque5__backimage_top" alt="">
        <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/zkrvisvy9iv7inogxhsq.webp" class="bloque5__backimage_bottom" alt="">
        <div class="bloque5__container">
            <div class="bloque5__left">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/hkbp5qejgqbz8350z5la.webp" alt="">
            </div>
            <div class="bloque5__right">
                <div class="bloque5__item bloque5__item--curso1">
                    <h3>Cursos OMI</h3>
                    <h4>Ver curso</h4>
                </div>
                <div class="bloque5__item bloque5__item--curso2">
                    <h3>Cursos OMI</h3>
                    <h4>Ver curso</h4>
                </div>
                <div class="bloque5__item bloque5__item--curso3">
                    <h3>Cursos OMI</h3>
                    <h4>Ver curso</h4>
                </div>
            </div>
        </div>
    </div> -->

    <div class="bloque5">
        <img src="<?php echo esc_url( $bloque5_backimage_top ); ?>" class="bloque5__backimage_top" alt="Imagen de fondo superior">
        <img src="<?php echo esc_url( $bloque5_backimage_bottom ); ?>" class="bloque5__backimage_bottom" alt="Imagen de fondo inferior">
        <div class="bloque5__container">
            <div class="bloque5__left">
                <img src="<?php echo esc_url( $bloque5_left_image ); ?>" alt="Imagen principal izquierda">
            </div>
            <div class="bloque5__right">
                <?php if ( ! empty( $bloque5_items ) ) : ?>
                    <?php foreach ( $bloque5_items as $index => $item ) : ?>
                        <div class="bloque5__item bloque5__item--curso<?php echo $index + 1; ?>" onclick="window.location.href='<?php echo esc_url( $item['item_link'] ); ?>'">
                            <h3><?php echo esc_html( $item['h3_text'] ); ?></h3>
                            <h4><?php echo esc_html( $item['h4_text'] ); ?></h4>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="bloque5__item bloque5__item--curso1">
                        <h3>Cursos OMI</h3>
                        <h4>Ver curso</h4>
                    </div>
                    <div class="bloque5__item bloque5__item--curso2">
                        <h3>Cursos OMI</h3>
                        <h4>Ver curso</h4>
                    </div>
                    <div class="bloque5__item bloque5__item--curso3">
                        <h3>Cursos OMI</h3>
                        <h4>Ver curso</h4>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- <div class="bloque6">
        <div class="bloque6__container">
            <div class="bloque6__mobile">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749805123/dyragedlgkki2pmbcnjw.png" alt="">
            </div>
            <div class="bloque6__desktop">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749805123/gi5sci0jqgr2w9by318g.png" alt="">
            </div>
        </div>
    </div> -->
    <div class="bloque6">
        <div class="bloque6__container">
            <?php if ( ! empty( $mobile_image_url ) ) : ?>
            <div class="bloque6__mobile">
                <img src="<?php echo esc_url( $mobile_image_url ); ?>" alt="Imagen para móvil">
            </div>
            <?php endif; ?>
                <?php if ( ! empty( $desktop_image_url ) ) : ?>
                    <div class="bloque6__desktop">
                    <img src="<?php echo esc_url( $desktop_image_url ); ?>" alt="Imagen para escritorio">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- <div class="bloque7">
        <div class="bloque7__container">
            <h3 class="bloque7__title">Próximos Eventos</h3>
            <div class="bloque7__slider">
                <div class="bloque7__slider--wrapper">
                    <div class="bloque7__slider--track">
                        <div class="bloque7__slider--card">
                            <div class="bloque7__slider--content">
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/nsouzimldbtvfhylyate.webp" alt="">
                            </div>
                        </div>
                        <div class="bloque7__slider--card">
                            <div class="bloque7__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014495/xgnkwvbogkkbatzv18iz.webp" alt="">
                            </div>
                        </div>
                        <div class="bloque7__slider--card">
                            <div class="bloque7__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014495/ibp7mdacsmdpohmth4ic.webp" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bloque7__slider--arrow bloque7__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014495/uaa1f9ft3xwncwbf5kjk.webp" alt=""></button>
                <button class="bloque7__slider--arrow bloque7__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014495/ln6cekhdsrjyvafjysch.webp" alt=""></button>
                <div class="bloque7__slider--dots">
                </div>
            </div>
        </div>
    </div> -->

    <div class="bloque7">
        <div class="bloque7__container">
            <h3 class="bloque7__title"><?php echo esc_html( $bloque7_main_title ); ?></h3>
            <div class="bloque7__slider">
                <div class="bloque7__slider--wrapper">
                    <div class="bloque7__slider--track">
                        <?php if ( ! empty( $bloque7_cards ) ) : ?>
                            <?php foreach ( $bloque7_cards as $card ) : ?>
                                <div class="bloque7__slider--card">
                                    <div class="bloque7__slider--content">
                                        <img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['alt_text'] ); ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bloque7__slider--card">
                                <div class="bloque7__slider--content">
                                    <img src="https://via.placeholder.com/200x150?text=Evento+Default+1" alt="Evento por defecto 1">
                                </div>
                            </div>
                            <div class="bloque7__slider--card">
                                <div class="bloque7__slider--content">
                                    <img src="https://via.placeholder.com/200x150?text=Evento+Default+2" alt="Evento por defecto 2">
                                </div>
                            </div>
                            <div class="bloque7__slider--card">
                                <div class="bloque7__slider--content">
                                    <img src="https://via.placeholder.com/200x150?text=Evento+Default+3" alt="Evento por defecto 3">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="bloque7__slider--arrow bloque7__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014495/uaa1f9ft3xwncwbf5kjk.webp" alt=""></button>
                <button class="bloque7__slider--arrow bloque7__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014495/ln6cekhdsrjyvafjysch.webp" alt=""></button>
                <div class="bloque7__slider--dots"></div>
            </div>
        </div>
    </div>

    <!-- <div class="bloque8">
        <div class="bloque8__container">
            <h3 class="bloque8__title">Comunicados</h3>
            <div class="bloque8__slider">
                <div class="bloque8__slider--wrapper">
                    <div class="bloque8__slider--track">
                        <div class="bloque8__slider--card">
                            <div class="bloque8__slider--content">
                                <div class="bloque8__slider--item">
                                    <div class="bloque8__item--top"></div>
                                    <div class="bloque8__item--bottom">
                                        <h3>03</h3>
                                        <h4>MAR</h4>
                                    </div>
                                </div>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/pcoyompain0zuttjarjm.webp" alt="">
                                <h3 class="bloque8__slider--title">Convocatoria de la XXXIII Maestría</h3>
                            </div>
                        </div>
                        <div class="bloque8__slider--card">
                            <div class="bloque8__slider--content">
                                <div class="bloque8__slider--item">
                                    <div class="bloque8__item--top"></div>
                                    <div class="bloque8__item--bottom">
                                        <h3>03</h3>
                                        <h4>MAR</h4>
                                    </div>
                                </div>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/pcoyompain0zuttjarjm.webp" alt="">
                                <h3 class="bloque8__slider--title">Convocatoria de la XXXIII Maestría</h3>
                            </div>
                        </div>
                        <div class="bloque8__slider--card">
                            <div class="bloque8__slider--content">
                                <div class="bloque8__slider--item">
                                    <div class="bloque8__item--top"></div>
                                    <div class="bloque8__item--bottom">
                                        <h3>03</h3>
                                        <h4>MAR</h4>
                                    </div>
                                </div>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/pcoyompain0zuttjarjm.webp" alt="">
                                <h3 class="bloque8__slider--title">Convocatoria de la XXXIII Maestría</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bloque8__slider--arrow bloque8__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/eu4fdt56u7jbf4sttqkt.webp" alt=""></button>
                <button class="bloque8__slider--arrow bloque8__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/hlj5zpzqbfsv0bbtrqt1.webp" alt=""></button>
                <div class="bloque8__slider--dots">
                </div>
            </div>
        </div>
    </div> -->

    <div class="bloque8">
        <div class="bloque8__container">
            <h3 class="bloque8__title"><?php echo esc_html( $bloque8_main_title ); ?></h3>
            <div class="bloque8__slider">
                <div class="bloque8__slider--wrapper">
                    <div class="bloque8__slider--track">
                        <?php if ( ! empty( $bloque8_cards ) ) : ?>
                            <?php foreach ( $bloque8_cards as $card ) : ?>
                                <div class="bloque8__slider--card">
                                    <div class="bloque8__slider--content"> 
                                        <div class="bloque8__slider--item">
                                            <div class="bloque8__item--top"></div>
                                            <div class="bloque8__item--bottom">
                                                <h3><?php echo esc_html( $card['day_text'] ); ?></h3>
                                                <h4><?php echo esc_html( $card['month_text'] ); ?></h4>
                                            </div>
                                        </div>
                                        <img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['alt_text'] ); ?>">
                                        <h3 class="bloque8__slider--title"><?php echo esc_html( $card['card_title'] ); ?></h3>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bloque8__slider--card">
                                <div class="bloque8__slider--content">
                                    <a href="#" class="bloque8__item--link">
                                        <div class="bloque8__slider--item">
                                            <div class="bloque8__item--top"></div>
                                            <div class="bloque8__item--bottom">
                                                <h3>01</h3>
                                                <h4>ENE</h4>
                                            </div>
                                        </div>
                                        <img src="https://via.placeholder.com/300x200?text=Comunicado+1" alt="Comunicado de ejemplo 1">
                                        <h3 class="bloque8__slider--title">Título de Comunicado de Ejemplo 1</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="bloque8__slider--card">
                                <div class="bloque8__slider--content">
                                    <a href="#" class="bloque8__item--link">
                                        <div class="bloque8__slider--item">
                                            <div class="bloque8__item--top"></div>
                                            <div class="bloque8__item--bottom">
                                                <h3>15</h3>
                                                <h4>FEB</h4>
                                            </div>
                                        </div>
                                        <img src="https://via.placeholder.com/300x200?text=Comunicado+2" alt="Comunicado de ejemplo 2">
                                        <h3 class="bloque8__slider--title">Título de Comunicado de Ejemplo 2</h3>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="bloque8__slider--arrow bloque8__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/eu4fdt56u7jbf4sttqkt.webp" alt=""></button>
                <button class="bloque8__slider--arrow bloque8__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/hlj5zpzqbfsv0bbtrqt1.webp" alt=""></button>
                <div class="bloque8__slider--dots"></div>
            </div>
        </div>
    </div>

    <!-- <div class="bloque9">
        <div class="bloque9__container">
            <h3 class="bloque9__title">Noticias</h3>
            <div class="bloque9__slider">
                <div class="bloque9__slider--wrapper">
                    <div class="bloque9__slider--track">
                        <div class="bloque9__slider--card">
                            <div class="bloque9__slider--content">
                                <h3>1 marzo de 2025</h3>
                                <p>Aspirantes a Cadetes Náuticos Visitan Buques de la Armada del Perú</p>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/eklrnliynocftkkkq83f.webp" alt="">
                            </div>
                        </div>
                        <div class="bloque9__slider--card">
                            <div class="bloque9__slider--content">
                                <h3>1 marzo de 2025</h3>
                                <p>Aspirantes a Cadetes Náuticos Visitan Buques de la Armada del Perú</p>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014500/shyikgach77lg2qvnz1g.webp" alt="">
                            </div>
                        </div>
                        <div class="bloque9__slider--card">
                            <div class="bloque9__slider--content">
                                <h3>1 marzo de 2025</h3>
                                <p>Aspirantes a Cadetes Náuticos Visitan Buques de la Armada del Perú</p>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014500/x3mwcgzlomil1zaf12wf.webp" alt="">
                            </div>
                        </div>
                        <div class="bloque9__slider--card">
                            <div class="bloque9__slider--content">
                                <h3>1 marzo de 2025</h3>
                                <p>Aspirantes a Cadetes Náuticos Visitan Buques de la Armada del Perú</p>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014500/e8ifpsfk96tkwcxmmkod.webp" alt="">
                            </div>
                        </div>
                        <div class="bloque9__slider--card">
                            <div class="bloque9__slider--content">
                                <h3>1 marzo de 2025</h3>
                                <p>Aspirantes a Cadetes Náuticos Visitan Buques de la Armada del Perú</p>
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014500/ii3j0ewhaxjj2o3sksmc.webp" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bloque9__slider--arrow bloque9__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/nm5llpdj22jw3dfgxblc.png" alt=""></button>
                <button class="bloque9__slider--arrow bloque9__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/dhfmoox4hmjnkwknlioz.png" alt=""></button>
                <div class="bloque9__slider--dots">
                </div>
            </div>
            <div class="bloque9__todo">
                <h3>Ver Todo</h3>
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/z9p1ukgynzqqojbvxboy.webp" alt="">
            </div>
        </div>
    </div> -->

    <div class="bloque9">
        <div class="bloque9__container">
            <h3 class="bloque9__title"><?php echo esc_html( $bloque9_main_title ); ?></h3>
            <div class="bloque9__slider">
                <div class="bloque9__slider--wrapper">
                    <div class="bloque9__slider--track">
                        <?php if ( ! empty( $bloque9_cards ) ) : ?>
                            <?php foreach ( $bloque9_cards as $card ) : ?>
                                <div class="bloque9__slider--card">
                                    
                                        <div class="bloque9__slider--content">
                                            <h3><?php echo esc_html( $card['date_text'] ); ?></h3>
                                            <p><?php echo esc_html( $card['paragraph_text'] ); ?></p>
                                            <img src="<?php echo esc_url( $card['image_url'] ); ?>" alt="<?php echo esc_attr( $card['alt_text'] ); ?>">
                                        </div>
                                    
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="bloque9__slider--card">
                                <div class="bloque9__slider--content">
                                    <h3>1 enero de 2025</h3>
                                    <p>Noticia de ejemplo 1: Visita importante al museo naval.</p>
                                    <img src="https://via.placeholder.com/300x200?text=Noticia+1" alt="Noticia de ejemplo 1">
                                </div>
                            </div>
                            <div class="bloque9__slider--card">
                                <div class="bloque9__slider--content">
                                    <h3>15 febrero de 2025</h3>
                                    <p>Noticia de ejemplo 2: Nuevas inscripciones para cursos náuticos.</p>
                                    <img src="https://via.placeholder.com/300x200?text=Noticia+2" alt="Noticia de ejemplo 2">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <button class="bloque9__slider--arrow bloque9__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/nm5llpdj22jw3dfgxblc.png" alt="Flecha anterior"></button>
                <button class="bloque9__slider--arrow bloque9__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/dhfmoox4hmjnkwknlioz.png" alt="Flecha siguiente"></button>
                <div class="bloque9__slider--dots"></div>
            </div>
            <div class="bloque9__todo">
                <a href="<?php echo esc_url( $bloque9_view_all_link ); ?>">
                    <h3><?php echo esc_html( $bloque9_view_all_text ); ?></h3>
                    <img src="<?php echo esc_url( $bloque9_view_all_icon ); ?>" alt="Ver todo ícono">
                </a>
            </div>
        </div>
    </div>

    <!-- <div class="bloque10">
        <div class="bloque10__container">
            <h3 class="bloque10__title">Programas de Posgrado</h3>
            <div class="bloque10__slider">
                <div class="bloque10__slider--wrapper">
                    <div class="bloque10__slider--track">
                        <div class="bloque10__slider--card">
                            <div class="bloque10__slider--content">
                                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/vi1pg9jsiwmmsmzkzpkg.webp" alt="">
                                <h3><span>Maestría en</span> <br> Gestión Naviera</h3>
                                <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque10__slider--card">
                            <div class="bloque10__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014487/gbtq3flbxn5iyhd0kg8t.webp" alt="">
                               <h3><span>Maestría en</span> <br> Administración Marítima Portuaria y Pesquera</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque10__slider--card">
                            <div class="bloque10__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/vh5w1d9fejsgdiserctf.webp" alt="">
                               <h3><span>Doctorado en</span> <br> Ciencias Marítimas</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque10__slider--card">
                            <div class="bloque10__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/juegraqfddyuayvfi9cs.webp" alt="">
                               <h3><span>Diplomado en</span> <br> Medio Ambiente y Derecho Marítimo</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque10__slider--card">
                            <div class="bloque10__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/bm6xvvf50pu24ahvchdo.webp" alt="">
                               <h3><span>Diplomado en</span> <br> Gestión Marítima Portuaria y Pesquera</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                        <div class="bloque10__slider--card">
                            <div class="bloque10__slider--content">
                               <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014488/lsc5ba1emu1mgafdxq5f.webp" alt="">
                               <h3><span>Diplomado en</span> <br> Comercio y Finanzas Marítima Portuaria</h3>
                               <button>Ingresar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="bloque10__slider--arrow bloque10__prev--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/nm5llpdj22jw3dfgxblc.png" alt=""></button>
                <button class="bloque10__slider--arrow bloque10__next--arrow"><img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749623199/dhfmoox4hmjnkwknlioz.png" alt=""></button>
                <div class="bloque10__slider--dots">
                </div>
            </div>
        </div>
    </div> -->

    <!-- <div class="bloque11">
        <div class="bloque11__container">
            <h3>Los mejores profesionales del sector Instituciones y entidades colaboradoras</h3>
            <div class="bloque11__container--content">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014513/jnns3k8mvcicivyxzmj9.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014510/pguuuww5wavyu0jihtkv.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014510/ub5ks6ctio5r8vdore8j.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014510/ivm3k7tt4pazjtawgzzw.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014510/gjmt3p7haf3jjhojb93g.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014510/walihs7zfsponhatwcas.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014510/nceqduobusnpeeltkyhq.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014506/p8xd1t3vwg29n9lxgtbq.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014506/vuudu7yqvmoaoitodslh.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014506/a32iyrs0zaw57hezohhl.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014506/nhp7wrbra7fzlttww4p1.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014506/prxpqf2yrhmdpatftbhq.webp" alt="">
                <img src="https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014506/zbe4gkirtimtzktv8gye.webp" alt="">
            </div>
        </div>
    </div> -->

    <div class="bloque11">
        <div class="bloque11__container">
            <h3><?php echo esc_html( $bloque11_title ); ?></h3>
            <div class="bloque11__container--content">
                <?php if ( ! empty( $bloque11_images ) ) : ?>
                    <?php foreach ( $bloque11_images as $image ) : ?>
                        <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt_text'] ); ?>">
                    <?php endforeach; ?>
                <?php else : ?>
                    <img src="https://via.placeholder.com/120x60?text=Colab+1" alt="Default Collab Logo 1">
                    <img src="https://via.placeholder.com/120x60?text=Colab+2" alt="Default Collab Logo 2">
                    <img src="https://via.placeholder.com/120x60?text=Colab+3" alt="Default Collab Logo 3">
                    <img src="https://via.placeholder.com/120x60?text=Colab+4" alt="Default Collab Logo 4">
                <?php endif; ?>
            </div>
        </div>
    </div>

</main>

<?php
get_footer(); // Incluye el contenido de footer.php
?>