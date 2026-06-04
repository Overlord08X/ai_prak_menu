# Panduan Instalasi Docker di WSL Ubuntu

Panduan ini disiapkan untuk menjalankan Craft Food Finder di lingkungan Windows dengan WSL Ubuntu.

## 1. Aktifkan WSL

Jalankan PowerShell sebagai Administrator:

```powershell
wsl --install -d Ubuntu
```

Jika WSL sudah aktif, pastikan distribusi Ubuntu tersedia:

```powershell
wsl --list --verbose
```

## 2. Update Paket Ubuntu

Buka terminal Ubuntu lalu jalankan:

```bash
sudo apt update
sudo apt upgrade -y
```

## 3. Install Docker Engine di WSL

Ikuti dokumentasi resmi Docker untuk Ubuntu. Ringkasannya:

```bash
sudo apt install -y ca-certificates curl gnupg
sudo install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg
sudo chmod a+r /etc/apt/keyrings/docker.gpg
```

Tambahkan repository Docker lalu install:

```bash
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo $VERSION_CODENAME) stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

sudo apt update
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

## 4. Jalankan Service Docker

```bash
sudo service docker start
```

Jika ingin memakai Docker tanpa `sudo`, tambahkan user ke grup docker:

```bash
sudo usermod -aG docker $USER
```

Lalu login ulang ke WSL.

## 5. Build dan Jalankan Project

Masuk ke folder project:

```bash
cd /mnt/c/Users/raiha/OneDrive/Documents/vscode/aiprak
```

Jalankan:

```bash
docker compose up -d --build
```

## 6. Import Database

Skema dan seed SQL ada di:

- database/sql/craft_food_finder.sql

MySQL container akan otomatis menjalankan file SQL tersebut saat container pertama kali dibuat.

## 7. Akses Aplikasi

- Aplikasi: http://localhost:8080
- phpMyAdmin: http://localhost:8081

## 8. Login Admin Default

- Email: admin@craftfood.com
- Password: admin123
