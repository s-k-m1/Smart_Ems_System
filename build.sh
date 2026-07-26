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

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Build complete ==="
