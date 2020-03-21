#!/bin/bash

php bin/console doctrine:database:create
php bin/console --no-interaction doctrine:migrations:migrate
php bin/console --no-interaction doctrine:fixtures:load
