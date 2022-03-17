FROM php:8.1.3-fpm
RUN apt-get update -y && apt-get install -y libmcrypt-dev openssl mcrypt curl vim git zip unzip
RUN docker-php-ext-install pdo pdo_mysql
RUN pecl install xdebug; \
    docker-php-ext-enable xdebug
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www/html/
COPY . /var/www/html/
RUN composer install
COPY php.ini /usr/local/etc/php/php.ini
CMD php artisan serve --host=0.0.0.0 --port=80
EXPOSE 8000
