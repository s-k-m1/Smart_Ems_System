#!/usr/bin/env bash
set -e

echo "=== Setting up database if SQLite ==="
if [ "$DB_CONNECTION" = "sqlite" ]; then
  touch "$DB_DATABASE" 2>/dev/null || touch database/database.sqlite
fi

echo "=== Running migrations ==="
php artisan migrate --force || echo "Migrations failed — continuing"

echo "=== Starting PHP-FPM & Nginx ==="
php-fpm -D
nginx -g "daemon off;"
