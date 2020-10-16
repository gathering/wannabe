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

## Docker

While docker is the intended develop and production environment, it is not
complete (and probably never will be). Largely because we're also moving to a
newer php version and ideally fixing some stupid bugs, possibly moving to at
least a more recent CakePHP, ideally CakePHP 3.

### Initial configuration:

Copy `.env.example` to `.env`

First select between development and production setup by uncommenting the
corresponding lines in `.env` file. Development is the current default.

If running in dev mode configuration files should be created automatically from
example files when starting the container the first time if they are missing.

Most of these config files utilize environment variables from the `.env` file
for common config options, and can likely often remain unchanged from sample
files.

See `build/prepate.sh` (used for both prod and dev) and
`build/development-entrypoint.sh` (used in dev only) for manual setup steps
reference. Some of these are also referenced in `INSTALL.md`.

### Running:

First we have to create the docker networks used by the containers. This is not
done automatically, to allow host to determine networking details. The commands
below assumes we want the `wannabe_internal` network to only be accessible
between the containers and not externally. A safe default to limit access to
`mysql`, `app` (php-fpm) and other non-public-facing containers.

```
$ docker network create wannabe_public
$ docker network create wannabe_internal --internal
```

Then we start the containers.

```
$ docker-compose up
```

This uses docker-compose and runs several containers by default, depending on
environment:

- One `nginx` container which contains a basic config for using as local (non-ssh) entrypoint to app \*
- One `app` container with PHP-fpm and application code \*
- One `mysql` container running MySQL with a some basic seed data

\* Containers used in default production setup

Visit `http://localhost:8080` to visit site and get started

#### Development

To use development setup make sure this line is uncommented in `.env` file:

```
COMPOSE_FILE=docker-compose.yml:docker-compose.dev.yml

# This is the same as appending all docker-compose commands with
# -f docker-compose.yml -f docker-compose.dev.yml
```

The `app` container automatically contains a mount of your local development
folder. And triggers composer setup, pip installs, creation of dummy folders,
example configs, etc, each time it's started via `development-entrypoint.sh`.

The container should (if visited via `docker-compose exec app /bin/bash`) have
access to `composer` and `cake` commands out of the box.

Development setup includes the `mysql` container which is populated by `./sql/`
seed files on first startup.

#### Production

To use an example production setup uncommented this line in `.env` file:

```
COMPOSE_FILE=docker-compose.yml:docker-compose.prod.yml

# This is the same as appending all docker-compose commands with
# -f docker-compose.yml -f docker-compose.prod.yml
```

When in development mode `app` container is using a minimal `php-fpm` docker
image which only contains a few source code and lib folders. This is built by
cloning the `prod` branch from git, installing composer dependencies and doing
some basic preparation steps in `build/prepare.sh`.

To build production image from another branch:

```
docker-compose build --build-arg GIT_BRANCH=branch-name app
```

When using in a custom production environment we recommend that you use a
custom `docker-compose.prod.yml` file and reference that from `.env`, or build
and run `app` container with your completely custom docker-compose (or swarm,
or kubernetes) setup.

**PS!** The example production container expects that configuration files and
secrets are provided and available. If run in docker swarm or kubernetes this
could be done via separate config or secret mounts specified for the
service/pod. If run as standalone container via docker-compose, add extra
volume mounts pointing to required configuration files (see
`development-entrypoint.sh` for required config files)

### Tooling container

There is a tooling container configuration included in
`docker-compose.tooling.yml` which is intended to be run alongside either
production or development containers when manually running migrations, queries,
or cake cli commands, or general debugging).

Since the container needs access to same resources as the ordinary containers
the simplest way run it is via docker compose:

```
docker-compose run -f <your ordinary composer file>.yml -f docker-compose.tooling.yml --rm tooling

# Or with a modified .env COMPOSE_FILE entry
docker-compose run --rm tooling
```

**PS!** In order to do anything useful with the tooling container make sure you
mount either local folder (for development) or configuration and shared volumes
(for production) to give it access to the "live" files. See some examples in the
`docker-compose.tooling.yml` file.

### Experimenting with php7

To experiment with php7 (or another) version. Build `app` container with the
`PHP_VERSION` build argument.

```
docker-compose build --build-arg PHP_VERSION=7 app
```

### Migrations:

The `app` container automatically contains a mount of your local development
folder, including `./migrate` and has required python packages installed. So
the simplest way to run migrations is from inside the container.

```
# While the `app` container is running, do this in another terminal:
$ docker-compose exec app /bin/bash
$ cd migrate
$ ./migrate.sh
```

All PHP libraries are included, including CakePHP.

### Enable/disable a user account

With `cake` command available in path (see installation instructions).

```
cake user enable <userid>
cake user disable <userid>
cake user show <userid>
```

A disabled used is disallowed login and has personal information hidden from
user profile page. User information will still appear in other locations. If
removing user for data retention or privacy purposes delete user instead.

### Modifying database seed

After creating new migrations it's nice to update the initial database seeds
used for local development. Simply replace the existing `./sql/dev.sql` file
with the latest dump file created in `./migrate/wannabe_xxxx.sql`, and it will
automatically get imported when a new mysql container is created. (Actually all
`.sql` and `.sh` files in `./sql` folder gets run in alphabetical order)

PS. Keep in mind that the migration dump file includes _all_ database
modifications, including new users, changed passwords, etc. So try to only do
it from a "fresh" instance without too many modifications.

## Non-docker based installation

[Installation instruction](https://github.com/gathering/wannabe/blob/master/INSTALL.md)

## Workflow instructions

[Work flow instructions](https://github.com/gathering/wannabe/blob/master/WORKFLOW.md)
