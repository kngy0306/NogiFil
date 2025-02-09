FROM php:8.2.27-fpm

ENV TZ Asia/Tokyo
ENV COMPOSER_ALLOW_SUPERUSER 1

# install Library
# ベースイメージのOSがalpineの場合は xdebug を使うために autoconf gcc g++ make が必要
RUN apt-get update && \
    apt-get install -y \
		git \
		zip \
		unzip \
		vim \
		autoconf gcc g++ make

# PDO
RUN docker-php-ext-install pdo_mysql

# config file COPY
COPY conf/php.ini /usr/local/etc/php/php.ini
COPY conf/docker.conf /usr/local/etc/php-fpm.d/docker.conf

# install Composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

WORKDIR /app

CMD ["/bin/ash"]
