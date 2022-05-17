FROM php:8.1.5-fpm

WORKDIR /
VOLUME /app

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y zip 
RUN apt-get install -y unzip
RUN apt-get install -y netcat

RUN curl https://raw.githubusercontent.com/eficode/wait-for/v2.2.3/wait-for -o wait-for.sh
RUN chmod +x wait-for.sh
RUN mv wait-for.sh /usr/local/bin/wait-for

# RUN pecl install mongodb && docker-php-ext-enable mongodb
# RUN pecl install xdebug && docker-php-ext-enable xdebug
# RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
# RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY app/composer.json .
COPY app/composer.lock .
COPY /app .
ENV COMPOSER_ALLOW_SUPERUSER=1
# RUN composer install --ignore-platform-reqs
# RUN composer dump-autoload

EXPOSE 9003