# ================================================
# Craft Food Finder - Production Dockerfile
# PHP 8.3-FPM + Nginx dalam satu container
# Digunakan untuk Railway deployment
# ================================================
FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mysqli \
    && rm -rf /var/cache/apk/*

# Copy konfigurasi Nginx
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Copy konfigurasi Supervisor (mengelola nginx + php-fpm bersamaan)
COPY docker/supervisord.conf /etc/supervisord.conf

# Copy seluruh kode aplikasi
WORKDIR /var/www/html
COPY . .

# Buat folder uploads jika belum ada
RUN mkdir -p public/assets/uploads \
    && chown -R www-data:www-data public/assets/uploads \
    && chmod -R 755 public/assets/uploads

# Expose port 80
EXPOSE 80

# Start Supervisor (menjalankan nginx + php-fpm)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
