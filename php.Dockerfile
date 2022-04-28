FROM php:fpm

VOLUME /app

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y zip unzip

# RUN pecl install mongodb && docker-php-ext-enable mongodb
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# RUN useradd -ms /bin/bash cuser
# USER cuser
# RUN pwd
WORKDIR /app
COPY app/ ./
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --ignore-platform-reqs
# USER root
# RUN whoami

EXPOSE 9003
