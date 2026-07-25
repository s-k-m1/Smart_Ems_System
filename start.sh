#!/usr/bin/env bash
set -e

echo "=== Starting Smart EMS ==="
php artisan serve --host=0.0.0.0 --port=${PORT:-8000}
