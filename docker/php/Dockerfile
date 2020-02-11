#ARG PHP_BASE_IMAGE_VERSION
FROM php:7.3.5-fpm-alpine

# Install system packages & PHP extensions required for Yii 2.0 Framework
RUN apk --update --virtual build-deps add \
        autoconf \
        make \
        gcc \
        g++ \
        libtool \
        icu-dev \
        curl-dev \
        freetype-dev \
        imagemagick-dev \
        pcre-dev \
        postgresql-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        libxml2-dev && \
    apk add \
        libzip-dev \
        git \
        curl \
        bash \
        bash-completion \
        icu \
        imagemagick \
        pcre \
        freetype \
        libintl \
        libjpeg-turbo \
        libpng \
        libltdl \
        libxml2 \
        mysql-client \
        postgresql && \
    docker-php-ext-configure gd \
        --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-configure bcmath && \
    docker-php-ext-configure zip --with-libzip=/usr/include

RUN docker-php-ext-install \
        soap \
        zip \
        curl \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        mbstring \
        opcache \
        mysqli \
        pdo_mysql \
        pdo_pgsql && \
    pecl install \
        imagick \
        xdebug && \
    docker-php-ext-enable xdebug && \
    apk del \
        build-deps

RUN apk add openssh

RUN echo "extension=imagick.so" > /usr/local/etc/php/conf.d/pecl-imagick.ini
#    echo "extension=mongodb.so" > /usr/local/etc/php/conf.d/pecl-mongodb.ini
#    echo "extension=redis.so" > /usr/local/etc/php/conf.d/pecl-redis.ini
    # && echo "extension=xdebug.so" > /usr/local/etc/php/conf.d/pecl-xdebug.ini

RUN echo xdebug.remote_enable=1 >> /usr/local/etc/php/conf.d/pecl-xdebug.ini && \
    echo xdebug.remote_autostart=1 >> /usr/local/etc/php/conf.d/pecl-xdebug.ini && \
    echo xdebug.remote_host=host.docker.internal >> /usr/local/etc/php/conf.d/pecl-xdebug.ini
#     echo xdebug.remote_port=9001 >> /usr/local/etc/php/conf.d/pecl-xdebug.ini && \

# Configure version constraints
ENV PHP_ENABLE_XDEBUG=1 \
    PATH=/app:/app/vendor/bin:/root/.composer/vendor/bin:$PATH \
    TERM=linux \
    VERSION_PRESTISSIMO_PLUGIN=^0.3.7 \
    COMPOSER_ALLOW_SUPERUSER=1

# Add configuration files

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
    composer clear-cache

# Install composer plugins
#RUN composer global require --optimize-autoloader \
#        "hirak/prestissimo:${VERSION_PRESTISSIMO_PLUGIN}" && \
#    composer global dumpautoload --optimize && \
#    composer clear-cache

RUN mkdir -p /var/www/app/var && chown -R www-data:www-data /var/www/app

WORKDIR /var/www/app

#COPY ./docker/php/docker-php-entrypoint /usr/local/bin/
#RUN chmod +x /usr/local/bin/docker-php-entrypoint
