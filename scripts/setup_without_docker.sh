#!/usr/bin/env bash
set -euo pipefail

# Applies scaffold to an existing Laravel app in ./app
# Requirements: PHP 8.2+, Composer

REPO_ROOT="$(cd "$(dirname "$0")"/.. && pwd)"
APP_DIR="$REPO_ROOT/app"

if [ ! -f "$APP_DIR/artisan" ]; then
  echo "Laravel app not found in $APP_DIR. Please run:\n  composer create-project laravel/laravel app\nthen re-run this script." >&2
  exit 1
fi

bash "$REPO_ROOT/scripts/apply_scaffold.sh" "$APP_DIR" local

cd "$APP_DIR"
php artisan storage:link || true
php artisan migrate --force
php artisan db:seed --class=Database\\Seeders\\CmsSeeder --force

APP_URL=${APP_URL:-http://127.0.0.1:8000}

cat <<EOT

Setup complete.
- App: $APP_URL
- Admin: $APP_URL/admin
- Admin user: admin@example.com / password (change ASAP)

Run the app:
  cd "$APP_DIR" && php artisan serve
EOT