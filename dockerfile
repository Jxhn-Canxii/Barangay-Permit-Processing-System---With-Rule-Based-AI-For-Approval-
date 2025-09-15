# Stage 1: PHP dependencies (Composer)
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist
COPY . .
RUN composer dump-autoload --optimize

# Stage 2: Node dependencies (for Vite / Mix)
FROM node:20 AS frontend
WORKDIR /app
COPY package.json package-lock.json* yarn.lock* ./
RUN npm install
COPY . .
RUN npm run build

# Stage 3: Final runtime (Nginx + PHP-FPM)
FROM php:8.2-fpm

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Copy vendor files from composer stage
COPY --from=vendor /app /var/www/html

# Copy compiled frontend assets
COPY --from=frontend /app/public /var/www/html/public

# Set working dir
WORKDIR /var/www/html

# Set permissions for Laravel storage & bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

CMD ["php-fpm"]
