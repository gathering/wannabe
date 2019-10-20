#!/bin/bash

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
