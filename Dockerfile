# Set our base image
FROM serversideup/php:8.2-fpm-nginx

# Install PHP Imagemagick using regular Ubuntu commands
RUN apt-get update \
    && apt-get install -y --no-install-recommends php8.2-imagick \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY src /var/www/html

RUN rm -rf /var/www/html/storage/logs/*.log

RUN chown -R webuser:webgroup /var/www/html/