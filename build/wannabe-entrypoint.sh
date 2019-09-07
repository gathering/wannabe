#!/bin/bash

cd /var/www/html/wannabe

echo "Creating any missing tmp and webroot folders"
mkdir -p app/tmp
mkdir -p app/tmp/sessions
mkdir -p app/tmp/logs
mkdir -p app/tmp/tests
mkdir -p app/tmp/cache app/tmp/cache/{persistent,models,assets}
chmod -R 777 app/tmp
mkdir -p app/webroot/files
chmod 777 app/webroot/files

echo "Changing file ownership to www-data user and group"
chown -R www-data:www-data ./

if [ "$APP_ENV" == "development" ]
then
	echo "Dev mode: Create any missing config files"
	cp -n migrate/db-config.examples.sh migrate/db-config.sh
	cp -n migrate/.simple-db-migrate.example.conf migrate/.simple-db-migrate.conf
	cp -n app/Config/database.sample.php app/Config/database.php
	cp -n app/Config/core.example.php app/Config/core.php
fi

exec "$@"
