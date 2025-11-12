🌐 Borneo Network Center (BNC)

Solusi Administrasi Jaringan Modern Berbasis Laravel 12

Borneo Network Center (BNC) adalah sebuah aplikasi administrasi internal yang dibangun untuk mempermudah pengelolaan data pelanggan, manajemen langganan layanan, dan sistem administrasi back-office lainnya. Dibangun dengan kekuatan Laravel 12 dan antarmuka yang modern menggunakan Tailwind CSS.

🚀 Teknologi Utama (Tech Stack)

Aplikasi ini mengadopsi arsitektur Model-View-Controller (MVC) standar Laravel untuk skalabilitas dan pemeliharaan kode yang lebih baik.

Kategori

Teknologi

Versi

Catatan

Backend

Laravel Framework

12.21.0

Framework PHP terkemuka.

Database

MySQL

-

Database relasional yang solid.

Frontend

Tailwind CSS & JS

-

Desain utility-first yang cepat dan responsif.

Otentikasi

Laravel Breeze

-

Starter kit otentikasi resmi Laravel.

Package Mgt.

Composer & NPM

-

Untuk dependensi PHP dan Frontend.

🛠️ Persyaratan Sistem

Pastikan Anda telah memenuhi persyaratan server minimum yang direkomendasikan untuk menjalankan Laravel.

Lihat: Persyaratan Server Laravel

⬇️ Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek BNC di lingkungan lokal Anda.

1. Kloning Repositori & Instalasi

Buka Terminal/CMD Anda dan jalankan perintah berikut:

# Kloning repositori proyek
git clone [https://github.com/BevandJanuartama/bncradius.git](https://github.com/BevandJanuartama/bncradius.git) YourDirectoryName

# Masuk ke direktori proyek
cd YourDirectoryName

# Instal dependensi PHP dengan Composer
composer install

# Instal dependensi Frontend (Node.js/NPM)
npm install


2. Konfigurasi Lingkungan (.env)

Salin file contoh konfigurasi dan buat kunci aplikasi:

# Salin file .env.example menjadi .env
cp .env.example .env

# Generate kunci aplikasi Laravel yang unik
php artisan key:generate


⚠️ Penting: Buka file .env yang baru dibuat dan sesuaikan detail koneksi database Anda:

APP_URL=http://localhost:8000
DB_DATABASE=(-database anda-)
DB_USERNAME=root
DB_PASSWORD=


3. Setup Database

Jalankan migrasi untuk membuat tabel-tabel database, diikuti dengan seeder untuk mengisi data awal:

# Jalankan Migrasi Database
php artisan migrate

# Jalankan Seeder Database (membuat pengguna awal)
php artisan db:seed


Akun Pengguna Awal

Proses seeder akan otomatis membuat akun default dengan berbagai level. Gunakan akun berikut untuk login pertama kali:

Telepon (Username)

Nama

Password

Level

0803

administrator

administrator

administrator

0802

admin

admin

admin

0804

teknisi

teknisi

teknisi

0805

keuangan

keuangan

keuangan

0806

operator

operator

operator

0801

user

user

user

4. Kompilasi Frontend & Storage Link

Kompilasi aset Tailwind CSS dan buat tautan simbolis untuk penyimpanan berkas (file):

# Kompilasi aset frontend untuk pengembangan (development)
npm run dev

# Jika untuk produksi (production)
# npm run build

# Buat symbolic link untuk folder storage/app/public
php artisan storage:link


5. Jalankan Aplikasi

Jalankan server bawaan Laravel:

php artisan serve


Akses aplikasi di browser Anda: http://localhost:8000

🧹 Perintah Tambahan (Opsional)

Jika Anda perlu membersihkan database dan mengulang instalasi dari awal, gunakan perintah reset berikut:

# Hapus semua tabel, migrasi ulang, dan jalankan seeder
php artisan migrate:fresh --seed


👨‍💻 Kontributor

Proyek ini dikembangkan oleh:

Bevand Januartama

Software Engineer (Rekayasa Perangkat Lunak)

SMK Telkom Banjarbaru, Indonesia
