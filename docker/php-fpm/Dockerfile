#FROM php:8.0-fpm
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libonig-dev \
    zip \
    libzip-dev \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl && \
    # x-debug installation
    # pecl install xdebug-3.0.1 && \
    # docker-php-ext-enable xdebug && \
    docker-php-ext-install pdo_mysql mbstring zip exif pcntl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    #composer install
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    # Clear cache
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка системных зависимостей и php расширений
# Установка системных зависимостей и php расширений
# RUN apk add --no-cache \
#     zip \
#     libzip-dev \
#     freetype \
#     libjpeg-turbo \
#     libpng \
#     freetype-dev \
#     libjpeg-turbo-dev \
#     libpng-dev \
#     nodejs \
#     npm \
#     && docker-php-ext-configure zip \
#     && docker-php-ext-install zip pdo pdo_mysql \
#     && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
#     && docker-php-ext-install -j$(nproc) gd \
#     && docker-php-ext-enable gd \
#     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
#     && apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www && useradd -u 1000 -ms /bin/bash -g www www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]