FROM php:8.3.3-alpine

# Get UID and GID of host user
ARG UID
ARG GID

# Install dependencies, currently not working
RUN apt-get update

# Install necessary extensions
RUN docker-php-ext-install pdo_mysql

# Enable apache mod_rewrite
RUN a2enmod rewrite

# ADD config/php.ini /usr/local/etc/php.ini
# Set working directory
WORKDIR /var/www/html

RUN chown -R www-data:www-data /var/www
USER www-data

# https://stackoverflow.com/questions/73991553/permission-denied-for-laravel-and-docker
# user muss danach gesetzt werden, da sonst die Rechte nicht stimmen
#RUN usermod --non-unique --uid $UID www-data \
 # && groupmod --non-unique --gid $UID www-data \
 # && chown -R www-data:www-data /var/www
USER $UID

# Expose port 80 for web traffic
EXPOSE 80
