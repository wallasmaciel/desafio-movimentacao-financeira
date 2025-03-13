FROM php:8.2-cli

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y git \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*
# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer