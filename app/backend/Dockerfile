FROM php:8.3-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libsqlite3-dev \
    && docker-php-ext-install pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY composer.json ./
RUN composer install --no-interaction --no-progress --prefer-dist

COPY . .

RUN php database/migrate.php && php database/seed.php

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
