FROM php:7.4.0-fpm-alpine

RUN apk update \
    && apk add --no-cache bash git curl libmcrypt libmcrypt-dev openssh-client icu-dev \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev autoconf nginx \
    && docker-php-source extract \
    && docker-php-source delete \
    && docker-php-ext-install intl \
    && curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer \
    && rm -rf /tmp/* \
    && mkdir -p /run/nginx \
    && apk add supervisor \
    && mkdir -p /var/log/supervisor \
    && rm -rf /var/cache/apk/*

RUN docker-php-ext-install pdo pdo_mysql

COPY files/etc/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY files/etc/supervisor/supervisord.conf /etc/supervisor/conf.d/

WORKDIR /var/www
COPY rota/ .
RUN composer install --no-dev --no-scripts --no-suggest
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

EXPOSE 80
