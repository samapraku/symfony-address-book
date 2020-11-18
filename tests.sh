#!/usr/bin/env sh

if [ "$2" == "-db" ]
then
echo "rebuilding database .."
php bin/console doctrine:schema:drop -n -q --force --full-database
rm migrations/*.php
php bin/console make:migration
php bin/console doctrine:migration:migrate -n -q
php bin/console doctrine:fixtures:load -n -q
fi

if [ -n "$1" ]
then
./bin/phpunit $1
else
./bin/phpunit
fi

