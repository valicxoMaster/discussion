FROM phpdockerio/php73-fpm:latest

# Install selected extensions and other stuff, git and supervisor
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.3-mysql php7.3-soap php7.3-bcmath mariadb-client \
        git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY ./dockerenv/php-fpm/php-ini-overrides.ini /etc/php/7.3/fpm/conf.d/99-overrides.ini
COPY ./app /var/www/html
COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

#RUN composer install