FROM php:7.3-fpm

RUN apt-get update && apt-get install -y cron git-core jq unzip vim zip libxml2-dev unrar-free\
  libjpeg-dev libpng-dev libpq-dev libsqlite3-dev libwebp-dev libzip-dev jpegoptim optipng pngquant gifsicle webp npm && \
  rm -rf /var/lib/apt/lists/* && \
  docker-php-ext-configure zip --with-libzip && \
  docker-php-ext-configure gd --with-png-dir --with-jpeg-dir --with-webp-dir && \
  docker-php-ext-install exif gd opcache zip && \
  npm install -g svgo

RUN { \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=4000'; \
    echo 'opcache.revalidate_freq=2'; \
    echo 'opcache.fast_shutdown=1'; \
    echo 'opcache.enable_cli=1'; \
  } > /usr/local/etc/php/conf.d/docker-oc-opcache.ini

RUN { \
    echo 'log_errors=on'; \
    echo 'display_errors=off'; \
    echo 'upload_max_filesize=32M'; \
    echo 'post_max_size=32M'; \
    echo 'memory_limit=128M'; \
  } > /usr/local/etc/php/conf.d/docker-oc-php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
  /usr/local/bin/composer global require hirak/prestissimo

CMD ["php-fpm"]
