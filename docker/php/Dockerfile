FROM php:8.2-cli-alpine

ENV CASSANDRA_PHP_CHECKOUT_REF="1cf12c5ce49ed43a2c449bee4b7b23ce02a37bf0"

RUN apk add --update curl zip git zlib-dev libzip-dev curl-dev

COPY scripts /usr/bin/

RUN php-install-cassandra

RUN curl -o /tmp/composer-setup.php https://getcomposer.org/installer \
    && curl -o /tmp/composer-setup.sig https://composer.github.io/installer.sig \
    && php -r "if (hash('SHA384', file_get_contents('/tmp/composer-setup.php')) !== trim(file_get_contents('/tmp/composer-setup.sig'))) { unlink('/tmp/composer-setup.php'); echo 'Invalid installer' . PHP_EOL; exit(1); }" \
    && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/local/bin --filename=composer \
    && rm -f /tmp/composer-setup.*

COPY app /usr/local/app
RUN cd /usr/local/app && /usr/local/bin/composer install --no-dev --prefer-dist

ENTRYPOINT ["php", "/usr/local/app/bin/console.php"]