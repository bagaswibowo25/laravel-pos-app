FROM php:7.3.0-fpm-alpine
RUN apk add gettext libsodium libsodium-dev
RUN docker-php-ext-install pdo pdo_mysql sockets sodium exif
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . /app
RUN chmod +x /app/startup-script.sh
WORKDIR /app
RUN composer install
CMD ["/bin/sh", "-c", "/app/startup-script.sh"]
