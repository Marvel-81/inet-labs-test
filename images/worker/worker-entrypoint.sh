#!/bin/bash

echo "Starting Laravel Worker..."

# Ожидание готовности Redis
echo "Waiting for Redis to be ready..."
until php -r "try { new Redis(); echo 'Redis ready'; } catch (Exception \$e) { exit(1); }" 2>/dev/null; do
  echo "Redis is not ready yet, waiting..."
  sleep 2
done
echo "Redis is ready."

exec php artisan queue:work --sleep=3 --tries=3 --max-time=3600

fi