<?php
// admin/home-blocks/HomeBlock9Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 9: Noticias</h1>
    <p>Gestiona el título principal de las noticias, el contenido de cada tarjeta del slider (fecha, texto, imagen) y el botón "Ver Todo".</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Obtener el título principal de noticias
    $current_bloque9_main_title = get_option( 'my_theme_bloque9_main_title', 'Noticias' );

    // Obtener las tarjetas de noticia existentes
    $my_theme_bloque9_cards = get_option( 'my_theme_bloque9_cards', array() );

    // Obtener datos del botón "Ver Todo"
    $current_bloque9_view_all_text = get_option( 'my_theme_bloque9_view_all_text', 'Ver Todo' );
    $current_bloque9_view_all_link = get_option( 'my_theme_bloque9_view_all_link', '#' );
    $current_bloque9_view_all_icon = get_option( 'my_theme_bloque9_view_all_icon', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014497/z9p1ukgynzqqojbvxboy.webp' );


    if ( isset( $_POST['submit_bloque9_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque9_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 9.</p></div>';
        } else {
            // Guardar el título principal
            $bloque9_main_title = isset( $_POST['bloque9_main_title'] ) ? sanitize_text_field( $_POST['bloque9_main_title'] ) : '';
            update_option( 'my_theme_bloque9_main_title', $bloque9_main_title );
            $current_bloque9_main_title = $bloque9_main_title; // Actualizar para mostrar el nuevo valor

            // Guardar las tarjetas de noticia
            $new_bloque9_cards = array();
            if ( isset( $_POST['bloque9_cards'] ) && is_array( $_POST['bloque9_cards'] ) ) {
                foreach ( $_POST['bloque9_cards'] as $key => $card ) {
                    $date_text = isset( $card['date_text'] ) ? sanitize_text_field( $card['date_text'] ) : '';
                    $paragraph_text = isset( $card['paragraph_text'] ) ? sanitize_textarea_field( $card['paragraph_text'] ) : '';
                    $image_url = isset( $card['image_url'] ) ? esc_url_raw( $card['image_url'] ) : '';
                    $alt_text = isset( $card['alt_text'] ) ? sanitize_text_field( $card['alt_text'] ) : '';
                    $card_link = isset( $card['card_link'] ) ? esc_url_raw( $card['card_link'] ) : ''; // Enlace de la tarjeta

                    // Solo añadir si al menos tiene un texto o imagen
                    if ( ! empty( $date_text ) || ! empty( $paragraph_text ) || ! empty( $image_url ) ) {
                        $new_bloque9_cards[] = array(
                            'date_text'      => $date_text,
                            'paragraph_text' => $paragraph_text,
                            'image_url'      => $image_url,
                            'alt_text'       => $alt_text,
                            'card_link'      => $card_link,
                        );
                    }
                }
            }
            update_option( 'my_theme_bloque9_cards', $new_bloque9_cards );
            $my_theme_bloque9_cards = $new_bloque9_cards; // Actualizar para mostrar los cambios

            // Guardar datos del botón "Ver Todo"
            $bloque9_view_all_text = isset( $_POST['bloque9_view_all_text'] ) ? sanitize_text_field( $_POST['bloque9_view_all_text'] ) : '';
            $bloque9_view_all_link = isset( $_POST['bloque9_view_all_link'] ) ? esc_url_raw( $_POST['bloque9_view_all_link'] ) : '';
            $bloque9_view_all_icon = isset( $_POST['bloque9_view_all_icon'] ) ? esc_url_raw( $_POST['bloque9_view_all_icon'] ) : '';

            update_option( 'my_theme_bloque9_view_all_text', $bloque9_view_all_text );
            update_option( 'my_theme_bloque9_view_all_link', $bloque9_view_all_link );
            update_option( 'my_theme_bloque9_view_all_icon', $bloque9_view_all_icon );

            $current_bloque9_view_all_text = $bloque9_view_all_text;
            $current_bloque9_view_all_link = $bloque9_view_all_link;
            $current_bloque9_view_all_icon = $bloque9_view_all_icon;

            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 9 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque9_settings' ); // Campo de seguridad ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque9_main_title">Título Principal del Bloque 9</label></th>
                    <td>
                        <input type="text" id="bloque9_main_title" name="bloque9_main_title" value="<?php echo esc_attr( $current_bloque9_main_title ); ?>" class="regular-text" placeholder="Ej: Noticias">
                        <p class="description">Este es el título grande que aparece en el Bloque 9.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Tarjetas de Noticias</h2>
        <div id="bloque9-cards-container">
            <?php if ( ! empty( $my_theme_bloque9_cards ) ) : ?>
                <?php foreach ( $my_theme_bloque9_cards as $index => $card ) : ?>
                    <div class="bloque9-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Noticia #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque9-card">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque9_date_<?php echo $index; ?>">Fecha</label></th>
                                    <td>
                                        <input type="text" id="bloque9_date_<?php echo $index; ?>" name="bloque9_cards[<?php echo $index; ?>][date_text]" value="<?php echo esc_attr( $card['date_text'] ); ?>" class="regular-text" placeholder="Ej: 1 marzo de 2025">
                                        <p class="description">La fecha de la noticia.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque9_paragraph_<?php echo $index; ?>">Contenido</label></th>
                                    <td>
                                        <textarea id="bloque9_paragraph_<?php echo $index; ?>" name="bloque9_cards[<?php echo $index; ?>][paragraph_text]" class="large-text code" rows="3" placeholder="Ej: Aspirantes a Cadetes Náuticos Visitan Buques..."><?php echo esc_textarea( $card['paragraph_text'] ); ?></textarea>
                                        <p class="description">El texto descriptivo de la noticia.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque9_image_<?php echo $index; ?>">URL de Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque9_image_<?php echo $index; ?>" name="bloque9_cards[<?php echo $index; ?>][image_url]" value="<?php echo esc_url( $card['image_url'] ); ?>" class="regular-text" placeholder="URL de la imagen de la noticia">
                                        <p class="description">URL de la imagen para esta tarjeta de noticia.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque9_alt_<?php echo $index; ?>">Texto Alternativo (Alt)</label></th>
                                    <td>
                                        <input type="text" id="bloque9_alt_<?php echo $index; ?>" name="bloque9_cards[<?php echo $index; ?>][alt_text]" value="<?php echo esc_attr( $card['alt_text'] ); ?>" class="regular-text" placeholder="Ej: Cadetes en buques">
                                        <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque9_link_<?php echo $index; ?>">URL del Enlace (Opcional)</label></th>
                                    <td>
                                        <input type="url" id="bloque9_link_<?php echo $index; ?>" name="bloque9_cards[<?php echo $index; ?>][card_link]" value="<?php echo esc_url( $card['card_link'] ); ?>" class="regular-text" placeholder="https://ejemplo.com/noticia-completa">
                                        <p class="description">URL a la que apunta esta tarjeta (si es clickeable para ver la noticia completa).</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque9-card">Añadir Nueva Noticia</button>

        <h2>Botón "Ver Todo"</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque9_view_all_text">Texto del Botón "Ver Todo"</label></th>
                    <td>
                        <input type="text" id="bloque9_view_all_text" name="bloque9_view_all_text" value="<?php echo esc_attr( $current_bloque9_view_all_text ); ?>" class="regular-text" placeholder="Ej: Ver Todas las Noticias">
                        <p class="description">El texto que se mostrará en el botón al final del bloque.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bloque9_view_all_link">URL del Botón "Ver Todo"</label></th>
                    <td>
                        <input type="url" id="bloque9_view_all_link" name="bloque9_view_all_link" value="<?php echo esc_url( $current_bloque9_view_all_link ); ?>" class="regular-text" placeholder="https://ejemplo.com/todas-las-noticias">
                        <p class="description">La URL a la que el botón "Ver Todo" dirigirá (ej. la página de archivo de noticias).</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bloque9_view_all_icon">URL del Ícono "Ver Todo"</label></th>
                    <td>
                        <input type="url" id="bloque9_view_all_icon" name="bloque9_view_all_icon" value="<?php echo esc_url( $current_bloque9_view_all_icon ); ?>" class="regular-text" placeholder="URL del ícono">
                        <p class="description">La URL de la imagen del ícono que acompaña al texto "Ver Todo".</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <?php submit_button( 'Guardar Cambios del Bloque 9', 'primary', 'submit_bloque9_settings' ); ?>
    </form>

    <script type="text/template" id="bloque9-card-template">
        <div class="bloque9-card-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Noticia <button type="button" class="button button-secondary remove-bloque9-card">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque9_date_ID">Fecha</label></th>
                        <td>
                            <input type="text" id="bloque9_date_ID" name="bloque9_cards[ID][date_text]" value="" class="regular-text" placeholder="Ej: 1 marzo de 2025">
                            <p class="description">La fecha de la noticia.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque9_paragraph_ID">Contenido</label></th>
                        <td>
                            <textarea id="bloque9_paragraph_ID" name="bloque9_cards[ID][paragraph_text]" class="large-text code" rows="3" placeholder="Ej: Aspirantes a Cadetes Náuticos Visitan Buques..."></textarea>
                            <p class="description">El texto descriptivo de la noticia.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque9_image_ID">URL de Imagen</label></th>
                        <td>
                            <input type="url" id="bloque9_image_ID" name="bloque9_cards[ID][image_url]" value="" class="regular-text" placeholder="URL de la imagen de la noticia">
                            <p class="description">URL de la imagen para esta tarjeta de noticia.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque9_alt_ID">Texto Alternativo (Alt)</label></th>
                        <td>
                            <input type="text" id="bloque9_alt_ID" name="bloque9_cards[ID][alt_text]" value="" class="regular-text" placeholder="Ej: Cadetes en buques">
                            <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque9_link_ID">URL del Enlace (Opcional)</label></th>
                        <td>
                            <input type="url" id="bloque9_link_ID" name="bloque9_cards[ID][card_link]" value="" class="regular-text" placeholder="https://ejemplo.com/noticia-completa">
                            <p class="description">URL a la que apunta esta tarjeta (si es clickeable para ver la noticia completa).</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nueva tarjeta de noticia
            $('#add-bloque9-card').on('click', function() {
                var template = $('#bloque9-card-template').html();
                var newCard = template.replace(/ID/g, Date.now()); // Usar timestamp para ID único
                $('#bloque9-cards-container').append(newCard);
            });

            // Eliminar tarjeta de noticia
            $('#bloque9-cards-container').on('click', '.remove-bloque9-card', function() {
                if (confirm('¿Estás seguro de que quieres eliminar esta noticia?')) {
                    $(this).closest('.bloque9-card-item').remove();
                }
            });
        });
    </script>
</div>