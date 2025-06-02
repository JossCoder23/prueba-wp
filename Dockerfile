# Usa la imagen oficial de WordPress como base
FROM wordpress:latest

# Establece el directorio de trabajo donde WordPress reside en el contenedor
WORKDIR /var/www/html

# Copia solo tu carpeta wp-content.
# wp-admin y wp-includes ya están en la imagen base.
COPY wp-content/ wp-content/

# Expone el puerto 80, el puerto por defecto para Apache en la imagen de WordPress
EXPOSE 80