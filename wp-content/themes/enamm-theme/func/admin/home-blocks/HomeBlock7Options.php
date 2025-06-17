<?php
// admin/home-blocks/HomeBlock7Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 7: Próximos Eventos</h1>
    <p>Gestiona el título principal de los eventos y las imágenes de cada tarjeta en el slider.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Obtener el título principal de eventos
    $current_bloque7_title = get_option( 'my_theme_bloque7_main_title', 'Próximos Eventos' );

    // Obtener las tarjetas de evento existentes
    $my_theme_bloque7_cards = get_option( 'my_theme_bloque7_cards', array() );

    if ( isset( $_POST['submit_bloque7_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque7_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 7.</p></div>';
        } else {
            // Guardar el título principal
            $bloque7_main_title = isset( $_POST['bloque7_main_title'] ) ? sanitize_text_field( $_POST['bloque7_main_title'] ) : '';
            update_option( 'my_theme_bloque7_main_title', $bloque7_main_title );
            $current_bloque7_title = $bloque7_main_title; // Actualizar para mostrar el nuevo valor

            // Guardar las tarjetas de evento
            $new_bloque7_cards = array();
            if ( isset( $_POST['bloque7_cards'] ) && is_array( $_POST['bloque7_cards'] ) ) {
                foreach ( $_POST['bloque7_cards'] as $key => $card ) {
                    $image_url = isset( $card['image_url'] ) ? esc_url_raw( $card['image_url'] ) : '';
                    // Puedes añadir un campo para el texto alt si lo necesitas
                    $alt_text = isset( $card['alt_text'] ) ? sanitize_text_field( $card['alt_text'] ) : '';

                    // Solo añadir si al menos tiene una imagen
                    if ( ! empty( $image_url ) ) {
                        $new_bloque7_cards[] = array(
                            'image_url' => $image_url,
                            'alt_text' => $alt_text,
                        );
                    }
                }
            }

            update_option( 'my_theme_bloque7_cards', $new_bloque7_cards );
            $my_theme_bloque7_cards = $new_bloque7_cards; // Actualizar para mostrar los cambios

            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 7 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque7_settings' ); // Campo de seguridad ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque7_main_title">Título Principal del Bloque 7</label></th>
                    <td>
                        <input type="text" id="bloque7_main_title" name="bloque7_main_title" value="<?php echo esc_attr( $current_bloque7_title ); ?>" class="regular-text" placeholder="Ej: Próximos Eventos">
                        <p class="description">Este es el título grande que aparece en el Bloque 7.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Imágenes de Evento</h2>
        <div id="bloque7-cards-container">
            <?php if ( ! empty( $my_theme_bloque7_cards ) ) : ?>
                <?php foreach ( $my_theme_bloque7_cards as $index => $card ) : ?>
                    <div class="bloque7-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Tarjeta Evento #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque7-card">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque7_image_<?php echo $index; ?>">URL de Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque7_image_<?php echo $index; ?>" name="bloque7_cards[<?php echo $index; ?>][image_url]" value="<?php echo esc_url( $card['image_url'] ); ?>" class="regular-text" placeholder="URL de la imagen del evento">
                                        <p class="description">URL de la imagen para esta tarjeta de evento.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque7_alt_<?php echo $index; ?>">Texto Alternativo (Alt)</label></th>
                                    <td>
                                        <input type="text" id="bloque7_alt_<?php echo $index; ?>" name="bloque7_cards[<?php echo $index; ?>][alt_text]" value="<?php echo esc_attr( $card['alt_text'] ); ?>" class="regular-text" placeholder="Ej: Evento de capacitación">
                                        <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque7-card">Añadir Nueva Tarjeta de Evento</button>
        <?php submit_button( 'Guardar Cambios del Bloque 7', 'primary', 'submit_bloque7_settings' ); ?>
    </form>

    <script type="text/template" id="bloque7-card-template">
        <div class="bloque7-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Tarjeta Evento <button type="button" class="button button-secondary remove-bloque7-card">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque7_image_ID">URL de Imagen</label></th>
                        <td>
                            <input type="url" id="bloque7_image_ID" name="bloque7_cards[ID][image_url]" value="" class="regular-text" placeholder="URL de la imagen del evento">
                            <p class="description">URL de la imagen para esta tarjeta de evento.</p>
                        </td>
                    </tr>
                     <tr>
                        <th scope="row"><label for="bloque7_alt_ID">Texto Alternativo (Alt)</label></th>
                        <td>
                            <input type="text" id="bloque7_alt_ID" name="bloque7_cards[ID][alt_text]" value="" class="regular-text" placeholder="Ej: Evento de capacitación">
                            <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nueva tarjeta de evento
            $('#add-bloque7-card').on('click', function() {
                var template = $('#bloque7-card-template').html();
                var newCard = template.replace(/ID/g, Date.now()); // Usar timestamp para ID único
                $('#bloque7-cards-container').append(newCard);
            });

            // Eliminar tarjeta de evento
            $('#bloque7-cards-container').on('click', '.remove-bloque7-card', function() {
                if (confirm('¿Estás seguro de que quieres eliminar esta tarjeta de evento?')) {
                    $(this).closest('.bloque7-card-item').remove();
                }
            });
        });
    </script>
</div>