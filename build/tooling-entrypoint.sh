#!/bin/bash

cd /var/www/html/wannabe

echo "Preparing tools, avoiding commands that affect app files"

echo "Running pip install (on migration requirements)"
pip install -r ./migrate/requirements.txt

echo "Creating cake console symlink"
ln -sf /var/www/html/wannabe/lib/Cake/Console/cake /bin/cake

echo "Ready for work"

exec "$@"
