#!/bin/bash

rm app/database/testing.sqlite 2> /dev/null
touch app/database/testing.sqlite
php artisan migrate --env=testing
/home/vagrant/web/laravel.io/vendor/bin/codecept run integration
