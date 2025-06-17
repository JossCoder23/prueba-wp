<?php
// admin/home-blocks/HomeBlock3Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 3: Programas de Posgrado</h1>
    <p>Gestiona el título principal de los programas de posgrado y el contenido de cada tarjeta en el slider.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Obtener el título principal de posgrado
    $current_bloque3_title = get_option( 'my_theme_bloque3_main_title', 'Programas de Posgrado' );

    // Obtener las tarjetas de posgrado existentes
    $my_theme_bloque3_cards = get_option( 'my_theme_bloque3_cards', array() );

    if ( isset( $_POST['submit_bloque3_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque3_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 3.</p></div>';
        } else {
            // Guardar el título principal
            $bloque3_main_title = isset( $_POST['bloque3_main_title'] ) ? sanitize_text_field( $_POST['bloque3_main_title'] ) : '';
            update_option( 'my_theme_bloque3_main_title', $bloque3_main_title );
            $current_bloque3_title = $bloque3_main_title; // Actualizar para mostrar el nuevo valor

            // Guardar las tarjetas de posgrado
            $new_bloque3_cards = array();
            if ( isset( $_POST['bloque3_cards'] ) && is_array( $_POST['bloque3_cards'] ) ) {
                foreach ( $_POST['bloque3_cards'] as $key => $card ) {
                    $image_url = isset( $card['image_url'] ) ? esc_url_raw( $card['image_url'] ) : '';
                    $h3_span_text = isset( $card['h3_span_text'] ) ? sanitize_text_field( $card['h3_span_text'] ) : '';
                    $h3_br_text = isset( $card['h3_br_text'] ) ? sanitize_text_field( $card['h3_br_text'] ) : '';
                    $button_text = isset( $card['button_text'] ) ? sanitize_text_field( $card['button_text'] ) : '';
                    $button_link = isset( $card['button_link'] ) ? esc_url_raw( $card['button_link'] ) : '';

                    // Solo añadir si al menos tiene una imagen o texto
                    if ( ! empty( $image_url ) || ! empty( $h3_span_text ) || ! empty( $h3_br_text ) || ! empty( $button_text ) || ! empty( $button_link ) ) {
                        $new_bloque3_cards[] = array(
                            'image_url' => $image_url,
                            'h3_span_text' => $h3_span_text,
                            'h3_br_text' => $h3_br_text,
                            'button_text' => $button_text,
                            'button_link' => $button_link,
                        );
                    }
                }
            }

            update_option( 'my_theme_bloque3_cards', $new_bloque3_cards );
            $my_theme_bloque3_cards = $new_bloque3_cards; // Actualizar para mostrar los cambios

            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 3 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque3_settings' ); // Campo de seguridad ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque3_main_title">Título Principal del Bloque 3</label></th>
                    <td>
                        <input type="text" id="bloque3_main_title" name="bloque3_main_title" value="<?php echo esc_attr( $current_bloque3_title ); ?>" class="regular-text" placeholder="Ej: Programas de Posgrado">
                        <p class="description">Este es el título grande que aparece en el Bloque 3.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Tarjetas de Programa de Posgrado</h2>
        <div id="bloque3-cards-container">
            <?php if ( ! empty( $my_theme_bloque3_cards ) ) : ?>
                <?php foreach ( $my_theme_bloque3_cards as $index => $card ) : ?>
                    <div class="bloque3-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Tarjeta Posgrado #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque3-card">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque3_image_<?php echo $index; ?>">URL de Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque3_image_<?php echo $index; ?>" name="bloque3_cards[<?php echo $index; ?>][image_url]" value="<?php echo esc_url( $card['image_url'] ); ?>" class="regular-text" placeholder="URL de la imagen del programa">
                                        <p class="description">URL de la imagen para esta tarjeta de programa.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque3_h3_span_<?php echo $index; ?>">Texto H3 (parte superior)</label></th>
                                    <td>
                                        <input type="text" id="bloque3_h3_span_<?php echo $index; ?>" name="bloque3_cards[<?php echo $index; ?>][h3_span_text]" value="<?php echo esc_attr( $card['h3_span_text'] ); ?>" class="regular-text" placeholder="Ej: Maestría en">
                                        <p class="description">Texto que irá dentro del &lt;span&gt; en el &lt;h3&gt;.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque3_h3_br_<?php echo $index; ?>">Texto H3 (parte inferior)</label></th>
                                    <td>
                                        <textarea id="bloque3_h3_br_<?php echo $index; ?>" name="bloque3_cards[<?php echo $index; ?>][h3_br_text]" rows="2" cols="50" class="large-text" placeholder="Ej: Gestión Naviera"><?php echo esc_textarea( $card['h3_br_text'] ); ?></textarea>
                                        <p class="description">Texto que irá después del salto de línea en el &lt;h3&gt;.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque3_button_text_<?php echo $index; ?>">Texto del Botón</label></th>
                                    <td>
                                        <input type="text" id="bloque3_button_text_<?php echo $index; ?>" name="bloque3_cards[<?php echo $index; ?>][button_text]" value="<?php echo esc_attr( $card['button_text'] ); ?>" class="regular-text" placeholder="Ej: Ingresar">
                                        <p class="description">Texto que aparecerá en el botón.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque3_button_link_<?php echo $index; ?>">URL del Botón</label></th>
                                    <td>
                                        <input type="url" id="bloque3_button_link_<?php echo $index; ?>" name="bloque3_cards[<?php echo $index; ?>][button_link]" value="<?php echo esc_url( $card['button_link'] ); ?>" class="regular-text" placeholder="https://ejemplo.com/maestria-gestion">
                                        <p class="description">URL a la que se vinculará el botón.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque3-card">Añadir Nueva Tarjeta de Posgrado</button>
        <?php submit_button( 'Guardar Cambios del Bloque 3', 'primary', 'submit_bloque3_settings' ); ?>
    </form>

    <script type="text/template" id="bloque3-card-template">
        <div class="bloque3-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Tarjeta Posgrado <button type="button" class="button button-secondary remove-bloque3-card">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque3_image_ID">URL de Imagen</label></th>
                        <td>
                            <input type="url" id="bloque3_image_ID" name="bloque3_cards[ID][image_url]" value="" class="regular-text" placeholder="URL de la imagen del programa">
                            <p class="description">URL de la imagen para esta tarjeta de programa.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque3_h3_span_ID">Texto H3 (parte superior)</label></th>
                        <td>
                            <input type="text" id="bloque3_h3_span_ID" name="bloque3_cards[ID][h3_span_text]" value="" class="regular-text" placeholder="Ej: Maestría en">
                            <p class="description">Texto que irá dentro del &lt;span&gt; en el &lt;h3&gt;.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque3_h3_br_ID">Texto H3 (parte inferior)</label></th>
                        <td>
                            <textarea id="bloque3_h3_br_ID" name="bloque3_cards[ID][h3_br_text]" rows="2" cols="50" class="large-text" placeholder="Ej: Gestión Naviera"></textarea>
                            <p class="description">Texto que irá después del salto de línea en el &lt;h3&gt;.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque3_button_text_ID">Texto del Botón</label></th>
                        <td>
                            <input type="text" id="bloque3_button_text_ID" name="bloque3_cards[ID][button_text]" value="" class="regular-text" placeholder="Ej: Ingresar">
                            <p class="description">Texto que aparecerá en el botón.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque3_button_link_ID">URL del Botón</label></th>
                        <td>
                            <input type="url" id="bloque3_button_link_ID" name="bloque3_cards[ID][button_link]" value="" class="regular-text" placeholder="https://ejemplo.com/maestria-gestion">
                            <p class="description">URL a la que se vinculará el botón.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nueva tarjeta de posgrado
            $('#add-bloque3-card').on('click', function() {
                var template = $('#bloque3-card-template').html();
                var newCard = template.replace(/ID/g, Date.now()); // Usar timestamp para ID único
                $('#bloque3-cards-container').append(newCard);
            });

            // Eliminar tarjeta de posgrado
            $('#bloque3-cards-container').on('click', '.remove-bloque3-card', function() {
                if (confirm('¿Estás seguro de que quieres eliminar esta tarjeta de posgrado?')) {
                    $(this).closest('.bloque3-card-item').remove();
                }
            });
        });
    </script>
</div>