FROM debian:buster
RUN apt-get update
RUN apt-get -y install mariadb-server php7.3 apache2 php7.3-mysql php7.3-gd python3-dev libmariadbclient-dev python3-pip libmariadb-dev libmariadb-dev-compat python3-mysqldb vim man
RUN a2enmod rewrite
ADD build/wb-dev-apache2.conf /etc/apache2/sites-available/
RUN a2ensite wb-dev-apache2
RUN a2dissite 000-default
VOLUME /var/www/html/wannabe
ADD migrate/requirements.txt /mig-req.txt
RUN pip3 install -r /mig-req.txt
ADD build/bootstrap.sh /
RUN chmod a+x /bootstrap.sh
