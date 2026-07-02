# ================================================
# Craft Food Finder - Production Dockerfile
# PHP 8.3 + Apache (single process, paling reliable)
# Digunakan untuk Railway deployment
# ================================================
FROM php:8.3-apache

# Install PHP extensions yang dibutuhkan
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite (untuk URL routing)
RUN a2enmod rewrite

# Copy Apache VirtualHost config
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copy seluruh kode aplikasi
WORKDIR /var/www/html
COPY . .

# Buat folder uploads dengan permission yang benar
RUN mkdir -p public/assets/uploads \
    && chown -R www-data:www-data public/assets/uploads \
    && chmod -R 755 public/assets/uploads

# Expose port 80
EXPOSE 80
