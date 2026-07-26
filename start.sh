#!/usr/bin/env bash
set -e

echo "=== Caching config ==="
php artisan config:cache || echo "Config cache skipped"

echo "=== Setting up database if SQLite ==="
if [ "$DB_CONNECTION" = "sqlite" ]; then
  touch "$DB_DATABASE" 2>/dev/null || touch database/database.sqlite
fi

echo "=== Running migrations ==="
php artisan migrate --force || echo "Migrations failed — continuing"

echo "=== Seeding admin user ==="
php artisan db:seed --class=AdminSeeder --force || echo "Admin seeder skipped"

echo "=== Starting PHP-FPM & Nginx ==="
php-fpm -D
nginx -g "daemon off;"
