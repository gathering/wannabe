#!/bin/bash

cd /var/www/html/wannabe

echo "Running prepare.sh"
chmod a+x build/prepare.sh
build/prepare.sh

echo "Creating any missing config files from example files"
cp -n migrate/db-config.examples.sh migrate/db-config.sh
cp -n migrate/.simple-db-migrate.example.conf migrate/.simple-db-migrate.conf
cp -n app/Config/database.sample.php app/Config/database.php
cp -n app/Config/core.example.php app/Config/core.php

echo "Creating cake console symlink"
ln -sf /var/www/html/wannabe/lib/Cake/Console/cake /bin/cake

echo "Running composer install"
composer install --no-interaction

echo "Running pip install (on migration requirements)"
pip install -r ./migrate/requirements.txt

echo "Changing file ownership to www-data user and group"
chown -R www-data:www-data ./

exec "$@"
