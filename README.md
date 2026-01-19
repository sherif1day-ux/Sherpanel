# ⚡ SherPanel

![Version](https://img.shields.io/badge/version-1.0.0-cyan?style=for-the-badge&logo=none)
![Laravel](https://img.shields.io/badge/Laravel-10-red?style=for-the-badge&logo=laravel)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vue.js)
![TailwindCSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)
![License](https://img.shields.io/badge/license-MIT-blue?style=for-the-badge)

**SherPanel** adalah Hosting Control Panel modern yang futuristik, ringan, dan powerful. Dibangun dengan teknologi terkini (Laravel, Inertia, Vue 3) dengan antarmuka **Neon Cyberpunk** yang memukau.

Didesain sebagai alternatif ringan untuk aaPanel atau cPanel, khusus untuk pengguna VPS yang menginginkan performa maksimal dengan tampilan yang estetik.

---

## ✨ Fitur Utama

| Fitur | Deskripsi |
| :--- | :--- |
| 🎨 **Neon UI** | Antarmuka gelap futuristik dengan gradasi neon cyan & pink. |
| 📊 **Dashboard** | Monitoring server realtime (CPU, RAM, Disk, Load). |
| 🌐 **Website Manager** | Deploy website PHP/HTML dengan auto-config Nginx. |
| 📁 **File Manager** | Kelola file server langsung dari browser. |
| 🗄️ **Database** | Manajemen database MySQL/MariaDB yang mudah. |
| 💻 **Web Terminal** | Akses SSH terminal langsung dari panel. |
| 🔌 **Plugin System** | Arsitektur modular, mudah dikembangkan. |
| 🔒 **Security** | Isolasi user, RBAC (Role-Based Access Control). |

---

## 🖥️ Spesifikasi Sistem (System Requirements)

SherPanel dirancang agar ringan, namun untuk performa terbaik kami merekomendasikan:

**Sistem Operasi:**
*   ✅ Ubuntu 20.04 LTS
*   ✅ Ubuntu 22.04 LTS
*   *(Debian 11/12 untested but likely compatible)*

**Hardware Minimum:**
*   **CPU**: 1 Core
*   **RAM**: 1 GB (Disarankan 2 GB+)
*   **Disk**: 10 GB Free Space

**Software Dependencies (Diinstall Otomatis):**
*   Nginx
*   PHP 8.2
*   MariaDB / MySQL
*   Node.js 18
*   Composer

---

## 🚀 Instalasi (Otomatis)

Cara termudah untuk menginstall SherPanel di VPS Ubuntu baru (Fresh Install).

### 1. Masuk ke Server (SSH)
Login sebagai **root** ke server Anda.

### 2. Jalankan Perintah Installer
Copy dan paste perintah berikut:

```bash
git clone https://github.com/sherif1day-ux/Sherpanel.git /var/www/sherpanel
cd /var/www/sherpanel
chmod +x install.sh
./install.sh
```

### 3. Ikuti Petunjuk di Layar
Installer akan meminta beberapa informasi:
*   **Domain**: Masukkan domain panel (misal: `panel.domain.com`) atau tekan Enter untuk menggunakan IP.
*   **Admin Email**: Email untuk login (Default: `admin@sherpanel.com`).
*   **Password**: Password admin (Default: `password`).

☕ **Tunggu 3-5 menit**, installer akan menyiapkan semuanya untuk Anda.

---

## 🛠️ Instalasi Manual (Untuk Developer)

Jika Anda ingin mengembangkan SherPanel di local environment (Windows/Mac/Linux):

1.  **Clone Repository**
    ```bash
    git clone https://github.com/sherif1day-ux/Sherpanel.git
    cd Sherpanel
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Setup Environment**
    ```bash
    cp .env.example .env
    # Edit .env sesuaikan database (DB_DATABASE, DB_USERNAME, dll)
    ```

4.  **Generate Key & Database**
    ```bash
    php artisan key:generate
    php artisan migrate:fresh --seed
    ```

5.  **Jalankan (Development Mode)**
    ```bash
    npm run dev
    # Di terminal lain:
    php artisan serve
    ```

---

## 📖 Cara Penggunaan

Setelah instalasi selesai, buka browser dan akses URL panel Anda (IP atau Domain).

**Login Default:**
*   **Email**: `admin@sherpanel.com`
*   **Password**: `password`

*(⚠️ Harap segera ganti password setelah login pertama kali!)*

### Manajemen User
*   Login sebagai Admin.
*   Masuk ke menu **Users**.
*   Anda bisa menambahkan user baru. User biasa hanya bisa melihat website mereka sendiri.

---

## 🔌 Pengembangan Plugin

SherPanel mendukung sistem modul di direktori `app/Modules`.

1.  Buat folder `app/Modules/NamaPlugin`.
2.  Buat file `module.json`:
    ```json
    {
        "name": "Nama Plugin",
        "version": "1.0",
        "description": "Deskripsi plugin anda"
    }
    ```
3.  Plugin akan otomatis terdeteksi oleh sistem.

---

## 🤝 Berkontribusi

Kontribusi sangat diterima! Silakan fork repository ini dan buat Pull Request.

1.  Fork Project
2.  Buat Feature Branch (`git checkout -b feature/AmazingFeature`)
3.  Commit Changes (`git commit -m 'Add some AmazingFeature'`)
4.  Push ke Branch (`git push origin feature/AmazingFeature`)
5.  Open Pull Request

---

## 📄 Lisensi

Didistribusikan di bawah Lisensi MIT. Lihat `LICENSE` untuk informasi lebih lanjut.

---
*Dibuat dengan ❤️ oleh [Sherif1day]*
