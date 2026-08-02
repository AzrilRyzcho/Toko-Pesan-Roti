# Production Web Server with PHP 8.3 & Nginx (Ultra-fast build)
FROM serversideup/php:8.3-fpm-nginx

# Configure Nginx Document Root & Port
ENV WEBCONFIG_DOCUMENT_ROOT=/var/www/html/public
ENV HTTP_PORT=8080
ENV PORT=8080
ENV AUTORUN_ENABLED=false

USER root

# Copy application source code with compiled assets
COPY --chown=www-data:www-data . /var/www/html

# Install PHP dependencies for Laravel
RUN composer install --no-dev --optimize-autoloader --ignore-platform-req=php+

# Set proper permissions for storage & cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Ensure public/storage symlink exists
RUN php artisan storage:link --force

USER www-data

EXPOSE 8080
