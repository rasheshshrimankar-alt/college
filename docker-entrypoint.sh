#!/bin/sh
set -eu

cd /var/www/html

echo "Waiting for database and applying Laravel migrations..."
attempt=1
max_attempts=12
until php artisan migrate --force; do
    if [ "$attempt" -ge "$max_attempts" ]; then
        echo "Database migrations failed after $max_attempts attempts."
        exit 1
    fi
    echo "Database is not ready yet (attempt $attempt/$max_attempts); retrying in 5 seconds..."
    attempt=$((attempt + 1))
    sleep 5
done

# Ensure the public admission form always has an initial course catalogue.
echo "Ensuring default departments and courses exist..."
php artisan db:seed --class=CourseCatalogSeeder --force

if [ -n "${INITIAL_ADMIN_EMAIL:-}" ] || [ -n "${INITIAL_ADMIN_PASSWORD:-}" ]; then
    echo "Creating or confirming the initial administrator account..."
    php artisan db:seed --class=RenderAdminSeeder --force
fi

php artisan storage:link --force || true
php artisan config:cache
php artisan view:cache

exec "$@"
