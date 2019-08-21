#!/bin/bash

cd /var/www/html/wannabe
mkdir -p app/tmp
mkdir -p app/tmp/sessions
mkdir -p app/tmp/logs
mkdir -p app/tmp/tests
mkdir -p app/tmp/cache app/tmp/cache/{persistent,models,assets}
chmod -R 777 app/tmp
mkdir -p app/webroot/files
chmod 777 app/webroot/files

new() {
	mysql -u root <<-EOF
	CREATE DATABASE wannabe;
	CREATE USER 'wannabe'@'localhost' IDENTIFIED BY 'wannabe';
	GRANT ALL ON wannabe.* TO 'wannabe'@'localhost';
	FLUSH PRIVILEGES;
	QUIT
	EOF
}

req() {
		cp /var/www/html/wannabe/migrate/db-config.examples.sh /var/www/html/wannabe/migrate/db-config.sh 
		cp /var/www/html/wannabe/migrate/.simple-db-migrate.example.conf /var/www/html/wannabe/migrate/.simple-db-migrate.conf
		cp /var/www/html/wannabe/app/Config/database.sample.php /var/www/html/wannabe/app/Config/database.php
		cp /var/www/html/wannabe/app/Config/core.example.php /var/www/html/wannabe/app/Config/core.php
}
req
service mysql start
sleep 1
new
service apache2 start
