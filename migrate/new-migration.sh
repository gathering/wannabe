#!/bin/bash

if [ $# -ne 0 ]; then
    db-migrate --config=.simple-db-migrate.conf --create $1
else
    echo "[Error] SYNTAX: ./new-migration.sh <migration name>"
fi
