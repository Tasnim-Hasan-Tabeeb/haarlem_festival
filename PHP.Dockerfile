FROM php:8.3-fpm-bookworm

# 1) Install base tools + deps
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    curl ca-certificates gnupg2 apt-transport-https \
    unzip \
    unixodbc unixodbc-dev \
    libzip-dev zlib1g-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    $PHPIZE_DEPS \
    ; \
    rm -rf /var/lib/apt/lists/*

# 2) Add Microsoft repo + install ODBC driver (the missing runtime)
RUN set -eux; \
    curl -fsSL https://packages.microsoft.com/keys/microsoft.asc \
    | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg; \
    echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/microsoft-prod.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" \
    > /etc/apt/sources.list.d/microsoft-prod.list; \
    apt-get update; \
    ACCEPT_EULA=Y apt-get install -y --no-install-recommends msodbcsql18; \
    rm -rf /var/lib/apt/lists/*

# 3) PHP extensions
RUN set -eux; \
    docker-php-ext-install pdo pdo_mysql zip; \
    docker-php-ext-configure gd; \
    docker-php-ext-install gd

# 4) SQL Server PHP drivers
RUN set -eux; \
    pecl channel-update pecl.php.net; \
    printf "\n" | pecl install sqlsrv; \
    printf "\n" | pecl install pdo_sqlsrv; \
    docker-php-ext-enable sqlsrv pdo_sqlsrv

# Copy Composer from the Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app
