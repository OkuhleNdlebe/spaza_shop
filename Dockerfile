# -------- Base PHP image --------
FROM php:8.2-fpm AS base

# Set working directory
WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
        git unzip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev zip curl cron rsync \
        nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql zip gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy application files
COPY . .

# SQLite setup
RUN mkdir -p /var/www/html/database \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/database

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Clear and cache Laravel configs
RUN php artisan optimize:clear

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# -------- Node build for assets --------
FROM node:18 AS node_build

WORKDIR /app

# Copy app files and vendor from base
COPY --from=base /var/www/html /app

# Install and build assets (Mix or Vite)
RUN if [ -f "yarn.lock" ]; then \
        yarn install --frozen-lockfile && yarn build; \
    elif [ -f "pnpm-lock.yaml" ]; then \
        corepack enable && corepack prepare pnpm@latest-8 --activate && pnpm install --frozen-lockfile && pnpm run build; \
    elif [ -f "package-lock.json" ]; then \
        npm ci --no-audit && npm run build; \
    else \
        npm install && npm run build; \
    fi

# Copy built assets back to PHP image
FROM base AS final

COPY --from=node_build /app/public /var/www/html/public

# Expose port 8080 (Render default)
EXPOSE 8080

# Run Laravel using PHP-FPM
CMD ["php-fpm"]
