<?php
// admin/home-blocks/HomeBlock8Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 8: Comunicados</h1>
    <p>Gestiona el título principal de los comunicados y el contenido de cada tarjeta del slider (número, mes, imagen y título).</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Obtener el título principal de comunicados
    $current_bloque8_main_title = get_option( 'my_theme_bloque8_main_title', 'Comunicados' );

    // Obtener las tarjetas de comunicado existentes
    $my_theme_bloque8_cards = get_option( 'my_theme_bloque8_cards', array() );

    if ( isset( $_POST['submit_bloque8_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque8_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 8.</p></div>';
        } else {
            // Guardar el título principal
            $bloque8_main_title = isset( $_POST['bloque8_main_title'] ) ? sanitize_text_field( $_POST['bloque8_main_title'] ) : '';
            update_option( 'my_theme_bloque8_main_title', $bloque8_main_title );
            $current_bloque8_main_title = $bloque8_main_title; // Actualizar para mostrar el nuevo valor

            // Guardar las tarjetas de comunicado
            $new_bloque8_cards = array();
            if ( isset( $_POST['bloque8_cards'] ) && is_array( $_POST['bloque8_cards'] ) ) {
                foreach ( $_POST['bloque8_cards'] as $key => $card ) {
                    $day_text = isset( $card['day_text'] ) ? sanitize_text_field( $card['day_text'] ) : '';
                    $month_text = isset( $card['month_text'] ) ? sanitize_text_field( $card['month_text'] ) : '';
                    $image_url = isset( $card['image_url'] ) ? esc_url_raw( $card['image_url'] ) : '';
                    $alt_text = isset( $card['alt_text'] ) ? sanitize_text_field( $card['alt_text'] ) : '';
                    $card_title = isset( $card['card_title'] ) ? sanitize_text_field( $card['card_title'] ) : '';
                    $card_link = isset( $card['card_link'] ) ? esc_url_raw( $card['card_link'] ) : ''; // Añadir campo de enlace

                    // Solo añadir si al menos tiene un título o imagen
                    if ( ! empty( $day_text ) || ! empty( $month_text ) || ! empty( $image_url ) || ! empty( $card_title ) ) {
                        $new_bloque8_cards[] = array(
                            'day_text'   => $day_text,
                            'month_text' => $month_text,
                            'image_url'  => $image_url,
                            'alt_text'   => $alt_text,
                            'card_title' => $card_title,
                            'card_link'  => $card_link, // Guardar el enlace
                        );
                    }
                }
            }

            update_option( 'my_theme_bloque8_cards', $new_bloque8_cards );
            $my_theme_bloque8_cards = $new_bloque8_cards; // Actualizar para mostrar los cambios

            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 8 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque8_settings' ); // Campo de seguridad ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque8_main_title">Título Principal del Bloque 8</label></th>
                    <td>
                        <input type="text" id="bloque8_main_title" name="bloque8_main_title" value="<?php echo esc_attr( $current_bloque8_main_title ); ?>" class="regular-text" placeholder="Ej: Comunicados">
                        <p class="description">Este es el título grande que aparece en el Bloque 8.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Tarjetas de Comunicado</h2>
        <div id="bloque8-cards-container">
            <?php if ( ! empty( $my_theme_bloque8_cards ) ) : ?>
                <?php foreach ( $my_theme_bloque8_cards as $index => $card ) : ?>
                    <div class="bloque8-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Comunicado #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque8-card">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque8_day_<?php echo $index; ?>">Día del Comunicado</label></th>
                                    <td>
                                        <input type="text" id="bloque8_day_<?php echo $index; ?>" name="bloque8_cards[<?php echo $index; ?>][day_text]" value="<?php echo esc_attr( $card['day_text'] ); ?>" class="small-text" placeholder="Ej: 03">
                                        <p class="description">El número del día para el comunicado.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque8_month_<?php echo $index; ?>">Mes del Comunicado</label></th>
                                    <td>
                                        <input type="text" id="bloque8_month_<?php echo $index; ?>" name="bloque8_cards[<?php echo $index; ?>][month_text]" value="<?php echo esc_attr( $card['month_text'] ); ?>" class="small-text" placeholder="Ej: MAR">
                                        <p class="description">Las tres primeras letras del mes (Ej: MAR, ABR).</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque8_image_<?php echo $index; ?>">URL de Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque8_image_<?php echo $index; ?>" name="bloque8_cards[<?php echo $index; ?>][image_url]" value="<?php echo esc_url( $card['image_url'] ); ?>" class="regular-text" placeholder="URL de la imagen del comunicado">
                                        <p class="description">URL de la imagen para esta tarjeta de comunicado.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque8_alt_<?php echo $index; ?>">Texto Alternativo (Alt)</label></th>
                                    <td>
                                        <input type="text" id="bloque8_alt_<?php echo $index; ?>" name="bloque8_cards[<?php echo $index; ?>][alt_text]" value="<?php echo esc_attr( $card['alt_text'] ); ?>" class="regular-text" placeholder="Ej: Anuncio importante">
                                        <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque8_title_<?php echo $index; ?>">Título del Comunicado</label></th>
                                    <td>
                                        <input type="text" id="bloque8_title_<?php echo $index; ?>" name="bloque8_cards[<?php echo $index; ?>][card_title]" value="<?php echo esc_attr( $card['card_title'] ); ?>" class="regular-text" placeholder="Ej: Convocatoria de la XXXIII Maestría">
                                        <p class="description">Título principal del comunicado.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque8_link_<?php echo $index; ?>">URL del Enlace (Opcional)</label></th>
                                    <td>
                                        <input type="url" id="bloque8_link_<?php echo $index; ?>" name="bloque8_cards[<?php echo $index; ?>][card_link]" value="<?php echo esc_url( $card['card_link'] ); ?>" class="regular-text" placeholder="https://ejemplo.com/comunicado-completo">
                                        <p class="description">URL a la que apunta esta tarjeta (si es clickeable).</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque8-card">Añadir Nuevo Comunicado</button>
        <?php submit_button( 'Guardar Cambios del Bloque 8', 'primary', 'submit_bloque8_settings' ); ?>
    </form>

    <script type="text/template" id="bloque8-card-template">
        <div class="bloque8-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nuevo Comunicado <button type="button" class="button button-secondary remove-bloque8-card">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque8_day_ID">Día del Comunicado</label></th>
                        <td>
                            <input type="text" id="bloque8_day_ID" name="bloque8_cards[ID][day_text]" value="" class="small-text" placeholder="Ej: 03">
                            <p class="description">El número del día para el comunicado.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque8_month_ID">Mes del Comunicado</label></th>
                        <td>
                            <input type="text" id="bloque8_month_ID" name="bloque8_cards[ID][month_text]" value="" class="small-text" placeholder="Ej: MAR">
                            <p class="description">Las tres primeras letras del mes (Ej: MAR, ABR).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque8_image_ID">URL de Imagen</label></th>
                        <td>
                            <input type="url" id="bloque8_image_ID" name="bloque8_cards[ID][image_url]" value="" class="regular-text" placeholder="URL de la imagen del comunicado">
                            <p class="description">URL de la imagen para esta tarjeta de comunicado.</p>
                        </td>
                    </tr>
                     <tr>
                        <th scope="row"><label for="bloque8_alt_ID">Texto Alternativo (Alt)</label></th>
                        <td>
                            <input type="text" id="bloque8_alt_ID" name="bloque8_cards[ID][alt_text]" value="" class="regular-text" placeholder="Ej: Anuncio importante">
                            <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque8_title_ID">Título del Comunicado</label></th>
                        <td>
                            <input type="text" id="bloque8_title_ID" name="bloque8_cards[ID][card_title]" value="" class="regular-text" placeholder="Ej: Convocatoria de la XXXIII Maestría">
                            <p class="description">Título principal del comunicado.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque8_link_ID">URL del Enlace (Opcional)</label></th>
                        <td>
                            <input type="url" id="bloque8_link_ID" name="bloque8_cards[ID][card_link]" value="" class="regular-text" placeholder="https://ejemplo.com/comunicado-completo">
                            <p class="description">URL a la que apunta esta tarjeta (si es clickeable).</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nueva tarjeta de comunicado
            $('#add-bloque8-card').on('click', function() {
                var template = $('#bloque8-card-template').html();
                var newCard = template.replace(/ID/g, Date.now()); // Usar timestamp para ID único
                $('#bloque8-cards-container').append(newCard);
            });

            // Eliminar tarjeta de comunicado
            $('#bloque8-cards-container').on('click', '.remove-bloque8-card', function() {
                if (confirm('¿Estás seguro de que quieres eliminar este comunicado?')) {
                    $(this).closest('.bloque8-card-item').remove();
                }
            });
        });
    </script>
</div>