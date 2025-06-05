<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); // Esencial: Carga estilos, scripts, metadatos. ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); // Hook para WordPress 5.2+ ?>

    <header style="background-color:red">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Mi Sitio Web</a>
        <nav>
            <ul>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a></li>
                <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Página de Ejemplo</a></li>
            </ul>
        </nav>
    </header>

    ```

---

## Contenido de `footer.php` (Mínimo PHP)

Copia este código en tu archivo `wp-content/themes/tu-tema-personalizado/footer.php`:

```php
    

<?php wp_footer(); // Esencial: Carga scripts JavaScript al final. ?>
</body>
</html>