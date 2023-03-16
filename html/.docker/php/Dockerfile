# syntax=docker/dockerfile:1

FROM php:8.1-fpm

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install \
        pdo_pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy the application files
COPY . /var/www/html

# Expose the port the app runs on
EXPOSE 9000

# Start the PHP-FPM server
CMD ["php-fpm"]
