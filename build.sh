#!/usr/bin/env bash
set -e

echo "=== Installing Composer dependencies ==="
composer install --no-dev --optimize-autoloader --no-interaction

echo "=== Caching config & views ==="
php artisan config:cache
php artisan view:cache

echo "=== Caching routes (may skip if closures exist) ==="
php artisan route:cache || echo "Route caching skipped — some routes use closures."

echo "=== Storage link ==="
php artisan storage:link --force || true

echo "=== Creating SQLite database if needed ==="
if [ "$DB_CONNECTION" = "sqlite" ]; then
  touch "$DB_DATABASE" 2>/dev/null || touch database/database.sqlite
fi

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Build complete ==="
