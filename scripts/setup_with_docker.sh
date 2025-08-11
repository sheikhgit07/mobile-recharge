#!/usr/bin/env bash
set -euo pipefail

# Creates a new Laravel Sail app in ./app and applies the scaffold in this repo
# Requirements: curl, docker, docker compose

REPO_ROOT="$(cd "$(dirname "$0")"/.. && pwd)"
APP_DIR="$REPO_ROOT/app"
APP_NAME="nexitel"

if ! command -v docker >/dev/null 2>&1; then
  echo "Docker is required. Please install Docker first." >&2
  exit 1
fi

if [ -d "$APP_DIR" ] && [ -f "$APP_DIR/artisan" ]; then
  echo "Laravel app already exists at $APP_DIR. Skipping creation."
else
  echo "Creating Laravel Sail app in $APP_DIR ..."
  # Use Laravel build script to bootstrap Sail project
  curl -s "https://laravel.build/${APP_NAME}?with=mysql,redis,meilisearch,mailpit,selenium" | bash
  # The script creates a folder named after APP_NAME in current directory; move/rename to app
  if [ -d "./${APP_NAME}" ]; then
    rm -rf "$APP_DIR"
    mv "./${APP_NAME}" "$APP_DIR"
  fi
fi

cd "$APP_DIR"

# Start Sail containers
./vendor/bin/sail up -d

# Wait for MySQL to be up (simple retry)
>&2 echo "Waiting for database to be ready..."
for i in {1..30}; do
  if ./vendor/bin/sail artisan migrate:status >/dev/null 2>&1; then
    break
  fi
  sleep 2
done

# Apply scaffold
bash "$REPO_ROOT/scripts/apply_scaffold.sh" "$APP_DIR" docker

# Finalize
./vendor/bin/sail artisan storage:link || true
./vendor/bin/sail artisan migrate --force
./vendor/bin/sail artisan db:seed --class=Database\\Seeders\\CmsSeeder --force

APP_URL=${APP_URL:-http://localhost}

cat <<EOT

Setup complete.
- App: $APP_URL
- Admin: $APP_URL/admin
- Admin user: admin@example.com / password (change ASAP)

If containers are not running, start them:
  cd "$APP_DIR" && ./vendor/bin/sail up -d
EOT