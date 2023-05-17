# Set our base image
FROM serversideup/php:8.2-fpm-nginx

# Install PHP Imagemagick using regular Ubuntu commands
RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.2-imagick \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


COPY --chmod=755 docker/s6-conf/laravel-queue-default /etc/s6-overlay/s6-rc.d/laravel-queue-default
COPY --chmod=755 docker/s6-conf/laravel-schadule /etc/s6-overlay/s6-rc.d/laravel-schadule

COPY --chmod=755 docker/s6-conf/scripts/laravel-schadule /etc/s6-overlay/scripts/laravel-schadule
COPY --chmod=755 docker/s6-conf/scripts/laravel-queue-default /etc/s6-overlay/scripts/laravel-queue-default

COPY --chmod=755 docker/s6-conf/user/contents.d/laravel-schadule /etc/s6-overlay/s6-rc.d/user/contents.d/laravel-schadule
COPY --chmod=755 docker/s6-conf/user/contents.d/laravel-queue-default /etc/s6-overlay/s6-rc.d/user/contents.d/laravel-queue-default

COPY src /var/www/html

RUN rm -rf /var/www/html/storage/logs/*.log

RUN chown -R webuser:webgroup /var/www/html/