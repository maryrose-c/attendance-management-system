FROM php:8.3-apache

RUN apt-get update && apt-get install -y \
    curl ca-certificates git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .

RUN composer install --no-dev --optimize-autoloader \
    && npm ci \
    && npm run build \
    && mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache database \
    && touch database/database.sqlite \
    && chown -R www-data:www-data storage bootstrap/cache database \
    && chmod -R 775 storage bootstrap/cache database

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
EXPOSE 80

CMD php artisan migrate --force && php artisan db:seed --force && apache2-foreground
