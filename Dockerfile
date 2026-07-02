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

# Hapus default nginx config bawaan Alpine yang bisa konflik
RUN rm -f /etc/nginx/http.d/default.conf

# Copy konfigurasi Nginx kita
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf

# Copy konfigurasi Supervisor
COPY docker/supervisord.conf /etc/supervisord.conf

# Copy seluruh kode aplikasi
WORKDIR /var/www/html
COPY . .

# Buat direktori yang diperlukan
# Alpine tidak punya www-data, pakai nobody atau nginx
RUN mkdir -p public/assets/uploads \
    && mkdir -p /run/nginx \
    && mkdir -p /run/supervisord \
    && chown -R nginx:nginx public/assets/uploads \
    && chmod -R 755 public/assets/uploads

# Expose port 80
EXPOSE 80

# Start Supervisor (menjalankan nginx + php-fpm)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
