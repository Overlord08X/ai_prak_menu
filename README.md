# Craft Food Finder

Aplikasi web sistem pakar berbasis Native PHP 8.3 dengan metode Forward Chaining untuk rekomendasi resep makanan berdasarkan bahan yang tersedia.

## Teknologi

- Native PHP 8.3
- MySQL 8
- HTML5, CSS3, Bootstrap 5
- JavaScript, SweetAlert2, DataTables
- Docker, Docker Compose, Nginx, WSL Ubuntu

## Menjalankan Aplikasi

```bash
docker compose up -d --build
```

Akses:

- Aplikasi: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## Dokumentasi Tambahan

- [Panduan instalasi Docker di WSL](docs/install-docker-wsl.md)
- [UML dan ERD](docs/uml.md)

## Login Admin Default

- Email: admin@craftfood.com
- Password: admin123

## Struktur Utama

- app/controllers
- app/models
- app/services
- app/config
- public
- views
- database/sql
- docker
