FROM php:8.2-apache

COPY php/php.ini /usr/local/etc/php/
#COPY php/xdebug.ini /usr/local/etc/php/conf.d/

# Dependencies
RUN apt-get update

RUN apt-get install -y zip unzip libzip-dev curl wget openssh-server nano libc-client-dev libkrb5-dev locales locales-all libpng-dev python3 git

RUN docker-php-ext-install pdo pdo_mysql gd sockets zip bcmath
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install imap

RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

#RUN pecl install xdebug \
#    && docker-php-ext-enable xdebug

ENV LC_ALL pl_PL.UTF-8
ENV LANG pl_PL.UTF-8
ENV LANGUAGE pl_PL.UTF-8

RUN a2enmod rewrite
RUN service apache2 restart

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir -p /usr/local/bin
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony



