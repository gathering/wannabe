#!/bin/bash

# Import database variables from migrate config file
. ./db-config.sh
# Find unix epoch
EPOCH=`date +%s`

# Backup existing DB
echo "Creating MySQL dump of wannabe $EPOCH"
mysqldump $DATABASE_NAME -u $DATABASE_USER -p$DATABASE_PASSWORD -h $DATABASE_HOST > "wannabe_$EPOCH.sql"

# Run migrations
echo "Running migrations .."
db-migrate --config=.simple-db-migrate.conf migrate
