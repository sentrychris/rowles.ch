FROM php:7.4-apache

RUN apt-get update --fix-missing && \
    apt-get upgrade -y && \
    apt-get --no-install-recommends install -y apt-utils && \
    rm -rf /var/lib/apt/lists/*


RUN apt-get -y update && \
    apt-get -y --no-install-recommends install nano wget iproute2 && \
    apt-get -y install libsqlite3-dev libsqlite3-0 && \
    apt-get -y --no-install-recommends install default-mysql-client zlib1g-dev libzip-dev libicu-dev && \
    apt-get -y --no-install-recommends install --fix-missing apt-utils build-essential git curl libonig-dev && \
    apt-get -y --no-install-recommends install --fix-missing libcurl4 libcurl4-openssl-dev zip openssl && \
    rm -rf /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN pecl install xdebug-2.8.0 && \
    docker-php-ext-enable xdebug


RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo_sqlite && \
    docker-php-ext-install mysqli && \
    docker-php-ext-install curl && \
    docker-php-ext-install tokenizer && \
    docker-php-ext-install json && \
    docker-php-ext-install zip && \
    docker-php-ext-install -j$(nproc) intl && \
    docker-php-ext-install mbstring && \
    docker-php-ext-install gettext && \
    docker-php-ext-install calendar && \
    docker-php-ext-install exif


COPY rowles.local.conf /etc/apache2/sites-available/rowles.local.conf
COPY start-apache /usr/local/bin
RUN a2enmod headers rewrite
RUN ln -s /etc/apache2/sites-available/rowles.local.conf /etc/apache2/sites-enabled/rowles.local.conf
RUN chown -R www-data:www-data /var/www
CMD ["start-apache"]