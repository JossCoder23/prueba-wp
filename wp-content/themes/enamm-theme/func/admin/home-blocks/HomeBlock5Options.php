<?php
// admin/home-blocks/HomeBlock5Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 5: Cursos Especiales</h1>
    <p>Gestiona las imágenes de fondo, la imagen principal de la izquierda y el contenido de los ítems de curso de la derecha.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Recuperar URLs de imágenes de fondo
    $current_bloque5_backimage_top = get_option( 'my_theme_bloque5_backimage_top', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/idekvlaltcopvre1zoh4.webp' );
    $current_bloque5_backimage_bottom = get_option( 'my_theme_bloque5_backimage_bottom', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/zkrvisvy9iv7inogxhsq.webp' );

    // Recuperar URL de imagen principal izquierda
    $current_bloque5_left_image = get_option( 'my_theme_bloque5_left_image', 'https://res.cloudinary.com/dpuerx2lr/image/upload/v1749014492/hkbp5qejgqbz8350z5la.webp' );

    // Recuperar ítems de curso
    $my_theme_bloque5_items = get_option( 'my_theme_bloque5_items', array() );

    if ( isset( $_POST['submit_bloque5_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque5_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 5.</p></div>';
        } else {
            // Guardar URLs de imágenes de fondo
            $bloque5_backimage_top = isset( $_POST['bloque5_backimage_top'] ) ? esc_url_raw( $_POST['bloque5_backimage_top'] ) : '';
            $bloque5_backimage_bottom = isset( $_POST['bloque5_backimage_bottom'] ) ? esc_url_raw( $_POST['bloque5_backimage_bottom'] ) : '';

            update_option( 'my_theme_bloque5_backimage_top', $bloque5_backimage_top );
            update_option( 'my_theme_bloque5_backimage_bottom', $bloque5_backimage_bottom );

            $current_bloque5_backimage_top = $bloque5_backimage_top;
            $current_bloque5_backimage_bottom = $bloque5_backimage_bottom;

            // Guardar URL de imagen principal izquierda
            $bloque5_left_image = isset( $_POST['bloque5_left_image'] ) ? esc_url_raw( $_POST['bloque5_left_image'] ) : '';
            update_option( 'my_theme_bloque5_left_image', $bloque5_left_image );
            $current_bloque5_left_image = $bloque5_left_image;

            // Guardar ítems de curso
            $new_bloque5_items = array();
            if ( isset( $_POST['bloque5_items'] ) && is_array( $_POST['bloque5_items'] ) ) {
                foreach ( $_POST['bloque5_items'] as $key => $item ) {
                    $h3_text = isset( $item['h3_text'] ) ? sanitize_text_field( $item['h3_text'] ) : '';
                    $h4_text = isset( $item['h4_text'] ) ? sanitize_text_field( $item['h4_text'] ) : '';
                    $item_link = isset( $item['item_link'] ) ? esc_url_raw( $item['item_link'] ) : '';

                    // Solo añadir si al menos tiene un texto o enlace
                    if ( ! empty( $h3_text ) || ! empty( $h4_text ) || ! empty( $item_link ) ) {
                        $new_bloque5_items[] = array(
                            'h3_text' => $h3_text,
                            'h4_text' => $h4_text,
                            'item_link' => $item_link,
                        );
                    }
                }
            }
            update_option( 'my_theme_bloque5_items', $new_bloque5_items );
            $my_theme_bloque5_items = $new_bloque5_items;

            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 5 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    ---

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque5_settings' ); // Campo de seguridad ?>

        <h2>Imágenes de Fondo</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque5_backimage_top">URL Imagen de Fondo Superior</label></th>
                    <td>
                        <input type="url" id="bloque5_backimage_top" name="bloque5_backimage_top" value="<?php echo esc_url( $current_bloque5_backimage_top ); ?>" class="regular-text" placeholder="URL de la imagen superior">
                        <p class="description">URL de la imagen que aparecerá en la parte superior del fondo del Bloque 5.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bloque5_backimage_bottom">URL Imagen de Fondo Inferior</label></th>
                    <td>
                        <input type="url" id="bloque5_backimage_bottom" name="bloque5_backimage_bottom" value="<?php echo esc_url( $current_bloque5_backimage_bottom ); ?>" class="regular-text" placeholder="URL de la imagen inferior">
                        <p class="description">URL de la imagen que aparecerá en la parte inferior del fondo del Bloque 5.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        ---

        <h2>Imagen Principal (Izquierda)</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque5_left_image">URL Imagen Principal Izquierda</label></th>
                    <td>
                        <input type="url" id="bloque5_left_image" name="bloque5_left_image" value="<?php echo esc_url( $current_bloque5_left_image ); ?>" class="regular-text" placeholder="URL de la imagen izquierda">
                        <p class="description">URL de la imagen grande que aparece en la sección izquierda del Bloque 5.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        ---

        <h2>Ítems de Curso (Sección Derecha)</h2>
        <div id="bloque5-items-container">
            <?php if ( ! empty( $my_theme_bloque5_items ) ) : ?>
                <?php foreach ( $my_theme_bloque5_items as $index => $item ) : ?>
                    <div class="bloque5-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Ítem de Curso #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque5-item">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque5_h3_text_<?php echo $index; ?>">Título (H3)</label></th>
                                    <td>
                                        <input type="text" id="bloque5_h3_text_<?php echo $index; ?>" name="bloque5_items[<?php echo $index; ?>][h3_text]" value="<?php echo esc_attr( $item['h3_text'] ); ?>" class="regular-text" placeholder="Ej: Cursos OMI">
                                        <p class="description">Título principal del ítem de curso.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque5_h4_text_<?php echo $index; ?>">Texto de Enlace (H4)</label></th>
                                    <td>
                                        <input type="text" id="bloque5_h4_text_<?php echo $index; ?>" name="bloque5_items[<?php echo $index; ?>][h4_text]" value="<?php echo esc_attr( $item['h4_text'] ); ?>" class="regular-text" placeholder="Ej: Ver curso">
                                        <p class="description">Texto para el enlace "Ver curso".</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque5_item_link_<?php echo $index; ?>">URL del Enlace</label></th>
                                    <td>
                                        <input type="url" id="bloque5_item_link_<?php echo $index; ?>" name="bloque5_items[<?php echo $index; ?>][item_link]" value="<?php echo esc_url( $item['item_link'] ); ?>" class="regular-text" placeholder="https://ejemplo.com/curso-omi">
                                        <p class="description">URL a la que apunta el ítem de curso.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-secondary" id="add-bloque5-item">Añadir Nuevo Ítem de Curso</button>

        <?php submit_button( 'Guardar Cambios del Bloque 5', 'primary', 'submit_bloque5_settings' ); ?>
    </form>

    <script type="text/template" id="bloque5-item-template">
        <div class="bloque5-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nuevo Ítem de Curso <button type="button" class="button button-secondary remove-bloque5-item">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque5_h3_text_ID">Título (H3)</label></th>
                        <td>
                            <input type="text" id="bloque5_h3_text_ID" name="bloque5_items[ID][h3_text]" value="" class="regular-text" placeholder="Ej: Cursos OMI">
                            <p class="description">Título principal del ítem de curso.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque5_h4_text_ID">Texto de Enlace (H4)</label></th>
                        <td>
                            <input type="text" id="bloque5_h4_text_ID" name="bloque5_items[ID][h4_text]" value="" class="regular-text" placeholder="Ej: Ver curso">
                            <p class="description">Texto para el enlace "Ver curso".</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque5_item_link_ID">URL del Enlace</label></th>
                        <td>
                            <input type="url" id="bloque5_item_link_ID" name="bloque5_items[ID][item_link]" value="" class="regular-text" placeholder="https://ejemplo.com/curso-omi">
                            <p class="description">URL a la que apunta el ítem de curso.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nuevo ítem de curso
            $('#add-bloque5-item').on('click', function() {
                var template = $('#bloque5-item-template').html();
                var newElement = template.replace(/ID/g, Date.now());
                $('#bloque5-items-container').append(newElement);
            });

            // Eliminar ítem de curso
            $('#bloque5-items-container').on('click', '.remove-bloque5-item', function() {
                if (confirm('¿Estás seguro de que quieres eliminar este ítem de curso?')) {
                    $(this).closest('.bloque5-item').remove();
                }
            });
        });
    </script>
</div>