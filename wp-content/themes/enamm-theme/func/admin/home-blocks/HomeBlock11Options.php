<?php
// admin/home-blocks/HomeBlock11Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div class="wrap">
    <h1>Administración del Bloque 11: Instituciones y Entidades Colaboradoras</h1>
    <p>Gestiona el título de este bloque y las URLs de los logos o imágenes de las instituciones y entidades colaboradoras.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Get existing options
    $current_bloque11_title = get_option( 'my_theme_bloque11_title', 'Los mejores profesionales del sector Instituciones y entidades colaboradoras' );
    $current_bloque11_images = get_option( 'my_theme_bloque11_images', array() );

    if ( isset( $_POST['submit_bloque11_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque11_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Security check failed when saving Block 11 settings.</p></div>';
        } else {
            // Sanitize and save title
            $bloque11_title = isset( $_POST['bloque11_title'] ) ? sanitize_text_field( $_POST['bloque11_title'] ) : '';
            update_option( 'my_theme_bloque11_title', $bloque11_title );
            $current_bloque11_title = $bloque11_title; // Update for display

            // Sanitize and save images
            $new_bloque11_images = array();
            if ( isset( $_POST['bloque11_images'] ) && is_array( $_POST['bloque11_images'] ) ) {
                foreach ( $_POST['bloque11_images'] as $key => $image ) {
                    $image_url = isset( $image['url'] ) ? esc_url_raw( $image['url'] ) : '';
                    $alt_text = isset( $image['alt_text'] ) ? sanitize_text_field( $image['alt_text'] ) : '';
                    $link_url = isset( $image['link_url'] ) ? esc_url_raw( $image['link_url'] ) : ''; // Nuevo campo
                    if ( ! empty( $image_url ) ) {
                        $new_bloque11_images[] = array(
                            'url' => $image_url,
                            'alt_text' => $alt_text,
                            'link_url' => $link_url // Guardar el nuevo campo
                        );
                    }
                }
            }
            update_option( 'my_theme_bloque11_images', $new_bloque11_images );
            $current_bloque11_images = $new_bloque11_images; // Update for display

            echo '<div class="notice notice-success is-dismissible"><p><strong>Block 11 settings updated successfully!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque11_settings' ); // Security field ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque11_title">Título del Bloque 11</label></th>
                    <td>
                        <input type="text" id="bloque11_title" name="bloque11_title" value="<?php echo esc_attr( $current_bloque11_title ); ?>" class="regular-text" placeholder="Ej: Nuestros Colaboradores">
                        <p class="description">Este título aparecerá en la parte superior del Bloque 11.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h2>Imágenes de Colaboradores</h2>
        <div id="bloque11-images-container">
            <?php if ( ! empty( $current_bloque11_images ) ) : ?>
                <?php foreach ( $current_bloque11_images as $index => $image ) : ?>
                    <div class="bloque11-image-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
                        <h3>Imagen #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque11-image">Eliminar</button></h3>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque11_image_url_<?php echo $index; ?>">URL de la Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque11_image_url_<?php echo $index; ?>" name="bloque11_images[<?php echo $index; ?>][url]" value="<?php echo esc_url( $image['url'] ); ?>" class="regular-text" placeholder="URL completa de la imagen">
                                        <p class="description">Copia y pega la URL de tu imagen aquí.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque11_image_alt_<?php echo $index; ?>">Texto Alternativo (Alt)</label></th>
                                    <td>
                                        <input type="text" id="bloque11_image_alt_<?php echo $index; ?>" name="bloque11_images[<?php echo $index; ?>][alt_text]" value="<?php echo esc_attr( $image['alt_text'] ); ?>" class="regular-text" placeholder="Ej: Logo de Empresa X">
                                        <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><label for="bloque11_image_link_url_<?php echo $index; ?>">URL del Enlace</label></th>
                                    <td>
                                        <input type="url" id="bloque11_image_link_url_<?php echo $index; ?>" name="bloque11_images[<?php echo $index; ?>][link_url]" value="<?php echo esc_url( $image['link_url'] ); ?>" class="regular-text" placeholder="Ej: https://www.ejemplo.com">
                                        <p class="description">URL a la que la imagen debe enlazar. Deja en blanco para que no tenga enlace.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <button type="button" class="button button-secondary" id="add-bloque11-image">Añadir Nueva Imagen</button>
        <?php submit_button( 'Guardar Cambios del Bloque 11', 'primary', 'submit_bloque11_settings' ); ?>
    </form>

    <script type="text/template" id="bloque11-image-template">
        <div class="bloque11-image-item" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; background: #f9f9f9;">
            <h3>Nueva Imagen <button type="button" class="button button-secondary remove-bloque11-image">Eliminar</button></h3>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque11_image_url_ID">URL de la Imagen</label></th>
                        <td>
                            <input type="url" id="bloque11_image_url_ID" name="bloque11_images[ID][url]" value="" class="regular-text" placeholder="URL completa de la imagen">
                            <p class="description">Copia y pega la URL de tu imagen aquí.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque11_image_alt_ID">Texto Alternativo (Alt)</label></th>
                        <td>
                            <input type="text" id="bloque11_image_alt_ID" name="bloque11_images[ID][alt_text]" value="" class="regular-text" placeholder="Ej: Logo de Empresa Y">
                            <p class="description">Texto descriptivo para la imagen (importante para SEO y accesibilidad).</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="bloque11_image_link_url_ID">URL del Enlace</label></th>
                        <td>
                            <input type="url" id="bloque11_image_link_url_ID" name="bloque11_images[ID][link_url]" value="" class="regular-text" placeholder="Ej: https://www.ejemplo.com">
                            <p class="description">URL a la que la imagen debe enlazar. Deja en blanco para que no tenga enlace.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Add new image field
            $('#add-bloque11-image').on('click', function() {
                var template = $('#bloque11-image-template').html();
                var newElement = template.replace(/ID/g, Date.now()); // Unique ID
                $('#bloque11-images-container').append(newElement);
            });

            // Remove image field
            $('#bloque11-images-container').on('click', '.remove-bloque11-image', function() {
                if (confirm('Are you sure you want to remove this image?')) {
                    $(this).closest('.bloque11-image-item').remove();
                }
            });
        });
    </script>
</div>