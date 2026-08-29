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

# Auto-generate APP_KEY if missing in environment & .env
if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction || true
fi

# Ensure storage, database, and upload structures exist
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/testing \
         storage/app/public \
         storage/app/chunks \
         storage/logs \
         public/uploads \
         bootstrap/cache \
         database

# Baseline asset preservation: sync baseline assets to mounted persistent volume if missing
if [ -d "/var/www/html/public/uploads_baseline" ]; then
    cp -rn /var/www/html/public/uploads_baseline/* /var/www/html/public/uploads/ 2>/dev/null || true
fi

# Determine database persistence
DB_CONN="${DB_CONNECTION:-sqlite}"

if [ "$DB_CONN" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"

    if [ "$DB_FILE" != ":memory:" ]; then
        # Check if persistent uploads volume is mounted at /var/www/html/public/uploads
        # If DB_FILE is inside the ephemeral /var/www/html/database/, relocate SQLite to persistent volume storage
        if [ "$DB_FILE" = "/var/www/html/database/database.sqlite" ] || [ "$DB_FILE" = "database/database.sqlite" ]; then
            PERSISTENT_DB_DIR="/var/www/html/public/uploads/.data"
            mkdir -p "$PERSISTENT_DB_DIR"
            PERSISTENT_DB_FILE="$PERSISTENT_DB_DIR/database.sqlite"

            # If persistent DB does not exist yet, copy initial db or touch it
            if [ ! -f "$PERSISTENT_DB_FILE" ]; then
                if [ -f "/var/www/html/database/database.sqlite" ] && [ -s "/var/www/html/database/database.sqlite" ] && [ ! -L "/var/www/html/database/database.sqlite" ]; then
                    cp "/var/www/html/database/database.sqlite" "$PERSISTENT_DB_FILE"
                else
                    touch "$PERSISTENT_DB_FILE"
                fi
            fi

            # Symlink ephemeral path to persistent file
            mkdir -p /var/www/html/database
            rm -f /var/www/html/database/database.sqlite
            ln -sf "$PERSISTENT_DB_FILE" /var/www/html/database/database.sqlite
            chmod 777 "$PERSISTENT_DB_DIR" 2>/dev/null || true
            chmod 666 "$PERSISTENT_DB_FILE" 2>/dev/null || true
        else
            # Custom DB_DATABASE path provided by user
            mkdir -p "$(dirname "$DB_FILE")"
            if [ ! -f "$DB_FILE" ]; then
                touch "$DB_FILE"
            fi
            chmod 777 "$(dirname "$DB_FILE")" 2>/dev/null || true
            chmod 666 "$DB_FILE" 2>/dev/null || true
        fi
    fi
fi

# Set broad read/write permissions for web server
chown -R www-data:www-data storage bootstrap/cache public/uploads database 2>/dev/null || true
chmod -R 777 storage bootstrap/cache public/uploads database 2>/dev/null || true

# Link public storage
php artisan storage:link --no-interaction || true

# Run database migrations (safe and non-destructive for existing tables)
php artisan migrate --force --no-interaction || true

# Run seeding only if explicitly enabled or if database is empty
# Note: DB_SEED_ON_BOOT defaults to false on production redeployments to prevent unintended overwrites
DB_SEED="${DB_SEED_ON_BOOT:-false}"
if [ "$DB_SEED" = "true" ]; then
    php artisan db:seed --force --no-interaction || true
else
    # Always ensure baseline admin account exists without altering custom content
    php artisan db:seed --class=Database\\Seeders\\DatabaseSeeder --force --no-interaction || true
fi

# Optimize Laravel caches
if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan config:cache --no-interaction || true
    php artisan route:cache --no-interaction || true
    php artisan view:cache --no-interaction || true
fi

exec "$@"
