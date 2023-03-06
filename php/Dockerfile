FROM php:8.1-apache

COPY . /var/www/html
# Copy custom php.ini if needed
# COPY php.ini /usr/local/etc/php/

# Install any additional PHP extensions or dependencies here
# For example:
# RUN docker-php-ext-install pdo_mysql

# Change Apache document root
# RUN sed -ri -e 's!/var/www/html!/php!g' /etc/apache2/sites-available/*.conf
# RUN sed -ri -e 's!/var/www/!/php!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Enable Apache modules if needed
# For example:
# RUN a2enmod rewrite

EXPOSE 80



#FROM php:7.4-apache

#WORKDIR /var/www/html

#RUN a2enmod rewrite headers

#RUN docker-php-ext-install pdo_mysql

#COPY . .
#COPY . /var/www/html

#EXPOSE 80

#CMD [ "apache2-foreground" ]