# Wannabe

Wannabe is the system used to coordinate volunteers for The Gathering
(gathering.org). It encompass a wide variety of tasks, among them:

- Crew applications
- Member lists / org chart
- Sync with mailing list systems (mailman)
- SMS messages to volunteers
- Registration of allergies and special medical concerns
- Car plates
- And tons and tons more

Please note that Wannabe was NOT designed as an open source tool. We are
offering it under the GPL 3 today with very few modifications because we
honestly believe that helping other parties will ultimately help us.

Patches are VERY much welcome, but we still need to figure out how to work
on Wannabe, so be kind! It is an old code base, somewhat neglected, but we
still like it!

To get in contact with us if you are part of The Gathering crew, use our
slack and #systemstøtte. We will probably be setting up some external chat
if there's interest (or regardless), but first thing is first: Here's the
code.

Contact: Use bug reports here, or use wannabe@gathering.org (Response times
are very varying - I'm sorry, we're working on it!)


# Docker

Some work has begun on making it possible to develop using docker. It is
not complete, largely because we're also moving to a newer php version and
ideally fixing some stupid bugs, possibly moving to at least a more recent
CakePHP, ideally CakePHP 3.

Naturally this should currently only be used for development purposes.

Several further tweaks are needed, but this is a start.

## Initial configuration:

First select between PHP 5 and PHP 7 versions of the image by uncommenting the
corresponding lines in `./env` file. Currently PHP 5 is the default.

If running in dev mode configuration files should be created automatically from
example files when starting the container the first time if they are missing.

They can also be manually created in advance:

```
$ cp migrate/db-config.examples.sh migrate/db-config.sh
$ cp migrate/.simple-db-migrate.example.conf migrate/.simple-db-migrate.conf
$ cp app/Config/database.sample.php app/Config/database.php
$ cp app/Config/core.example.php app/Config/core.php
```

You can ignore most other steps from `INSTALL.md`, for anything other than
reference.

## Running:

```
$ docker-compose up
```

This uses docker-compose and runs two containers:
- One `app` container with PHP and Apache running main wannabe code
- One `mysql` container running MySQL with a some basic seed data

Visit `http://localhost:4000` to visit site and get started

## Migrations:

The `app` container automatically contains a mount of your local development
folder, including `./migrate` and has required python packages installed. So
the simplest way to run migrations is from inside the container.

```
# While the `app` container us running, do this in another terminal:
$ docker-compose exec app /bin/bash
$ cd migrate
$ ./migrate.sh
```

## Modifying database seed

After creating new migrations it's nice to update the initial database seeds
used for local development. Simply replace the existing `./sql/dev.sql` file
with the latest dump file created in `./migrate/wannabe_xxxx.sql`, and it will
automatically get imported when a new mysql container is created. (Actually all
`.sql` and `.sh` files in `./sql` folder gets run in alphabetical order)

PS. Keep in mind that the migration dump file includes *all* database
modifications, including new users, changed passwords, etc. So try to only do
it from a "fresh" instance without too many modifications.

## Installation

[Installation instruction](https://github.com/gathering/wannabe/blob/master/INSTALL.md)  
[Work flow instructions](https://github.com/gathering/wannabe/blob/master/WORKFLOW.md)

All PHP libraries are included, including CakePHP.
