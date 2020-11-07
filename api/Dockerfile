FROM php:7.3-fpm-stretch

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
        libmcrypt-dev \
        libjpeg-dev \
        libpng-dev \
        libpq-dev \
        git \
        zip \
        gpg \        
        wget \
        libxrender1 \
        libfontconfig \
        libc-client-dev \
        libkrb5-dev \    
    && docker-php-ext-install mbstring \    
    && docker-php-ext-enable opcache    

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /application

# Copy codebase
COPY . ./

# COPY ./bootstrap.sh ./
RUN composer install --prefer-dist --no-scripts --no-autoloader && rm -rf /root/.composer

# Finish composer
RUN composer dump-autoload --no-scripts --optimize

RUN chown -R www-data:www-data .
RUN chmod -R o+w ./storage

CMD ["bash", "bootstrap.sh"]