FROM php:8.2-cli

COPY ./back/ /usr/src/movimentacao_financeira
WORKDIR /usr/src/movimentacao_financeira

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y git unzip libzip-dev \
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*
# Instalar a extensão PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql zip

# Instalar o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar os pacotes
RUN composer install

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
