FROM ubuntu:xenial
LABEL maintainer="Alexander <horat1us> Letnikow"

WORKDIR /usr/src/app

RUN apt update
RUN apt -y install nginx php-fpm php-cli php-mbstring git unzip php-zip curl

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer

EXPOSE 80

COPY composer.json .
COPY composer.lock .

RUN composer install

COPY . /usr/src/app

COPY nginx/production.nginx /etc/nginx/sites-enabled/default
COPY ./nginx/start.sh /usr/src/app

CMD /usr/src/app/start.sh