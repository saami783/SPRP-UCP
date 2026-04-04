#!/bin/sh
set -eu

cd /var/www/html

if [ -f .env ]; then
    set -a
    # shellcheck disable=SC1091
    . ./.env
    set +a
fi

mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

if [ -z "${APP_KEY:-}" ]; then
    php artisan key:generate --force --ansi
fi

php artisan package:discover --ansi

echo "Waiting for MySQL on ${DB_HOST:-mysql}:${DB_PORT:-3306}..."
until MYSQL_PWD="${DB_PASSWORD:-}" mysqladmin ping \
    -h"${DB_HOST:-mysql}" \
    -P"${DB_PORT:-3306}" \
    -u"${DB_USERNAME:-laravel}" \
    --silent; do
    sleep 2
done

php artisan migrate --force --ansi

if [ "${RUN_DB_SEED:-false}" = "true" ]; then
    php artisan db:seed --force --ansi
fi

exec "$@"
