## How to set up Wannabe on your server

This page explains how to set up Wannabe on you personal or local server for development proposes. (Tested on Ubuntu 14.04)
Currently only tested on in production on php5, but should work fairly well with php7.

### Install required packages

```
$ sudo apt-get install apache2 php5 mysql-server git gettext php5-mysql php5-mcrypt php5-gd
$ sudo a2enmod rewrite
```

### Clone git repo into your home folder

```
$ cd /var/www/html && git clone git@github.com:gathering/wannabe.git
$ cd wannabe
```

### Configure .env file

Copy example .env file, populate and replace all CakePHP and DB related
variables.

```
$ cp .env.example .env
$ vim .env
```

If running things manually (and dont really use `.env` file directly) you can
modify it and use it to populate your local runtime environment instead. As an
alternative to manually adjust all relevant config files you can;

1. Insert `export` on each line before the env variable. (Ex `export A=B`)
2. Run `source .env` to populate local env

If not wanting or able to use env variables at all see list of configuration
options to change in the individual steps below.

### Setup database

First create the database and a user

```
$ mysql -u root -p
mysql> CREATE DATABASE wannabe;
mysql> CREATE USER 'wannabe'@'localhost' IDENTIFIED BY 'wannabe';
mysql> GRANT ALL ON wannabe.* TO 'wannabe'@'localhost';
mysql> FLUSH PRIVILEGES;
mysql> QUIT
```

Install python-pip and mysql framework and run the migration

```
$ sudo apt-get install python-dev libmysqlclient-dev python-pip
$ pip install -r migrate/requirements.txt
$ vim migrate/simple-db-migrate.conf
$ vim migrate/migrate.sh
$ cd migrate && sh migrate.sh && cd ..

# Lastly configure wannabe to connect to that database
$ cp app/Config/database.sample.php app/Config/database.php
$ vim app/Config/database.php
```

Relevant env variables (replace with static values if not using env)

- MYSQL_URL
- MYSQL_MIGRATION_URL (custom DB url for migration code)
- MYSQL_USER
- MYSQL_ROOT_PASSWORD
- MYSQL_PASSWORD
- MYSQL_DATABASE

### Development configuration

Add basic wannabe config

```
$ cp app/Config/core.example.php app/Config/core.php
$ vim app/Config/core.php
$ vim app/Config/bootstrap.php
```

Relevant env variables (replace with static values if not using env)

- SESSION_COOKIE_DOMAIN (leave blank if localhost)
- DEBUG (1 during local development / 0 in production)

### Custom configuration options

#### AUTH_COOKIE_KEY

Populate this environment variable with random string to activate "Remember me"
functionality. This key is used as encryption key for the "Remember me" cookie
containing users credentials, so be sure it's long and random.

Sessions will still be held for about 1 week according to CakePHP session/cookie
config, but will not automatically re-login user when it expires.

#### SLACK_TOKEN

Populate this with a slack token to automatically send slack invite to user
upon enrollment.

#### LOG_ENGINE

Set to "console" when running in a container environment to log to stdout and
stderr. If not set it defaults to regular file logging.

### Create cache and files upload folders

These folder are required for caching and image uploads (even if cache it not in use)

```
$ mkdir app/tmp
$ mkdir app/tmp/sessions
$ mkdir app/tmp/logs
$ mkdir app/tmp/tests
$ mkdir app/tmp/cache app/tmp/cache/{persistent,models,assets}
$ chmod -R 777 app/tmp
$ mkdir app/webroot/files
$ chmod 777 app/webroot/files
```

### Edit apache configuration for the development site

Start with editing the apache default configuration file

**/etc/apache2/sites-enabled/000-default.conf**

```
<VirtualHost *:80>
ServerAdmin email@domain.org
DocumentRoot /var/www/html/wannabe/app/webroot
<Directory />
Options FollowSymLinks
AllowOverride All
</Directory>
<Directory /var/www/html/wannabe>
Options Indexes FollowSymLinks MultiViews
AllowOverride All
Order allow,deny
allow from all
</Directory>
</VirtualHost>
```

Edit php.ini to allow `short_open_tag`

**/etc/php5/apache2/php.ini**

`short_open_tag = On`

Finally restart apache2

`$ sudo service apache2 restart`

### Create a new event

1. Make sure you have cake in path

`echo 'export PATH="/var/www/html/wannabe/lib/Cake/Console:$PATH"' >> ~/.bashrc && source ~/.bashrc`

2. Go to the app-folder
3. Run `cake event` and follow the instructions (the default user is UID 1)

If `cake event` returns ": No such file or directory" try "dos2unix /var/www/html/wannabe/lib/Cake/Console/cake"

#### Default login:

```
User: dev
Pass: gramofon
```
