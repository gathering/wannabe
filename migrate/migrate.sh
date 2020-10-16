#!/bin/bash

set -a
[ -f ../.env ] && source ../.env
set +a

# Find unix epoch
EPOCH=`date +%s`

# Backup existing DB
echo "Creating MySQL dump of wannabe $EPOCH"
 mysqldump $MYSQL_DATABASE -u $MYSQL_USER -p$MYSQL_PASSWORD -h $MYSQL_MIGRATION_URL > "wannabe_$EPOCH.sql"

# Run migrations
echo "Running migrations .."
db-migrate migrate
