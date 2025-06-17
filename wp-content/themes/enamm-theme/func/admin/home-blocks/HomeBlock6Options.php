<?php
// admin/home-blocks/HomeBlock6Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div class="wrap">
    <h1>Administración del Bloque 6: Logos / Galería Simple</h1>
    <p>Gestiona el título de este bloque y las URLs de las imágenes que se mostrarán en él.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Get existing options
    $current_bloque6_title = get_option( 'my_theme_bloque6_title', 'Nuestros Aliados' );
    $current_bloque6_images = get_option( 'my_theme_bloque6_images', array() );

    if ( isset( $_POST['submit_bloque6_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque6_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Security check failed when saving Block 6 settings.</p></div>';
        } else {
            // Sanitize and save title
            $bloque6_title = isset( $_POST['bloque6_title'] ) ? sanitize_text_field( $_POST['bloque6_title'] ) : '';
            update_option( 'my_theme_bloque6_title', $bloque6_title );
            $current_bloque6_title = $bloque6_title; // Update for display

            // Sanitize and save images
            $new_bloque6_images = array();
            if ( isset( $_POST['bloque6_images'] ) && is_array( $_POST['bloque6_images'] ) ) {
                foreach ( $_POST['bloque6_images'] as $key => $image ) {
                    $image_url = isset( $image['url'] ) ? esc_url_raw( $image['url'] ) : '';
                    if ( ! empty( $image_url ) ) {
                        $new_bloque6_images[] = array( 'url' => $image_url );
                    }
                }
            }
            update_option( 'my_theme_bloque6_images', $new_bloque6_images );
            $current_bloque6_images = $new_bloque6_images; // Update for display

            echo '<div class="notice notice-success is-dismissible"><p><strong>Block 6 settings updated successfully!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque6_settings' ); // Security field ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque6_title">Título del Bloque 6</label></th>
                    <td>
                        <input type="text" id="bloque6_title" name="bloque6_title" value="<?php echo esc_attr( $current_bloque6_title ); ?>" class="regular-text" placeholder="Ej: Nuestros Aliados">
                        <p class="description">Este título aparecerá en la parte superior del Bloque 6.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Imágenes del Bloque 6</h2>
        <div id="bloque6-images-container">
            <?php if ( ! empty( $current_bloque6_images ) ) : ?>
                <?php foreach ( $current_bloque6_images as $index => $image ) : ?>
                    <div class="bloque6-image-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Imagen #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque6-image">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque6_image_url_<?php echo $index; ?>">URL de la Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque6_image_url_<?php echo $index; ?>" name="bloque6_images[<?php echo $index; ?>][url]" value="<?php echo esc_url( $image['url'] ); ?>" class="regular-text" placeholder="URL completa de la imagen">
                                        <p class="description">Copia y pega la URL de tu imagen aquí.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque6-image">Añadir Nueva Imagen</button>
        <?php submit_button( 'Guardar Cambios del Bloque 6', 'primary', 'submit_bloque6_settings' ); ?>
    </form>

    <script type="text/template" id="bloque6-image-template">
        <div class="bloque6-image-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Imagen <button type="button" class="button button-secondary remove-bloque6-image">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque6_image_url_ID">URL de la Imagen</label></th>
                        <td>
                            <input type="url" id="bloque6_image_url_ID" name="bloque6_images[ID][url]" value="" class="regular-text" placeholder="URL completa de la imagen">
                            <p class="description">Copia y pega la URL de tu imagen aquí.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Add new image field
            $('#add-bloque6-image').on('click', function() {
                var template = $('#bloque6-image-template').html();
                var newElement = template.replace(/ID/g, Date.now()); // Unique ID
                $('#bloque6-images-container').append(newElement);
            });

            // Remove image field
            $('#bloque6-images-container').on('click', '.remove-bloque6-image', function() {
                if (confirm('Are you sure you want to remove this image?')) {
                    $(this).closest('.bloque6-image-item').remove();
                }
            });
        });
    </script>
</div>