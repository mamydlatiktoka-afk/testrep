FROM php:8.2-cli

WORKDIR /app
COPY . .

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

CMD ["php", "-S", "0.0.0.0:8080", "index.php"]
