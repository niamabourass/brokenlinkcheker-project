FROM dunglas/frankenphp:php8.3

WORKDIR /app

RUN install-php-extensions \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --no-scripts

COPY . .

RUN mkdir -p \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

RUN php artisan package:discover --ansi

RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

COPY <<'EOF' /etc/caddy/Caddyfile
{
    auto_https off
}

:{$PORT} {
    root * /app/public
    encode gzip

    php_server

    file_server
}
EOF

EXPOSE 8080

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]