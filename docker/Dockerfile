############################################
# Base Image
############################################

# Learn more about the Server Side Up PHP Docker Images at:
# https://serversideup.net/open-source/docker-php/
FROM serversideup/php:8.3-fpm-nginx AS base

# Switch to root before installing our PHP extensions
USER root

RUN install-php-extensions bcmath
RUN install-php-extensions gd
RUN install-php-extensions intl
RUN install-php-extensions exif

RUN apt-get update; \
    apt-get upgrade -y; \
    apt-get -f install -y --no-install-recommends \
    lsb-release \
    wget \
    libaio1 \
    vim \
    zsh \
    npm \
    dos2unix; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

############################################
# Development Image
############################################
FROM base AS development

# We can pass USER_ID and GROUP_ID as build arguments
# to ensure the www-data user has the same UID and GID
# as the user running Docker.
ARG USER_ID
ARG GROUP_ID

# Switch to root so we can set the user ID and group ID
USER root
RUN docker-php-serversideup-set-id www-data $USER_ID:$GROUP_ID  && \
    docker-php-serversideup-set-file-permissions --owner $USER_ID:$GROUP_ID --service nginx

# Switch back to the unprivileged www-data user
USER www-data

############################################
# CI image
############################################
FROM base AS ci

# Sometimes CI images need to run as root
# so we set the ROOT user and configure
# the PHP-FPM pool to run as www-data
USER root
RUN echo "user = www-data" >> /usr/local/etc/php-fpm.d/docker-php-serversideup-pool.conf && \
    echo "group = www-data" >> /usr/local/etc/php-fpm.d/docker-php-serversideup-pool.conf

############################################
# Production Image
############################################
FROM base AS deploy
COPY --chown=www-data:www-data . /var/www/html

# Customize php
COPY php.ini /usr/local/etc/php/conf.d/zzz-custom-php.ini

# Adding your own start up scripts
COPY --chmod=755 ./entrypoint.d/ /etc/entrypoint.d/

# Conf S6-Overlay
COPY --chmod=755 ./s6-conf/user/contents.d/laravel-queue /etc/s6-overlay/s6-rc.d/user/contents.d/laravel-queue
COPY --chmod=755 ./s6-conf/laravel-queue /etc/s6-overlay/s6-rc.d/laravel-queue
COPY --chmod=755 ./s6-conf/scripts/laravel-queue.sh /etc/s6-overlay/scripts/laravel-queue.sh
COPY --chmod=755 ./s6-conf/user/contents.d/laravel-schedule /etc/s6-overlay/s6-rc.d/user/contents.d/laravel-schedule
COPY --chmod=755 ./s6-conf/laravel-schedule /etc/s6-overlay/s6-rc.d/laravel-schedule
COPY --chmod=755 ./s6-conf/scripts/laravel-schedule.sh /etc/s6-overlay/scripts/laravel-schedule.sh
RUN dos2unix \
    /etc/s6-overlay/s6-rc.d/laravel-queue/run \
    /etc/s6-overlay/scripts/laravel-queue.sh \
    /etc/s6-overlay/s6-rc.d/laravel-schedule/run \ 
    /etc/s6-overlay/scripts/laravel-schedule.sh

USER www-data

