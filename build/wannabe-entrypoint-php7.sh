#!/bin/bash

wannabe-entrypoint

touch app/tmp/logs/{debug,error}.log
chmod -R 777 app/tmp/logs
touch /var/log/apache2/{access,error}.log

service apache2 start
tail -f /var/log/apache2/*.log ./app/tmp/logs/*.log
