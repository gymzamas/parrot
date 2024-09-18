# Utilisation de l'image officielle PHP 8.2 avec FPM
FROM php:8.2-fpm

# Installation des dépendances système
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql zip

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation des extensions PHP
RUN docker-php-ext-install pdo pdo_mysql

# Copie du code source dans le container
WORKDIR /var/www/html
COPY . .

# Donne les permissions à Symfony
RUN chown -R www-data:www-data /var/www/html

# Lancement de PHP-FPM
CMD ["php-fpm"]
