FROM php:8.2-apache
# Instalar extensiones de PHP para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

COPY *.php /var/www/html

