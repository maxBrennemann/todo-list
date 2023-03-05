FROM php:7.4-apache

WORKDIR /var/www/html

RUN a2enmod rewrite headers

RUN docker-php-ext-install pdo_mysql

COPY . .

EXPOSE 80

CMD [ "apache2-foreground" ]