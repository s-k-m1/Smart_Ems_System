#!/usr/bin/env bash
set -e

echo "=== Starting Smart EMS ==="
# Render's PHP runtime provides Nginx + PHP-FPM automatically.
# This script runs a queue worker for background jobs.
php artisan queue:work --tries=3 --timeout=90
