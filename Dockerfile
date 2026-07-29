FROM php:8.4-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip libicu-dev libcurl4-openssl-dev libpq-dev \
    && docker-php-ext-install zip intl curl pdo_pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite && a2enmod headers

# Set environment variables
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1

# Adjust Apache configuration to use the public directory as document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess overrides and set SVG MIME type
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/apache2.conf && \
    echo '    AllowOverride All' >> /etc/apache2/apache2.conf && \
    echo '    Require all granted' >> /etc/apache2/apache2.conf && \
    echo '</Directory>' >> /etc/apache2/apache2.conf && \
    echo 'AddType image/svg+xml .svg' >> /etc/apache2/apache2.conf

# Copy application source code
COPY . /var/www/html
WORKDIR /var/www/html

# Copy Composer and install PHP dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Compile assets using Symfony AssetMapper
RUN php bin/console asset-map:compile --env=prod

# Clear Symfony cache
RUN php bin/console cache:clear --env=prod

# Set appropriate permissions for the web server
RUN chown -R www-data:www-data /var/www/html


COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]


# Expose port 80
EXPOSE 80
