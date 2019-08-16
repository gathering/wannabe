#!/bin/bash
db-migrate --config=.simple-db-migrate.conf --migration="$1"
