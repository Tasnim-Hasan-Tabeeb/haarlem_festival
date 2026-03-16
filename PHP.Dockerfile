# FROM php:fpm

# RUN docker-php-ext-install pdo pdo_mysql
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


#FROM php:fpm
#
## Install required PHP extensions and tools
#RUN apt-get update && apt-get install -y \
#    unzip \
#    libzip-dev \
#    && docker-php-ext-install zip pdo pdo_mysql \
#    && apt-get clean \
#RUN apt-get update -y && apt-get install -y zlib1g-dev libpng-dev libfreetype6-dev
#RUN docker-php-ext-configure gd --enable-gd --with-freetype
#RUN docker-php-ext-install gd
#
## Copy Composer from the Composer image
#COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
#
## Set working directory
#WORKDIR /app
# Dockerfile

FROM php:fpm

# Install required PHP extensions and tools
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    zlib1g-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy Composer from the Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app
