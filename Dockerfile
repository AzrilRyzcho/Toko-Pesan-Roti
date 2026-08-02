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
FROM richarvey/nginx-php-fpm:latest

# Set configuration environment variables for Nginx & PHP
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_CLI_SCRIPTS=1
ENV REAL_IP_HEADER=1

WORKDIR /var/www/html

# Copy application source code
COPY . /var/www/html

# Copy compiled assets from frontend stage
COPY --from=frontend /app/public/build /var/www/html/public/build

# Install PHP dependencies without dev packages
RUN composer install --no-dev --optimize-autoloader

# Ensure proper permissions for Laravel storage & cache folders
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
