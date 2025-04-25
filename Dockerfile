FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt update && \
    apt install -y unzip zip libpq-dev git curl netcat-openbsd && \
    docker-php-ext-install pdo pdo_pgsql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./hotels /var/www/html

CMD ["sh", "-c", "composer install && php artisan config:clear && php artisan migrate && php artisan serve --host=0.0.0.0 --port=8000"]