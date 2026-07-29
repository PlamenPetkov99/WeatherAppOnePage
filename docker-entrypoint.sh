#!/bin/sh

set -e

echo "Running database migrations..."

php bin/console doctrine:migrations:migrate \
    --no-interaction \
    --env=prod

echo "Clearing cache..."

php bin/console cache:clear --env=prod

echo "Starting Apache..."


sed -i "s/80/${PORT}/g" /etc/apache2/sites-available/000-default.conf
sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf

exec apache2-foreground
