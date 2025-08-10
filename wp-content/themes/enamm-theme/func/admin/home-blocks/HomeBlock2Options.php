<?php
// admin/home-blocks/HomeBlock2Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 2: Carreras</h1>
    <p>Gestiona el título principal, la imagen de fondo del bloque, las flechas del slider y el contenido de cada tarjeta de carrera.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Obtener las opciones existentes
    $current_bloque2_main_title = get_option('my_theme_bloque2_main_title', 'Conoce nuestras carreras');
    $current_bloque2_background_image = get_option('my_theme_bloque2_background_image', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1752339712/v29japwwpzbacnjf7i31.png');
    $current_bloque2_arrow_left = get_option('my_theme_bloque2_arrow_left', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749555263/vl4xio3v6pfebgxdhzou.png');
    $current_bloque2_arrow_right = get_option('my_theme_bloque2_arrow_right', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749555263/o4zvs6lbdd2jgz3su7en.png');
    $my_theme_bloque2_cards = get_option('my_theme_bloque2_cards', array());

    if (isset($_POST['submit_bloque2_settings'])) {
        if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_bloque2_settings')) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 2.</p></div>';
        } else {
            // Guardar opciones globales
            update_option('my_theme_bloque2_main_title', sanitize_text_field($_POST['bloque2_main_title']));
            update_option('my_theme_bloque2_background_image', esc_url_raw($_POST['bloque2_background_image']));
            update_option('my_theme_bloque2_arrow_left', esc_url_raw($_POST['bloque2_arrow_left']));
            update_option('my_theme_bloque2_arrow_right', esc_url_raw($_POST['bloque2_arrow_right']));

            // Guardar las tarjetas de carreras
            $new_bloque2_cards = array();
            if (isset($_POST['bloque2_cards']) && is_array($_POST['bloque2_cards'])) {
                foreach ($_POST['bloque2_cards'] as $key => $card) {
                    $mobile_image = isset($card['data_bg_image_mobile']) ? esc_url_raw($card['data_bg_image_mobile']) : '';
                    $desktop_image = isset($card['data_bg_image_desktop']) ? esc_url_raw($card['data_bg_image_desktop']) : '';
                    $h3_text = isset($card['h3_text']) ? sanitize_text_field($card['h3_text']) : '';
                    $h2_text = isset($card['h2_text']) ? sanitize_text_field($card['h2_text']) : '';
                    $href = isset($card['href']) ? esc_url_raw($card['href']) : '';

                    if (!empty($mobile_image) || !empty($desktop_image) || !empty($h3_text) || !empty($h2_text) || !empty($href)) {
                        $new_bloque2_cards[] = array(
                            'data_bg_image_mobile' => $mobile_image,
                            'data_bg_image_desktop' => $desktop_image,
                            'h3_text' => $h3_text,
                            'h2_text' => $h2_text,
                            'href' => $href,
                        );
                    }
                }
            }
            update_option('my_theme_bloque2_cards', $new_bloque2_cards);
            
            // Actualizar variables para mostrar los cambios
            $current_bloque2_main_title = sanitize_text_field($_POST['bloque2_main_title']);
            $current_bloque2_background_image = esc_url_raw($_POST['bloque2_background_image']);
            $current_bloque2_arrow_left = esc_url_raw($_POST['bloque2_arrow_left']);
            $current_bloque2_arrow_right = esc_url_raw($_POST['bloque2_arrow_right']);
            $my_theme_bloque2_cards = $new_bloque2_cards;
            
            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 2 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field('save_bloque2_settings'); // Campo de seguridad ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque2_main_title">Título Principal del Bloque 2</label></th>
                    <td>
                        <input type="text" id="bloque2_main_title" name="bloque2_main_title" value="<?php echo esc_attr($current_bloque2_main_title); ?>" class="regular-text" placeholder="Ej: Conoce nuestras carreras">
                        <p class="description">Este es el título grande que aparece arriba del slider de carreras.</p>
                    </td>
                </tr>
                 <tr>
                    <th scope="row"><label for="bloque2_background_image">URL Imagen de Fondo</label></th>
                    <td>
                        <input type="url" id="bloque2_background_image" name="bloque2_background_image" value="<?php echo esc_url($current_bloque2_background_image); ?>" class="regular-text" placeholder="URL completa de la imagen de fondo del bloque">
                        <p class="description">La imagen grande que se muestra detrás del slider.</p>
                    </td>
                </tr>
                 <tr>
                    <th scope="row"><label for="bloque2_arrow_left">URL Flecha Izquierda</label></th>
                    <td>
                        <input type="url" id="bloque2_arrow_left" name="bloque2_arrow_left" value="<?php echo esc_url($current_bloque2_arrow_left); ?>" class="regular-text" placeholder="URL de la imagen de la flecha izquierda">
                    </td>
                </tr>
                 <tr>
                    <th scope="row"><label for="bloque2_arrow_right">URL Flecha Derecha</label></th>
                    <td>
                        <input type="url" id="bloque2_arrow_right" name="bloque2_arrow_right" value="<?php echo esc_url($current_bloque2_arrow_right); ?>" class="regular-text" placeholder="URL de la imagen de la flecha derecha">
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Tarjetas de Carrera</h2>
        <div id="bloque2-cards-container">
            <?php if (!empty($my_theme_bloque2_cards)) : ?>
                <?php foreach ($my_theme_bloque2_cards as $index => $card) : ?>
                    <div class="bloque2-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Tarjeta Carrera #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque2-card">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque2_href_<?php echo $index; ?>">Enlace (href)</label></th>
                                    <td>
                                        <input type="url" id="bloque2_href_<?php echo $index; ?>" name="bloque2_cards[<?php echo $index; ?>][href]" value="<?php echo esc_url($card['href']); ?>" class="regular-text" placeholder="Ej: https://google.com">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque2_mobile_image_<?php echo $index; ?>">URL Imagen Móvil</label></th>
                                    <td>
                                        <input type="url" id="bloque2_mobile_image_<?php echo $index; ?>" name="bloque2_cards[<?php echo $index; ?>][data_bg_image_mobile]" value="<?php echo esc_url($card['data_bg_image_mobile']); ?>" class="regular-text" placeholder="URL de imagen para móvil">
                                        <p class="description">URL de la imagen de fondo para dispositivos móviles.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque2_desktop_image_<?php echo $index; ?>">URL Imagen Escritorio</label></th>
                                    <td>
                                        <input type="url" id="bloque2_desktop_image_<?php echo $index; ?>" name="bloque2_cards[<?php echo $index; ?>][data_bg_image_desktop]" value="<?php echo esc_url($card['data_bg_image_desktop']); ?>" class="regular-text" placeholder="URL de imagen para escritorio">
                                        <p class="description">URL de la imagen de fondo para dispositivos de escritorio.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque2_h3_text_<?php echo $index; ?>">Texto H3</label></th>
                                    <td>
                                        <input type="text" id="bloque2_h3_text_<?php echo $index; ?>" name="bloque2_cards[<?php echo $index; ?>][h3_text]" value="<?php echo esc_attr($card['h3_text']); ?>" class="regular-text" placeholder="Ej: Programa Académico">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque2_h2_text_<?php echo $index; ?>">Texto H2</label></th>
                                    <td>
                                        <textarea id="bloque2_h2_text_<?php echo $index; ?>" name="bloque2_cards[<?php echo $index; ?>][h2_text]" rows="3" cols="50" class="large-text" placeholder="Ej: Marina Mercante"><?php echo esc_textarea($card['h2_text']); ?></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque2-card">Añadir Nueva Tarjeta de Carrera</button>
        <?php submit_button('Guardar Cambios del Bloque 2', 'primary', 'submit_bloque2_settings'); ?>
    </form>
    
    <script type="text/template" id="bloque2-card-template">
        <div class="bloque2-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Tarjeta Carrera <button type="button" class="button button-secondary remove-bloque2-card">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque2_href_ID">Enlace (href)</label></th>
                        <td>
                            <input type="url" id="bloque2_href_ID" name="bloque2_cards[ID][href]" value="" class="regular-text" placeholder="Ej: https://google.com">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque2_mobile_image_ID">URL Imagen Móvil</label></th>
                        <td>
                            <input type="url" id="bloque2_mobile_image_ID" name="bloque2_cards[ID][data_bg_image_mobile]" value="" class="regular-text" placeholder="URL de imagen para móvil">
                            <p class="description">URL de la imagen de fondo para dispositivos móviles.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque2_desktop_image_ID">URL Imagen Escritorio</label></th>
                        <td>
                            <input type="url" id="bloque2_desktop_image_ID" name="bloque2_cards[ID][data_bg_image_desktop]" value="" class="regular-text" placeholder="URL de imagen para escritorio">
                            <p class="description">URL de la imagen de fondo para dispositivos de escritorio.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque2_h3_text_ID">Texto H3</label></th>
                        <td>
                            <input type="text" id="bloque2_h3_text_ID" name="bloque2_cards[ID][h3_text]" value="" class="regular-text" placeholder="Ej: Programa Académico">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque2_h2_text_ID">Texto H2</label></th>
                        <td>
                            <textarea id="bloque2_h2_text_ID" name="bloque2_cards[ID][h2_text]" rows="3" cols="50" class="large-text" placeholder="Ej: Marina Mercante"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($) {
            // Añadir nueva tarjeta de carrera
            $('#add-bloque2-card').on('click', function() {
                var template = $('#bloque2-card-template').html();
                var newCard = template.replace(/ID/g, Date.now()); // Usar timestamp para ID único
                $('#bloque2-cards-container').append(newCard);
            });

            // Eliminar tarjeta de carrera
            $('#bloque2-cards-container').on('click', '.remove-bloque2-card', function() {
                if (confirm('¿Estás seguro de que quieres eliminar esta tarjeta de carrera?')) {
                    $(this).closest('.bloque2-card-item').remove();
                }
            });
        });
    </script>
</div>