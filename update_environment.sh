#!/bin/bash

chmod -R 777 app/storage

# Update the composer binary
if [ `hostname -s` == "homestead" ]; then
    php ./composer.phar self-update
fi

# Have to run this before any laravel code is run
php ./composer.phar dump-autoload

# Delete compiled classes file
if [ ! -n bootstrap/compiled.php ]; then
    rm bootstrap/compiled.php
fi

# Bring up the maintenance site
if [ `hostname -s` != "homestead" ]; then
    php artisan down
fi

# Install composer packages
php ./composer.phar install --no-scripts

# Migrate and seed both databases
if [ `hostname -s` != "homestead" ]; then
    php artisan migrate --env=production
    php artisan migrate --package=mccool/laravel-slugs --env=production
    php artisan db:seed --env=production
else
    php artisan migrate --env=local
    php artisan migrate --package=mccool/laravel-slugs --env=local
    php artisan db:seed --env=local
fi

# Create laravel optimized autoloader
php artisan dump-autoload

# Bring the site back up
if [ `hostname -s` != "homestead" ]; then
    php artisan up
fi

exit 0