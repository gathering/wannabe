# Work flow in git, schema migrations and how to apply changes to production
This page explains how your general work flow should be in git and how to apply your changes to production.

## New feature
Make sure you are on the master branch before branching out.

```bash
$ git checkout master
$ git checkout -b <BRANCH NAME>
```

Now make your changes and commit them (micro commits are cool!) before pushing to origin.

```bash
$ git push origin <BRANCH NAME>
```

You can now create a pullrequest from <BRANCH NAME> into master on github.

## Making schema migrations
Migrations are handled by a python module named `simple-db-migrate`. It also requires the `python-mysqldb` package.

They can be installed with pip and requirements.txt, or with easy_install.

```bash
$ pip install -r requirements.txt
```

Navigate to wannabe/migrations directory to start using migrations.

You need to change settings to  fit your database setup. You can find this in the file `.simple-db-migrate.conf`.

To create a new migration, use the shellscript new-migration.sh and include a description for its name.
```bash
$ ./new-migration.sh added_some_model
```

The migration will consist of two text variables; SQL_UP and SQL_DOWN. SQL_UP contains SQL needed to apply the migration, and SQL_DOWN to go backwards.

The contents of these variables should be SQL needed to do the appripriate action. If you wish to add a model, include CREATE and INSERT statements, and vice versa.

The numbers in the migration name is YYYYMMDDHHMMSS of creation, which is used to determine order the migrations are applied.

Migrations are tagged with unixepoch. When migrate.sh is ran, it runs all migrations > current unixepoch.

This becomes a problem when a developer has been working on a pull request for a while, and then merges the changes into develop. 
If the migrations, which are usually one of the first things to be made for a new model, are created at a date earlier than the currently highest migration stored in prod, it will not automatically be ran in the routines for prod setting.

A temporary fix for this is to make sure that all migration files are renamed to the current unixepoch after they have been merged to develop, but we should probably investigate ways to automate this process.

To migrate to the latest migration, use migrate.sh with no more options. If you wish to apply more options, the shell script allows for that.
One common cause to use additional options could be to choose a migration number to migrate to.
```bash
$ ./migrate.sh 20130320120000 # This will fetch the migration which matches the timestamp.
```

## Bug fixing
General small bug fixes can be done directly on the master branch. 
(If severe, consider rolling back to an earlier tag)

## Apply changes to production
On your local machine, merge in master and tag

```bash
$ git checkout master
$ git pull origin master
$ git checkout prod
$ git merge master
$ git push origin prod
$ git tag -a YYYY-MM-DDvXX # Example 2017-10-26v01
$ git push --tags
```
Now log on to wen.gathering.org and go to /srv/vhosts/wannabe.gathering.org/wannabe

```bash
$ sudo -u wannabe-web git fetch --tags
$ sudo -u wannabe-web git checkout YYYY-MM-DDvXX
```
