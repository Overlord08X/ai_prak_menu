# ================================================
# Craft Food Finder - Production Dockerfile
# PHP 8.3 CLI dengan built-in server
# Paling simpel, tidak ada Apache/Nginx conflict
# ================================================
FROM php:8.3-cli

# Install PHP extensions
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy seluruh kode aplikasi
WORKDIR /var/www/html
COPY . .

# Buat folder uploads
RUN mkdir -p public/assets/uploads \
    && chown -R www-data:www-data public/assets/uploads \
    && chmod -R 755 public/assets/uploads

# Expose port 80
EXPOSE 80

# Jalankan PHP built-in server
# Railway inject $PORT env var secara otomatis
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-80} -t public public/router.php"]
