# Stage 1: Build Frontend Assets (Vite)
FROM node:20-alpine AS frontend
WORKDIR /app

# Copy package files and install JS dependencies
COPY package*.json ./
RUN npm ci || npm install

# Copy source code and build Vite production assets
COPY . .
RUN npm run build

# Stage 2: Production Web Server with PHP 8.3 & Nginx
FROM serversideup/php:8.3-fpm-nginx

# Configure Nginx Document Root to Laravel /public folder
ENV WEBCONFIG_DOCUMENT_ROOT=/var/www/html/public

USER root

# Copy application source code
COPY --chown=www-data:www-data . /var/www/html

# Copy compiled assets from frontend stage
COPY --from=frontend --chown=www-data:www-data /app/public/build /var/www/html/public/build

# Install PHP dependencies for Laravel
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=php+

# Set proper permissions for storage & cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data
