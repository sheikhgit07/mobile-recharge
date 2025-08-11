#!/usr/bin/env bash
set -euo pipefail

APP_PATH=${1:-}
MODE=${2:-local}  # local | docker

if [ -z "$APP_PATH" ]; then
  echo "Usage: $0 /absolute/path/to/laravel-app [local|docker]" >&2
  exit 1
fi

if [ ! -f "$APP_PATH/artisan" ]; then
  echo "No Laravel app detected at $APP_PATH (artisan missing)." >&2
  exit 1
fi

REPO_ROOT="$(cd "$(dirname "$0")"/.. && pwd)"
SCAFFOLD_DIR="$REPO_ROOT/scaffold"

copy_scaffold() {
  if command -v rsync >/dev/null 2>&1; then
    rsync -a --exclude=".DS_Store" "$SCAFFOLD_DIR/" "$APP_PATH/"
  else
    (cd "$SCAFFOLD_DIR" && tar cf - .) | (cd "$APP_PATH" && tar xpf -)
  fi
}

composer_cmd() {
  if [ "$MODE" = "docker" ]; then
    (cd "$APP_PATH" && ./vendor/bin/sail composer "$@")
  else
    (cd "$APP_PATH" && composer "$@")
  fi
}

artisan_cmd() {
  if [ "$MODE" = "docker" ]; then
    (cd "$APP_PATH" && ./vendor/bin/sail artisan "$@")
  else
    (cd "$APP_PATH" && php artisan "$@")
  fi
}

# Copy scaffold files
copy_scaffold

# Ensure .env has APP_URL and DB configured minimally
if ! grep -q '^APP_URL=' "$APP_PATH/.env"; then
  echo 'APP_URL=http://localhost' >> "$APP_PATH/.env"
fi

# Install Filament v3
composer_cmd require filament/filament:^3.2 --no-interaction --no-progress

# Optimize
artisan_cmd config:clear || true
artisan_cmd config:cache || true