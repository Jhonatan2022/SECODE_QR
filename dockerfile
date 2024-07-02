# Usa la imagen oficial de PHP con Apache
FROM php:7.4-apache

# Instala las extensiones de PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Instala Git y Composer
RUN apt-get update && apt-get install -y git unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clona el repositorio desde GitHub
RUN git clone https://github.com/Jhonatan2022/SECODE_QR.git /var/www/html

# Cambia el directorio de trabajo
WORKDIR /var/www/html

# Instala las dependencias de Composer
RUN composer install --prefer-dist --no-dev --no-scripts --no-interaction --optimize-autoloader

# Establece los permisos correctos
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expone el puerto 80
EXPOSE 80