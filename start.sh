#!/usr/bin/env bash
set -e

echo "=== Fixing permissions ==="
chmod -R 777 storage database bootstrap/cache 2>/dev/null || true

echo "=== Clearing all stale caches ==="
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan cache:clear || true

echo "=== Setting up database if SQLite ==="
if [ "$DB_CONNECTION" = "sqlite" ]; then
  touch "$DB_DATABASE" 2>/dev/null || touch database/database.sqlite
  chmod 777 "$DB_DATABASE" 2>/dev/null || chmod 777 database/database.sqlite 2>/dev/null || true
fi

echo "=== Running migrations ==="
php artisan migrate --force || echo "Migrations failed — continuing"

echo "=== Seeding admin user ==="
php artisan db:seed --class=AdminSeeder --force || echo "Admin seeder skipped"

# Queue worker disabled — can cause SQLite lock contention
# php artisan queue:work --tries=3 --timeout=90 --sleep=3 -q &
# echo "Queue worker started"

echo "=== Starting PHP-FPM & Nginx ==="
php-fpm -D
nginx -g "daemon off;"
