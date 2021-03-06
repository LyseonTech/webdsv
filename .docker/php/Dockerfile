FROM php:8-fpm as prod
RUN apt-get update && \
    apt-get install -y \
        git \
        cmake \
        poppler-data \
        libopenjp2-7-dev \
        libfreetype6-dev \
        libfontconfig1-dev \
        libjpeg-dev \
        libtiff5-dev \
        libnss3-dev \
        zip

RUN curl https://poppler.freedesktop.org/poppler-20.08.0.tar.xz -o /tmp/poppler-20.08.0.tar.xz \
    && cd /tmp && tar -xf poppler-20.08.0.tar.xz \
    && cd poppler-20.08.0 && mkdir build && cd build \
    && cmake .. -DBUILD_GTK_TESTS=OFF -DBUILD_QT5_TESTS=OFF -DBUILD_QT6_TESTS=OFF -DBUILD_CPP_TESTS=OFF -DENABLE_SPLASH=OFF -DENABLE_CPP=OFF -DENABLE_GLIB=OFF -DENABLE_GOBJECT_INTROSPECTION=OFF -DENABLE_QT5=OFF -DENABLE_QT6=OFF -DENABLE_CMS=lcms2 -DENABLE_LIBOPENJPEG=openjpeg2 \
    && make

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
ENTRYPOINT ["sh", "/usr/local/bin/entrypoint.sh"]

FROM prod as dev
RUN yes | pecl install xdebug-2.9.6
RUN echo "" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=network_database" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.profiler_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini
