FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libicu-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install \
        gd \
        zip \
        intl \
        curl \
        pdo_pgsql \
 && pecl install redis \
 && docker-php-ext-enable redis \
 && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite && a2enmod headers

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN sed -i "/DocumentRoot \/var\/www\/html\/public/a \\\n\
    <Directory \/var\/www\/html\/public>\\\n\
        AllowOverride All\\\n\
        Require all granted\\\n\
    <\/Directory>" /etc/apache2/sites-available/000-default.conf

RUN echo 'AddType image/svg+xml .svg' >> /etc/apache2/apache2.conf

COPY . /var/www/html
WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

RUN php bin/console asset-map:compile --env=prod

RUN php bin/console cache:clear --env=prod

RUN chown -R www-data:www-data /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 80
