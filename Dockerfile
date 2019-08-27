FROM php:5-apache as Builder
WORKDIR /var/www/html/wannabe

# PHP and tooling
RUN apt-get update && apt-get install -y \
	mariadb-client \
	python-dev \
	python-pip \
	python-mysqldb-dbg \
	git \
	vim \
	man \
	zip \
	unzip

RUN docker-php-ext-install pdo pdo_mysql

# Python - migration requirements
COPY ./migrate/requirements.txt ./migrate/
RUN pip install -r ./migrate/requirements.txt

# Apache
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN a2enmod rewrite
COPY build/wb-dev-apache2.conf /etc/apache2/sites-available/
RUN a2ensite wb-dev-apache2
RUN a2dissite 000-default

# Composer - CakePHP requirements
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.* ./
RUN composer install --no-interaction

# App
COPY . .
RUN ln -sf /var/www/html/wannabe/lib/Cake/Console/cake /bin/cake

# Startup
COPY build/wannabe-entrypoint.sh /usr/bin/wannabe-entrypoint
RUN chmod a+x /usr/bin/wannabe-entrypoint
ENTRYPOINT ["wannabe-entrypoint"]
CMD ["apache2-foreground"]

# TODO: Optional optimized production step
# FROM alpine:... AS Production
# ...
# COPY --from=builder /var/www/html/wannabe/app /var/www/html/wannabe
# ...
# CMD ["apache2-foreground"]
