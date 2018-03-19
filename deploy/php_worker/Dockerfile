FROM php:7.2-alpine3.7

#替换国内镜像
COPY source.list /etc/apk/repositories

RUN apk update && apk --no-cache add freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev supervisor \
 && docker-php-ext-configure gd \
  --with-gd \
  --with-freetype-dir=/usr/include/ \
  --with-png-dir=/usr/include/ \
  --with-jpeg-dir=/usr/include/ \
  --with-zlib-dir=/usr \
 && NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) \
 && docker-php-ext-install -j${NPROC} gd zip pdo_mysql \
 && apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev

RUN rm /var/cache/apk/* \
    && mkdir -p /var/www

COPY supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisor/supervisord.conf"]