#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache database
touch database/database.sqlite
chmod -R ug+rwx storage bootstrap/cache database

if [ -z "${APP_KEY:-}" ] || [[ "${APP_KEY}" != base64:* ]]; then
  echo "Generating APP_KEY..."
  export APP_KEY="$(php artisan key:generate --show --no-ansi)"
fi

if [ -z "${APP_URL:-}" ]; then
  if [ -n "${RENDER_EXTERNAL_URL:-}" ]; then
    export APP_URL="${RENDER_EXTERNAL_URL}"
  else
    export APP_URL="http://localhost:${PORT:-8000}"
  fi
fi

php artisan config:clear
php artisan migrate --force
php artisan db:seed --force --class=ClinicSeeder

PORT="${PORT:-8000}"
exec php artisan serve --host=0.0.0.0 --port="${PORT}"
