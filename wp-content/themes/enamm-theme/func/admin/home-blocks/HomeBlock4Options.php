<?php
// admin/home-blocks/HomeBlock4Options.php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Salir si se accede directamente
}

?>
<div class="wrap">
    <h1>Administración del Bloque 4: Capacitación y Entrenamiento</h1>
    <p>Gestiona los textos y las imágenes de los logos para la sección izquierda, y las imágenes del slider de la sección derecha.</p>

    <?php
    // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
    // Recuperar datos existentes para la sección izquierda
    $current_bloque4_h4 = get_option( 'my_theme_bloque4_h4_text', 'Curso' );
    $current_bloque4_h3 = get_option( 'my_theme_bloque4_h3_text', 'Capacitación y entrenamiento' );
    $current_bloque4_p = get_option( 'my_theme_bloque4_p_text', 'Somos un centro homologado por la Dirección General de Capitanías y Guardacostas, para impartir los cursos de especialidad marítima. Con la garantía y homologación de:' );
    $current_bloque4_logos = get_option( 'my_theme_bloque4_logos', array() );

    // Recuperar datos existentes para el slider derecho
    $current_bloque4_slider_images = get_option( 'my_theme_bloque4_slider_images', array() );


    if ( isset( $_POST['submit_bloque4_settings'] ) ) {
        if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque4_settings' ) ) {
            echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo de seguridad al intentar guardar los datos del Bloque 4.</p></div>';
        } else {
            // Guardar textos de la sección izquierda
            $bloque4_h4 = isset( $_POST['bloque4_h4_text'] ) ? sanitize_text_field( $_POST['bloque4_h4_text'] ) : '';
            $bloque4_h3 = isset( $_POST['bloque4_h3_text'] ) ? sanitize_text_field( $_POST['bloque4_h3_text'] ) : '';
            $bloque4_p = isset( $_POST['bloque4_p_text'] ) ? sanitize_textarea_field( $_POST['bloque4_p_text'] ) : '';

            update_option( 'my_theme_bloque4_h4_text', $bloque4_h4 );
            update_option( 'my_theme_bloque4_h3_text', $bloque4_h3 );
            update_option( 'my_theme_bloque4_p_text', $bloque4_p );

            // Actualizar variables locales
            $current_bloque4_h4 = $bloque4_h4;
            $current_bloque4_h3 = $bloque4_h3;
            $current_bloque4_p = $bloque4_p;

            // Guardar logos de la sección izquierda
            $new_bloque4_logos = array();
            if ( isset( $_POST['bloque4_logos'] ) && is_array( $_POST['bloque4_logos'] ) ) {
                foreach ( $_POST['bloque4_logos'] as $key => $logo ) {
                    $logo_url = isset( $logo['url'] ) ? esc_url_raw( $logo['url'] ) : '';
                    if ( ! empty( $logo_url ) ) {
                        $new_bloque4_logos[] = array( 'url' => $logo_url );
                    }
                }
            }
            update_option( 'my_theme_bloque4_logos', $new_bloque4_logos );
            $current_bloque4_logos = $new_bloque4_logos;

            // Guardar imágenes del slider derecho
            $new_bloque4_slider_images = array();
            if ( isset( $_POST['bloque4_slider_images'] ) && is_array( $_POST['bloque4_slider_images'] ) ) {
                foreach ( $_POST['bloque4_slider_images'] as $key => $image ) {
                    $image_url = isset( $image['url'] ) ? esc_url_raw( $image['url'] ) : '';
                    if ( ! empty( $image_url ) ) {
                        $new_bloque4_slider_images[] = array( 'url' => $image_url );
                    }
                }
            }
            update_option( 'my_theme_bloque4_slider_images', $new_bloque4_slider_images );
            $current_bloque4_slider_images = $new_bloque4_slider_images;

            echo '<div class="notice notice-success is-dismissible"><p><strong>¡Datos del Bloque 4 actualizados correctamente!</strong></p></div>';
        }
    }
    ?>

    <form method="post" action="">
        <?php wp_nonce_field( 'save_bloque4_settings' ); // Campo de seguridad ?>

        <h2>Contenido de la Sección Izquierda</h2>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="bloque4_h4_text">Texto Pequeño (H4)</label></th>
                    <td>
                        <input type="text" id="bloque4_h4_text" name="bloque4_h4_text" value="<?php echo esc_attr( $current_bloque4_h4 ); ?>" class="regular-text" placeholder="Ej: Curso">
                        <p class="description">Texto para el encabezado &lt;h4&gt;.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bloque4_h3_text">Título Principal (H3)</label></th>
                    <td>
                        <input type="text" id="bloque4_h3_text" name="bloque4_h3_text" value="<?php echo esc_attr( $current_bloque4_h3 ); ?>" class="regular-text" placeholder="Ej: Capacitación y entrenamiento">
                        <p class="description">Título principal para la sección izquierda del bloque.</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bloque4_p_text">Párrafo de Descripción</label></th>
                    <td>
                        <textarea id="bloque4_p_text" name="bloque4_p_text" rows="4" cols="50" class="large-text" placeholder="Escribe la descripción aquí."><?php echo esc_textarea( $current_bloque4_p ); ?></textarea>
                        <p class="description">Descripción detallada del curso o capacitación.</p>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3>Logos de Garantía (Sección Izquierda)</h3>
        <div id="bloque4-logos-container">
            <?php if ( ! empty( $current_bloque4_logos ) ) : ?>
                <?php foreach ( $current_bloque4_logos as $index => $logo ) : ?>
                    <div class="bloque4-logo-item" style="border: 1px solid #eee; padding: 10px; margin-bottom: 10px; background: #fafafa;">
                        <h4>Logo #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque4-logo">Eliminar</button></h4>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque4_logo_url_<?php echo $index; ?>">URL del Logo</label></th>
                                    <td>
                                        <input type="url" id="bloque4_logo_url_<?php echo $index; ?>" name="bloque4_logos[<?php echo $index; ?>][url]" value="<?php echo esc_url( $logo['url'] ); ?>" class="regular-text" placeholder="URL del logo">
                                        <p class="description">URL completa de la imagen del logo.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-secondary" id="add-bloque4-logo">Añadir Nuevo Logo</button>

        <h2>Imágenes del Slider (Sección Derecha)</h2>
        <div id="bloque4-slider-images-container">
            <?php if ( ! empty( $current_bloque4_slider_images ) ) : ?>
                <?php foreach ( $current_bloque4_slider_images as $index => $image ) : ?>
                    <div class="bloque4-slider-image-item" style="border: 1px solid #eee; padding: 10px; margin-bottom: 10px; background: #fafafa;">
                        <h4>Imagen Slider #<?php echo $index + 1; ?> <button type="button" class="button button-secondary remove-bloque4-slider-image">Eliminar</button></h4>
                        <table class="form-table">
                            <tbody>
                                <tr>
                                    <th scope="row"><label for="bloque4_slider_image_url_<?php echo $index; ?>">URL de la Imagen</label></th>
                                    <td>
                                        <input type="url" id="bloque4_slider_image_url_<?php echo $index; ?>" name="bloque4_slider_images[<?php echo $index; ?>][url]" value="<?php echo esc_url( $image['url'] ); ?>" class="regular-text" placeholder="URL de la imagen del slider">
                                        <p class="description">URL completa de la imagen para el slider.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button type="button" class="button button-secondary" id="add-bloque4-slider-image">Añadir Nueva Imagen al Slider</button>

        <?php submit_button( 'Guardar Cambios del Bloque 4', 'primary', 'submit_bloque4_settings' ); ?>
    </form>

    <script type="text/template" id="bloque4-logo-template">
        <div class="bloque4-logo-item" style="border: 1px solid #eee; padding: 10px; margin-bottom: 10px; background: #fafafa;">
            <h4>Nuevo Logo <button type="button" class="button button-secondary remove-bloque4-logo">Eliminar</button></h4>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque4_logo_url_ID">URL del Logo</label></th>
                        <td>
                            <input type="url" id="bloque4_logo_url_ID" name="bloque4_logos[ID][url]" value="" class="regular-text" placeholder="URL del logo">
                            <p class="description">URL completa de la imagen del logo.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script type="text/template" id="bloque4-slider-image-template">
        <div class="bloque4-slider-image-item" style="border: 1px solid #eee; padding: 10px; margin-bottom: 10px; background: #fafafa;">
            <h4>Nueva Imagen Slider <button type="button" class="button button-secondary remove-bloque4-slider-image">Eliminar</button></h4>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="bloque4_slider_image_url_ID">URL de la Imagen</label></th>
                        <td>
                            <input type="url" id="bloque4_slider_image_url_ID" name="bloque4_slider_images[ID][url]" value="" class="regular-text" placeholder="URL de la imagen del slider">
                            <p class="description">URL completa de la imagen para el slider.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </script>

    <script>
        jQuery(document).ready(function($){
            // Añadir nuevo logo
            $('#add-bloque4-logo').on('click', function() {
                var template = $('#bloque4-logo-template').html();
                var newElement = template.replace(/ID/g, Date.now());
                $('#bloque4-logos-container').append(newElement);
            });

            // Eliminar logo
            $('#bloque4-logos-container').on('click', '.remove-bloque4-logo', function() {
                if (confirm('¿Estás seguro de que quieres eliminar este logo?')) {
                    $(this).closest('.bloque4-logo-item').remove();
                }
            });

            // Añadir nueva imagen al slider
            $('#add-bloque4-slider-image').on('click', function() {
                var template = $('#bloque4-slider-image-template').html();
                var newElement = template.replace(/ID/g, Date.now());
                $('#bloque4-slider-images-container').append(newElement);
            });

            // Eliminar imagen del slider
            $('#bloque4-slider-images-container').on('click', '.remove-bloque4-slider-image', function() {
                if (confirm('¿Estás seguro de que quieres eliminar esta imagen del slider?')) {
                    $(this).closest('.bloque4-slider-image-item').remove();
                }
            });
        });
    </script>
</div>