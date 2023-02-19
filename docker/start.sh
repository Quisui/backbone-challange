#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

if [ "$role" = "app" ]; then
    echo "Running the app..."
    exec apache2-foreground
    exec php /var/www/artisan migrate --seed
else
    echo "Could not match the container role \"$role\""
    exit 1
fi
