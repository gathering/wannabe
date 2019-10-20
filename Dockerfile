ARG GIT_BRANCH
ARG APP_ENV

### Development
### (we asume local dev directory is mounted at /var/www/html/wannabe and do most magic in entrypoint script)
FROM php:5-fpm as Development
RUN docker-php-ext-install pdo pdo_mysql
RUN apt-get update && apt-get install -y \
	mariadb-client \
	python-pip \
	python-mysqldb-dbg \
	vim
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./build/development-entrypoint.sh /usr/bin/development-entrypoint
RUN chmod a+x /usr/bin/development-entrypoint
ENTRYPOINT ["development-entrypoint"]
CMD ["php-fpm"]

### Builder
FROM composer as Builder
ENV GIT_BRANCH ${GIT_BRANCH:-prod}
ENV APP_ENV ${APP_ENV:-production}
RUN echo "Building app for $APP_ENV environment from $GIT_BRANCH branch"

RUN apk add git
RUN git clone --single-branch --branch "$GIT_BRANCH" https://github.com/gathering/wannabe.git ./

# Remove lock file since it's currently configured only for PHP 5
RUN rm -f ./composer.lock
RUN composer install --no-interaction

# App
# TODO: REMOVE THIS AND THE NEXT LINE
COPY ./build/prepare.sh ./build/prepare.sh
RUN chmod +x build/prepare.sh && build/prepare.sh

### PHP5 production
FROM php:5-fpm-alpine as php5
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=builder /app/app /var/www/html/wannabe/app
COPY --from=builder /app/lib /var/www/html/wannabe/lib
COPY --from=builder /app/index.php /var/www/html/wannabe/index.php

### PHP7 production
FROM php:7-fpm-alpine as php7
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=builder /app/app /var/www/html/wannabe/app
COPY --from=builder /app/lib /var/www/html/wannabe/lib
COPY --from=builder /app/index.php /var/www/html/wannabe/index.php
