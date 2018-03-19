FROM php:7.2-fpm-alpine3.7

#替换国内镜像
COPY deploy/source.list /etc/apk/repositories

RUN apk update && apk --no-cache add freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev curl nodejs zlib-dev \
 && docker-php-ext-configure gd \
  --with-gd \
  --with-freetype-dir=/usr/include/ \
  --with-png-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ \
  --with-zlib-dir=/usr \
 && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
 && docker-php-ext-install -j${NPROC} gd zip pdo_mysql \
 && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=${PHP_TIMEZONE:-UTC}" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_VERSION 1.6.3

RUN php -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');" \
 && php composer-setup.php --no-ansi --install-dir=/usr/bin --filename=composer --version=${COMPOSER_VERSION} \
 && php -r "unlink('composer-setup.php');"

WORKDIR /var/www/

CMD ["php-fpm"]

# ENTRYPOINT ["/var/www/deploy/docker-entrypoint.sh"]