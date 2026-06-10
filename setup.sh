#!/usr/bin/env bash

set -euo pipefail

echo "==> Installing PHP dependencies"
composer install

echo "==> Installing Node dependencies"
npm install

if [ ! -f .env ]; then
    echo "==> Creating .env"
    cp .env.example .env
fi

echo "==> Generating app key"
php artisan key:generate

echo "==> Building frontend assets"
npm run build

echo "==> Running fresh migrations and seeders"
php artisan migrate:fresh --seed

cat <<'EOF'

Setup complete.

Next:
  php artisan serve

Demo login:
  demo@laravelmatch.test / password
EOF
