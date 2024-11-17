# Usar a imagem oficial do PHP
FROM php:8.2-fpm

# Instalar dependências do sistema e extensões do PHP
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pcntl

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar diretório de trabalho
WORKDIR /var/www

# Copiar arquivos do projeto para dentro do container
COPY . .

# Copiar o arquivo php.ini para o diretório correto
COPY php/php.ini /usr/local/etc/php/php.ini

# Instalar dependências do Laravel (via Composer)
RUN composer install --no-scripts --no-autoloader

# Instalar as dependências completas após o código ser copiado
RUN composer dump-autoload && composer install --optimize-autoloader --no-dev

# Definir permissões
RUN chown -R www-data:www-data /var/www

# Expor a porta 9000 para o PHP-FPM
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]
