FROM php:7.4-apache

RUN apt-get update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*


RUN apt-get -y update && \
    apt-get -y --no-install-recommends install nano wget

COPY ./vhost/rowles.local.conf /etc/apache2/sites-available/rowles.local.conf
COPY ./start-apache /usr/local/bin
RUN a2enmod headers rewrite
RUN ln -s /etc/apache2/sites-available/rowles.local.conf /etc/apache2/sites-enabled/rowles.local.conf

RUN chown -R www-data:www-data /var/www

CMD ["start-apache"]