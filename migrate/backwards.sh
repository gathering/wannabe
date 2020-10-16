#!/bin/bash

set -a
[ -f ../.env ] && source ../.env
set +a

db-migrate --migration="$1"
