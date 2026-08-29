# All-in-one local image for zixhr.com — mirrors the single production server:
# nginx + PHP-FPM (WordPress) + MariaDB all run in ONE container, managed by
# supervisord. For LOCAL TESTING ONLY.
FROM php:8.2-fpm

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
        nginx mariadb-server mariadb-client supervisor \
        libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libicu-dev \
        less curl ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd mysqli pdo_mysql zip intl opcache \
    && curl -fsSL https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
        -o /usr/local/bin/wp && chmod +x /usr/local/bin/wp \
    && rm -rf /var/lib/apt/lists/*

# nginx config (this is the file the backup workflow captures from production:
# /etc/nginx/nginx.conf).
COPY nginx/nginx.conf /etc/nginx/nginx.conf

# Process manager + startup script.
COPY supervisord.conf /etc/supervisor/conf.d/zixhr.conf
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
# The mariadb-server package pre-seeds /var/lib/mysql at build time. Clear it so
# the entrypoint performs a clean init on first container boot (against the
# mounted volume) and reliably creates the WordPress DB + user.
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && rm -rf /var/lib/mysql && mkdir -p /var/www/html /run/mysqld /var/lib/mysql \
    && chown -R mysql:mysql /run/mysqld /var/lib/mysql

WORKDIR /var/www/html

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/zixhr.conf"]
