#!/bin/sh
set -eu

# Bind Apache to dynamic PORT if provided (Render, Railway, Fly.io, Cloud Run)
if [ -n "${PORT:-}" ]; then
    sed -ri "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
    sed -ri "s/<VirtualHost \\*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

# Ensure storage structure exists
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/testing \
         storage/app/public \
         storage/logs \
         public/uploads \
         bootstrap/cache

# If SQLite is configured, ensure SQLite file exists
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ] && [ -n "${DB_DATABASE:-}" ] && [ "${DB_DATABASE}" != ":memory:" ]; then
    if [ ! -f "${DB_DATABASE}" ]; then
        mkdir -p "$(dirname "${DB_DATABASE}")"
        touch "${DB_DATABASE}"
        chown -R www-data:www-data "$(dirname "${DB_DATABASE}")" 2>/dev/null || true
    fi
fi

# Set permissions
chown -R www-data:www-data storage bootstrap/cache public/uploads 2>/dev/null || true
chmod -R 775 storage bootstrap/cache public/uploads 2>/dev/null || true

# Link public storage
php artisan storage:link --no-interaction || true

# Run database migrations
php artisan migrate --force --no-interaction || true

# Seed database if explicitly requested or on fresh installation
if [ "${DB_SEED_ON_BOOT:-true}" = "true" ]; then
    php artisan db:seed --force --no-interaction || true
fi

# Optimize Laravel for production
if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan config:cache --no-interaction || true
    php artisan route:cache --no-interaction || true
    php artisan view:cache --no-interaction || true
fi

exec "$@"
