ARG PHP_VERSION

### Builder
FROM composer as Builder
ARG GIT_BRANCH
RUN echo "Building app from ${GIT_BRANCH:-prod} branch, with PHP version ${PHP_VERSION:-7}"

RUN apk add git
RUN git clone --single-branch --branch ${GIT_BRANCH:-prod} https://github.com/gathering/wannabe.git ./

# Remove lock file since it's currently configured only for PHP 5
RUN rm -f ./composer.lock
RUN composer install --no-interaction

# App
RUN chmod +x build/prepare.sh && build/prepare.sh


### Production
FROM php:${PHP_VERSION:-5}-fpm-alpine as production
RUN apk add --no-cache libpng libpng-dev libjpeg-turbo-dev gettext gettext-dev php-pear
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql gd exif gettext
COPY --from=builder /app/app /var/www/html/wannabe/app
COPY --from=builder /app/lib /var/www/html/wannabe/lib
COPY --from=builder /app/index.php /var/www/html/wannabe/index.php


### Development
FROM php:${PHP_VERSION:-7}-fpm as Development
RUN apt-get update && apt-get install -y \
	mariadb-client \
	python-dev \
	python-pip \
	python-mysqldb-dbg \
	git \
	vim \
	man \
	zip \
	libpng-dev \
	libjpeg-dev \
	unzip
RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql gd exif
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY --from=builder /app /var/www/html/wannabe
COPY --from=builder /app/build/development-entrypoint.sh /usr/bin/development-entrypoint
COPY --from=builder /app/build/tooling-entrypoint.sh /usr/bin/tooling-entrypoint
RUN chmod a+x /usr/bin/development-entrypoint
RUN chmod a+x /usr/bin/tooling-entrypoint
ENTRYPOINT ["development-entrypoint"]
CMD ["php-fpm"]
