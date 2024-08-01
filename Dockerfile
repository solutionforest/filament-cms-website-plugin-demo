# Set our base image
FROM --platform=linux/amd64 serversideup/php:8.3-fpm-apache

USER root

RUN apt-get update \
    apt-get upgrade -y; \
    apt-get -f install -y --no-install-recommends \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN install-php-extensions imagick/imagick@master
RUN install-php-extensions intl

# COPY --chmod=755 docker/s6-conf/laravel-queue-default /etc/s6-overlay/s6-rc.d/laravel-queue-default
# COPY --chmod=755 docker/s6-conf/laravel-schedule /etc/s6-overlay/s6-rc.d/laravel-schedule
# COPY --chmod=755 docker/s6-conf/scripts/laravel-schedule /etc/s6-overlay/scripts/laravel-schedule
# COPY --chmod=755 docker/s6-conf/scripts/laravel-queue-default /etc/s6-overlay/scripts/laravel-queue-default
# COPY --chmod=755 docker/s6-conf/user/contents.d/laravel-schedule /etc/s6-overlay/s6-rc.d/user/contents.d/laravel-schedule
# COPY --chmod=755 docker/s6-conf/user/contents.d/laravel-queue-default /etc/s6-overlay/s6-rc.d/user/contents.d/laravel-queue-default

COPY --chown=www-data:www-data src /var/www/html

RUN rm -rf /var/www/html/storage/logs/*.log

USER www-data