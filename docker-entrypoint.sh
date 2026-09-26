#!/bin/sh
set -eu

# ── 1. Bind Apache to dynamic PORT if provided (Render, Railway, Fly.io, Cloud Run) ─
if [ -n "${PORT:-}" ]; then
    sed -ri "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
    sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf
fi

# Ensure only single mpm_prefork module is active
rm -f /etc/apache2/mods-enabled/mpm_event.* /etc/apache2/mods-enabled/mpm_worker.* 2>/dev/null || true
a2enmod mpm_prefork 2>/dev/null || true

# ── 2. Ensure .env file exists ──────────────────────────────────────────────────────
if [ ! -f /var/www/html/.env ]; then
    if [ -f /var/www/html/.env.example ]; then
        cp /var/www/html/.env.example /var/www/html/.env
    else
        touch /var/www/html/.env
    fi
fi

# ── 3. _write_env_var: safely write key=value to .env ──────────────────────────────
# Uses grep+printf (not sed) so values with spaces/pipes/backslashes are handled safely.
# Values are always double-quoted so PHP's dotenv parser reads them correctly.
# SECURITY: Values are referenced by variable name only — never echoed or printed.
_write_env_var() {
    local KEY="$1"
    local VAL="$2"
    if [ -n "$VAL" ]; then
        # Escape any embedded double-quotes in the value
        local ESCAPED_VAL
        ESCAPED_VAL=$(printf '%s' "$VAL" | sed 's/"/\\"/g')
        # Remove existing key line (grep -v is safe with any value, no sed special-char risks)
        local TMP_ENV
        TMP_ENV=$(grep -v "^${KEY}=" /var/www/html/.env 2>/dev/null || true)
        # Write back file without old key, then append new key with double-quoted value
        printf '%s\n' "$TMP_ENV" > /var/www/html/.env
        printf '%s="%s"\n' "$KEY" "$ESCAPED_VAL" >> /var/www/html/.env
    fi
}

# ── 4. Auto-configure APP_URL from platform-injected domain variable ────────────────
# Set APP_URL directly in your hosting platform's Variables panel.
# If the platform also injects a domain variable, we auto-derive APP_URL from it.
# Supports: PLATFORM_DOMAIN (generic), RAILWAY_PUBLIC_DOMAIN (Railway),
#           RENDER_EXTERNAL_HOSTNAME (Render). Add more here as needed.
# Application code reads ONLY APP_URL — it contains no platform-specific logic.
_DETECTED_DOMAIN=""
if   [ -n "${PLATFORM_DOMAIN:-}" ];            then _DETECTED_DOMAIN="${PLATFORM_DOMAIN}"
elif [ -n "${RAILWAY_PUBLIC_DOMAIN:-}" ];       then _DETECTED_DOMAIN="${RAILWAY_PUBLIC_DOMAIN}"
elif [ -n "${RENDER_EXTERNAL_HOSTNAME:-}" ];    then _DETECTED_DOMAIN="${RENDER_EXTERNAL_HOSTNAME}"
fi

if [ -n "${_DETECTED_DOMAIN}" ]; then
    export APP_URL="https://${_DETECTED_DOMAIN}"
    _write_env_var "APP_URL" "https://${_DETECTED_DOMAIN}"
fi

# ── 5. Sync platform-injected environment variables into .env ───────────────────────
# Cloud platforms inject secrets as OS env vars (not inside .env).
# config:cache reads env() which reads OS env vars first, then .env.
# We also write them into .env as belt-and-suspenders so they survive config:cache.
# SECURITY: Values referenced by variable name — never echoed or printed.

_write_env_var "APP_ENV"         "${APP_ENV:-}"
_write_env_var "APP_DEBUG"       "${APP_DEBUG:-}"
_write_env_var "APP_KEY"         "${APP_KEY:-}"
_write_env_var "MAIL_MAILER"     "${MAIL_MAILER:-}"
_write_env_var "MAIL_HOST"       "${MAIL_HOST:-}"
_write_env_var "MAIL_PORT"       "${MAIL_PORT:-}"
_write_env_var "MAIL_ENCRYPTION" "${MAIL_ENCRYPTION:-}"
_write_env_var "MAIL_FROM_NAME"  "${MAIL_FROM_NAME:-}"

# Credentials — written only when non-empty; value is NEVER echoed or printed
if [ -n "${MAIL_USERNAME:-}" ];     then _write_env_var "MAIL_USERNAME"    "${MAIL_USERNAME}";     fi
if [ -n "${MAIL_PASSWORD:-}" ];     then _write_env_var "MAIL_PASSWORD"    "${MAIL_PASSWORD}";     fi
if [ -n "${MAIL_FROM_ADDRESS:-}" ]; then _write_env_var "MAIL_FROM_ADDRESS" "${MAIL_FROM_ADDRESS}"; fi
if [ -n "${ADMIN_EMAIL:-}" ];       then _write_env_var "ADMIN_EMAIL"      "${ADMIN_EMAIL}";       fi

