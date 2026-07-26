FROM php:8.4-fpm

WORKDIR /var/www/html

# System dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev libzip-dev libicu-dev zip unzip nginx \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application
COPY . .

# Install dependencies and optimize
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-cache
RUN php artisan config:cache || true
RUN php artisan view:cache || true
RUN php artisan storage:link --force || true
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Nginx config
COPY nginx.conf /etc/nginx/sites-enabled/default

EXPOSE 8080

CMD php-fpm -D && nginx -g "daemon off;"
