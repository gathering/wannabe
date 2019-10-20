ARG GIT_BRANCH
ARG PHP_VERSION

### Development
### (we asume local dev directory is mounted at /var/www/html/wannabe and do most magic in entrypoint script)
FROM php:${PHP_VERSION:-5}-fpm as Development
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
RUN echo "Building app from $GIT_BRANCH branch"

RUN apk add git
RUN git clone --single-branch --branch "$GIT_BRANCH" https://github.com/gathering/wannabe.git ./

# Remove lock file since it's currently configured only for PHP 5
RUN rm -f ./composer.lock
RUN composer install --no-interaction

# App
RUN chmod +x build/prepare.sh && build/prepare.sh

### Production
FROM php:${PHP_VERSION:-5}-fpm-alpine as production
RUN docker-php-ext-install pdo pdo_mysql
COPY --from=builder /app/app /var/www/html/wannabe/app
COPY --from=builder /app/lib /var/www/html/wannabe/lib
COPY --from=builder /app/index.php /var/www/html/wannabe/index.php
