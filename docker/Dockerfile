FROM php:8.0-apache

COPY php/php.ini /usr/local/etc/php/

# Dependencies
RUN apt-get update

RUN apt-get install -y zip unzip libzip-dev curl wget openssh-server nano libc-client-dev libkrb5-dev locales locales-all libpng-dev python3 git

RUN docker-php-ext-install pdo pdo_mysql gd sockets zip bcmath
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

ENV LC_ALL pl_PL.UTF-8
ENV LANG pl_PL.UTF-8
ENV LANGUAGE pl_PL.UTF-8

RUN a2enmod rewrite
RUN service apache2 restart

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir -p /usr/local/bin
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony


