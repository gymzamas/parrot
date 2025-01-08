# Utilisation de l'image officielle PHP 8.3 avec FPM
FROM php:8.3-fpm

# Installation des dépendances système et des extensions PHP nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev zip unzip libssl-dev pkg-config libsodium-dev \
    libgmp-dev zlib1g-dev libpq-dev autoconf \
    && docker-php-ext-install pdo pdo_mysql zip sodium \
    && pecl install grpc protobuf \
    && docker-php-ext-enable grpc protobuf \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copie du code source dans le container
COPY . .

# Changer l'utilisateur www-data pour correspondre à l'ID utilisateur de l'hôte
RUN usermod -u 1000 www-data && chown -R www-data:www-data /var/www/html

# Installation des dépendances Composer, y compris symfony/mime
RUN composer install --no-scripts --no-autoloader --prefer-dist \
    && composer require symfony/mime \
    && composer dump-autoload --optimize

# Lancement de PHP-FPM
CMD ["php-fpm"]
