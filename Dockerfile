FROM php:8.3-fpm

# 1) Instala libs de sistema
RUN apt-get update && apt-get install -y \
      git curl zip unzip libpng-dev libonig-dev libxml2-dev libpq-dev \
    && docker-php-ext-install pdo_mysql pdo_pgsql bcmath gd mbstring \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# 2) Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3) Defina o working dir onde o código será montado
WORKDIR /var/www/html

# 4) Copie as definições de dependências
COPY src/composer.json src/composer.lock ./

# 5) Instale pacotes sem instalar ainda o código completo (cache de deps)
RUN composer install --prefer-dist --no-scripts --no-autoloader

# 6) Copie todo o Laravel (dentro de src/) para o container
COPY src/ ./

# 7) Gere o autoload otimizado
RUN composer dump-autoload --optimize

# 8) Instale o Scribe e publique a config
RUN composer require --dev knuckleswtf/scribe \
 && php artisan vendor:publish \
      --provider="Knuckles\\Scribe\\ScribeServiceProvider" \
      --ansi --force

# 9) Exponha apenas para registro (o Nginx faz o proxy)
EXPOSE 9000

# 10) Inicie o PHP-FPM
CMD ["php-fpm"]
