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

To test:

```
$ docker build -t LOLOLOL .
$ docker run -ti -v /home/kly/src/wannabe-public:/var/www/html/wannabe LOLOLOL
```

Inside the container, run ``/bootstrap.sh`` which will, SHOCKINGLY,
bootstrap things, start mariadb and apache2 on :80. Since --expose hasn't
been used, finding the IP address is left as an exercise for the reader.

Several further tweaks are needed, but this is a start.


## Installation

[Installation instruction](https://github.com/gathering/wannabe/blob/master/INSTALL.md)  
[Work flow instructions](https://github.com/gathering/wannabe/blob/master/WORKFLOW.md)

All PHP libraries are included, including CakePHP.
