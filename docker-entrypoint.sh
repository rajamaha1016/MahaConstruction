#!/bin/sh
set -eu

# Bind Apache to dynamic PORT if provided (Render, Railway, Fly.io, Cloud Run)
if [ -n "${PORT:-}" ]; then
    sed -ri "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
    sed -ri "s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

# Ensure only single mpm_prefork module is active
rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# Ensure .env file exists in container
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# Ensure storage, database, and upload structures exist
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/testing \
         storage/app/public \
         storage/logs \
         public/uploads \
         bootstrap/cache \
         database

# Ensure SQLite file exists with write permissions
DB_CONN="${DB_CONNECTION:-sqlite}"
if [ "$DB_CONN" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    if [ "$DB_FILE" != ":memory:" ]; then
        mkdir -p "$(dirname "$DB_FILE")"
        touch "$DB_FILE"
        chmod 666 "$DB_FILE" 2>/dev/null || true
    fi
fi

# Set broad read/write permissions for web server
chown -R www-data:www-data storage bootstrap/cache public/uploads database 2>/dev/null || true
chmod -R 777 storage bootstrap/cache public/uploads database 2>/dev/null || true

# Auto-generate APP_KEY if missing in environment & .env
if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction || true
fi

# Link public storage
php artisan storage:link --no-interaction || true

# Run database migrations
php artisan migrate --force --no-interaction || true

# Seed database if requested or initial boot
if [ "${DB_SEED_ON_BOOT:-true}" = "true" ]; then
    php artisan db:seed --force --no-interaction || true
fi

# Optimize Laravel caches
if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan config:cache --no-interaction || true
    php artisan route:cache --no-interaction || true
    php artisan view:cache --no-interaction || true
fi

exec "$@"
