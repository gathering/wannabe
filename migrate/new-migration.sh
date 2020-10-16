#!/bin/bash

set -a
[ -f ../.env ] && source ../.env
set +a

if [ $# -ne 0 ]; then
    db-migrate --create $1
else
    echo "[Error] SYNTAX: ./new-migration.sh <migration name>"
fi
