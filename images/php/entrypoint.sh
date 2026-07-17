#!/bin/bash

echo "Running artisan commands..."
php artisan optimize

# --- Добавленный блок для MySQL ---
echo "Waiting for database to be ready..."
until php artisan db:monitor 2>/dev/null; do
  echo "Database is not ready yet, waiting..."
  sleep 2
done
echo "Database is ready."

# --- Добавленный блок для Redis ---
echo "Waiting for Redis to be ready..."
until php -r "try { new Redis(); echo 'Redis ready'; } catch (Exception \$e) { exit(1); }" 2>/dev/null; do
  echo "Redis is not ready yet, waiting..."
  sleep 2
done
echo "Redis is ready."
# ------------------------

if [ "$SKIP_MIGRATIONS" != "true" ]; then
  php artisan migrate
  php artisan db:seed
fi
php artisan key:generate

exec php-fpm