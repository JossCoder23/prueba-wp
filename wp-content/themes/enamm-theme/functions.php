<?php
/**
 * Tema Personalizado - functions.php
 *
 * El archivo principal que carga todas las funcionalidades modulares del tema.
 */

// Incluir archivos de funcionalidad modular
require_once get_template_directory() . '/func/setup.php';
require_once get_template_directory() . '/func/enqueue.php';
require_once get_template_directory() . '/func/admin/footer-options.php';
require_once get_template_directory() . '/func/cleanup.php';
// require_once get_template_directory() . '/inc/custom-functions.php'; // Si añades otras funciones

// Puedes añadir más archivos de inclusión aquí según necesites modularizar
// Por ejemplo:
// require_once get_template_directory() . '/inc/widgets.php';
// require_once get_template_directory() . '/inc/customizer.php';