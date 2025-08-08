<?php
// admin/home-blocks/HomeBlock6Options.php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

?>
<div class="wrap">
  <h1>Administración del Bloque 6: Imágenes Responsive</h1>
  <p>Gestiona la imagen para dispositivos móviles y la imagen para escritorio.</p>

  <?php
  // --- LÓGICA DE PROCESAMIENTO DEL FORMULARIO Y GUARDADO ---
  // Get existing options
  $current_bloque6_mobile_image = get_option( 'my_theme_bloque6_mobile_image', '' );
  $current_bloque6_desktop_image = get_option( 'my_theme_bloque6_desktop_image', '' );

  if ( isset( $_POST['submit_bloque6_settings'] ) ) {
    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'save_bloque6_settings' ) ) {
      echo '<div class="notice notice-error is-dismissible"><p><strong>Error:</strong> Fallo en la verificación de seguridad al guardar la configuración del Bloque 6.</p></div>';
    } else {
      // Sanitize and save mobile image URL
      $bloque6_mobile_image = isset( $_POST['bloque6_mobile_image'] ) ? esc_url_raw( $_POST['bloque6_mobile_image'] ) : '';
      update_option( 'my_theme_bloque6_mobile_image', $bloque6_mobile_image );
      $current_bloque6_mobile_image = $bloque6_mobile_image;

      // Sanitize and save desktop image URL
      $bloque6_desktop_image = isset( $_POST['bloque6_desktop_image'] ) ? esc_url_raw( $_POST['bloque6_desktop_image'] ) : '';
      update_option( 'my_theme_bloque6_desktop_image', $bloque6_desktop_image );
      $current_bloque6_desktop_image = $bloque6_desktop_image;

      echo '<div class="notice notice-success is-dismissible"><p><strong>¡Configuración del Bloque 6 actualizada con éxito!</strong></p></div>';
    }
  }
  ?>

  <form method="post" action="">
    <?php wp_nonce_field( 'save_bloque6_settings' ); // Campo de seguridad ?>

    <table class="form-table">
      <tbody>
    <tr>
  <th scope="row"><label for="bloque6_mobile_image">URL de la Imagen para Móvil</label></th>
  <td>
  <input type="url" id="bloque6_mobile_image" name="bloque6_mobile_image" value="<?php echo esc_url( $current_bloque6_mobile_image ); ?>" class="regular-text" placeholder="URL completa de la imagen para móvil">
  <p class="description">Copia y pega la URL de la imagen que se mostrará en dispositivos móviles.</p>
  </td>
  </tr>
  <tr>
  <th scope="row"><label for="bloque6_desktop_image">URL de la Imagen para Escritorio</label></th>
  <td>
  <input type="url" id="bloque6_desktop_image" name="bloque6_desktop_image" value="<?php echo esc_url( $current_bloque6_desktop_image ); ?>" class="regular-text" placeholder="URL completa de la imagen para escritorio">
  <p class="description">Copia y pega la URL de la imagen que se mostrará en dispositivos de escritorio.</p>
        </td>
        </tr>
      </tbody>
    </table>

    <?php submit_button( 'Guardar Cambios del Bloque 6', 'primary', 'submit_bloque6_settings' ); ?>
  </form>
</div>