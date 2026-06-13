#!/bin/bash
set -e

# Run composer install if vendor doesn't exist
if [ ! -d "vendor" ]; then
    composer install --no-interaction --optimize-autoloader --no-dev
fi

# Set proper permissions again after composer/artisan commands
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

# Generate application key if not set (or create env if missing)
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

# Link storage
php artisan storage:link --force

# Clear caches
php artisan optimize:clear

# Execute CMD
exec "$@"