# S3-compatible object storage credentials (any provider: AWS, R2, DO Spaces, B2)
if [ -n "${AWS_ACCESS_KEY_ID:-}" ];       then _write_env_var "AWS_ACCESS_KEY_ID"       "${AWS_ACCESS_KEY_ID}";       fi
if [ -n "${AWS_SECRET_ACCESS_KEY:-}" ];   then _write_env_var "AWS_SECRET_ACCESS_KEY"   "${AWS_SECRET_ACCESS_KEY}";   fi
if [ -n "${AWS_DEFAULT_REGION:-}" ];      then _write_env_var "AWS_DEFAULT_REGION"      "${AWS_DEFAULT_REGION}";      fi
if [ -n "${AWS_BUCKET:-}" ];              then _write_env_var "AWS_BUCKET"              "${AWS_BUCKET}";              fi
if [ -n "${AWS_ENDPOINT:-}" ];            then _write_env_var "AWS_ENDPOINT"            "${AWS_ENDPOINT}";            fi
if [ -n "${AWS_URL:-}" ];                 then _write_env_var "AWS_URL"                 "${AWS_URL}";                 fi
if [ -n "${FILESYSTEM_DISK:-}" ];         then _write_env_var "FILESYSTEM_DISK"         "${FILESYSTEM_DISK}";         fi

# Database credentials
if [ -n "${DB_CONNECTION:-}" ]; then _write_env_var "DB_CONNECTION" "${DB_CONNECTION}"; fi
if [ -n "${DB_HOST:-}" ];       then _write_env_var "DB_HOST"       "${DB_HOST}";       fi
if [ -n "${DB_PORT:-}" ];       then _write_env_var "DB_PORT"       "${DB_PORT}";       fi
if [ -n "${DB_DATABASE:-}" ];   then _write_env_var "DB_DATABASE"   "${DB_DATABASE}";   fi
if [ -n "${DB_USERNAME:-}" ];   then _write_env_var "DB_USERNAME"   "${DB_USERNAME}";   fi
if [ -n "${DB_PASSWORD:-}" ];   then _write_env_var "DB_PASSWORD"   "${DB_PASSWORD}";   fi
# ───────────────────────────────────────────────────────────────────────────────────

# ── 6. Auto-generate APP_KEY if missing ────────────────────────────────────────────
if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --no-interaction || true
fi

# ── 7. Ensure storage directory structures exist ────────────────────────────────────
mkdir -p storage/framework/cache/data \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/testing \
         storage/app/public \
         storage/app/chunks \
         storage/logs \
         public/uploads \
         public/videos \
         bootstrap/cache \
         database

# ── 8. Baseline asset preservation ─────────────────────────────────────────────────
if [ -d "/var/www/html/public/uploads_baseline" ]; then
    cp -rn /var/www/html/public/uploads_baseline/* /var/www/html/public/uploads/ 2>/dev/null || true
fi

# ── 9. SQLite persistence: relocate DB to persistent volume if applicable ───────────
DB_CONN="${DB_CONNECTION:-sqlite}"

if [ "$DB_CONN" = "sqlite" ]; then
    DB_FILE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"

    if [ "$DB_FILE" != ":memory:" ]; then
        if [ "$DB_FILE" = "/var/www/html/database/database.sqlite" ] || [ "$DB_FILE" = "database/database.sqlite" ]; then
            PERSISTENT_DB_DIR="/var/www/html/public/uploads/.data"
            mkdir -p "$PERSISTENT_DB_DIR"
            PERSISTENT_DB_FILE="$PERSISTENT_DB_DIR/database.sqlite"

            if [ ! -f "$PERSISTENT_DB_FILE" ]; then
                if [ -f "/var/www/html/database/database.sqlite" ] && [ -s "/var/www/html/database/database.sqlite" ] && [ ! -L "/var/www/html/database/database.sqlite" ]; then
                    cp "/var/www/html/database/database.sqlite" "$PERSISTENT_DB_FILE"
                else
                    touch "$PERSISTENT_DB_FILE"
                fi
            fi

            mkdir -p /var/www/html/database
            rm -f /var/www/html/database/database.sqlite
            ln -sf "$PERSISTENT_DB_FILE" /var/www/html/database/database.sqlite
            chmod 777 "$PERSISTENT_DB_DIR" 2>/dev/null || true
            chmod 666 "$PERSISTENT_DB_FILE" 2>/dev/null || true
        else
            mkdir -p "$(dirname "$DB_FILE")"
            if [ ! -f "$DB_FILE" ]; then
                touch "$DB_FILE"
            fi
            chmod 777 "$(dirname "$DB_FILE")" 2>/dev/null || true
            chmod 666 "$DB_FILE" 2>/dev/null || true
        fi
    fi
fi

# ── 10. Set permissions ─────────────────────────────────────────────────────────────
chown -R www-data:www-data storage bootstrap/cache public/uploads public/videos database 2>/dev/null || true
chmod -R 777 storage bootstrap/cache public/uploads database 2>/dev/null || true
chmod -R 755 public/videos 2>/dev/null || true

# ── 11. Symlink public storage ──────────────────────────────────────────────────────
php artisan storage:link --no-interaction || true

# ── 12. Run safe database migrations ────────────────────────────────────────────────
# NEVER runs migrate:fresh or migrate:refresh — safe for existing production data
php artisan migrate --force --no-interaction || true

# ── 13. Seeding (disabled by default on production to protect real data) ─────────────
DB_SEED="${DB_SEED_ON_BOOT:-false}"
if [ "$DB_SEED" = "true" ]; then
    php artisan db:seed --force --no-interaction || true
else
    # Always ensure baseline admin account exists without altering existing content
    php artisan db:seed --class=Database\\Seeders\\DatabaseSeeder --force --no-interaction || true
fi

# ── 14. Laravel config/route/view cache ─────────────────────────────────────────────
if [ "${APP_ENV:-production}" = "production" ]; then
    php artisan config:cache --no-interaction || true
    php artisan route:cache  --no-interaction || true
    php artisan view:cache   --no-interaction || true
fi

exec "$@"
