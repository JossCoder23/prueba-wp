<?php
// home-blocks/HomeBlock1Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 1: Sliders de Inicio</h1>
    <p>Gestiona el contenido (URLs de imágenes y textos) de cada tarjeta del slider en tu página de inicio.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    $my_theme_sliders = get_option( 'my_theme_home_sliders', array() ); // Obtener sliders existentes, por defecto un array vacío

    if ( isset( $_POST['submit_block_1_sliders'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_block_1_sliders_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos.</p></div>';
        } else {
            $new_sliders = array();
            // Recopilar los datos de los sliders enviados
            if ( isset( $_POST['slider_cards'] ) && is_array( $_POST['slider_cards'] ) ) {
                foreach ( $_POST['slider_cards'] as $key => $card ) {
                    // Sanear las URLs de las imágenes
                    $mobile_image = isset( $card['data_bg_image_mobile'] ) ? esc_url_raw( $card['data_bg_image_mobile'] ) : '';
                    $desktop_image = isset( $card['data_bg_image_desktop'] ) ? esc_url_raw( $card['data_bg_image_desktop'] ) : '';
                    $h3_text = isset( $card['h3_text'] ) ? sanitize_text_field( $card['h3_text'] ) : '';
                    $h2_text = isset( $card['h2_text'] ) ? sanitize_text_field( $card['h2_text'] ) : '';

                    // Solo añadir si al menos tiene una imagen o texto
                    if ( ! empty( $mobile_image ) || ! empty( $desktop_image ) || ! empty( $h3_text ) || ! empty( $h2_text ) ) {
                        $new_sliders[] = array(
                            'data_bg_image_mobile' => $mobile_image,
                            'data_bg_image_desktop' => $desktop_image,
                            'h3_text' => $h3_text,
                            'h2_text' => $h2_text,
                        );
                    }
                }
            }

            // Actualizar la opción con el nuevo array de sliders
            update_option( 'my_theme_home_sliders', $new_sliders );
            $my_theme_sliders = $new_sliders; // Actualizar la variable local para que el formulario muestre los cambios
            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Sliders actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_block_1_sliders_settings' ); // Campo de seguridad ?>

        <div id="slider-cards-container">
            <?php if ( ! empty( $my_theme_sliders ) ) : ?>
                <?php foreach ( $my_theme_sliders as $index => $slider_card ) : ?>
                    <div class="slider-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Tarjeta Slider #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-slider-card">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="mobile_image_<?php echo $index; ?>">URL Imagen Móvil</label></th>
                                    <td>
                                        <input type="url" id="mobile_image_<?php echo $index; ?>" name="slider_cards[<?php echo $index; ?>][data_bg_image_mobile]" value="<?php echo esc_url( $slider_card['data_bg_image_mobile'] ); ?>" class="regular-text" placeholder="Ingresa la URL de la imagen para móvil">
                                        <p class="description">URL de la imagen de fondo para dispositivos móviles.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="desktop_image_<?php echo $index; ?>">URL Imagen Desktop</label></th>
                                    <td>
                                        <input type="url" id="desktop_image_<?php echo $index; ?>" name="slider_cards[<?php echo $index; ?>][data_bg_image_desktop]" value="<?php echo esc_url( $slider_card['data_bg_image_desktop'] ); ?>" class="regular-text" placeholder="Ingresa la URL de la imagen para escritorio">
                                        <p class="description">URL de la imagen de fondo para dispositivos de escritorio.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="h3_text_<?php echo $index; ?>">Texto H3</label></th>
                                    <td>
                                        <input type="text" id="h3_text_<?php echo $index; ?>" name="slider_cards[<?php echo $index; ?>][h3_text]" value="<?php echo esc_attr( $slider_card['h3_text'] ); ?>" class="regular-text" placeholder="Texto para el encabezado pequeño">
                                        <p class="description">Texto para el &lt;h3&gt; de la tarjeta del slider.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="h2_text_<?php echo $index; ?>">Texto H2</label></th>
                                    <td>
                                        <textarea id="h2_text_<?php echo $index; ?>" name="slider_cards[<?php echo $index; ?>][h2_text]" rows="3" cols="50" class="large-text" placeholder="Texto para el encabezado grande"><?php echo esc_textarea( $slider_card['h2_text'] ); ?></textarea>
                                        <p class="description">Texto para el &lt;h2&gt; de la tarjeta del slider. Puedes usar &lt;br&gt; para saltos de línea.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-slider-card">Añadir Nueva Tarjeta Slider</button>
        <?php submit_button( 'Guardar Sliders', 'primary', 'submit_block_1_sliders' ); ?>
    </form>

    <script type="text/template" id="slider-card-template">
        <div class="slider-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Tarjeta Slider <button type="button" class="button button-secondary remove-slider-card">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="mobile_image_ID">URL Imagen Móvil</label></th>
                        <td>
                            <input type="url" id="mobile_image_ID" name="slider_cards[ID][data_bg_image_mobile]" value="" class="regular-text" placeholder="Ingresa la URL de la imagen para móvil">
                            <p class="description">URL de la imagen de fondo para dispositivos móviles.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="desktop_image_ID">URL Imagen Desktop</label></th>
                        <td>
                            <input type="url" id="desktop_image_ID" name="slider_cards[ID][data_bg_image_desktop]" value="" class="regular-text" placeholder="Ingresa la URL de la imagen para escritorio">
                            <p class="description">URL de la imagen de fondo para dispositivos de escritorio.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="h3_text_ID">Texto H3</label></th>
                        <td>
                            <input type="text" id="h3_text_ID" name="slider_cards[ID][h3_text]" value="" class="regular-text" placeholder="Texto para el encabezado pequeño">
                            <p class="description">Texto para el &lt;h3&gt; de la tarjeta del slider.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="h2_text_ID">Texto H2</label></th>
                        <td>
                            <textarea id="h2_text_ID" name="slider_cards[ID][h2_text]" rows="3" cols="50" class="large-text" placeholder="Texto para el encabezado grande"></textarea>
                            <p class="description">Texto para el &lt;h2&gt; de la tarjeta del slider. Puedes usar &lt;br&gt; para saltos de línea.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nueva tarjeta slider
            $('#add-slider-card').on('click', function() {
                var template = $('#slider-card-template').html();
                // Usar timestamp para ID único, importante para que cada campo tenga un 'name' diferente
                var newCard = template.replace(/ID/g, Date.now());
                $('#slider-cards-container').append(newCard);
            });

            // Eliminar tarjeta slider
            $('#slider-cards-container').on('click', '.remove-slider-card', function() {
                if (confirm('¿Estás seguro de que quieres eliminar esta tarjeta del slider?')) {
                    $(this).closest('.slider-card-item').remove();
                }
            });
        });
    </script>
</div>