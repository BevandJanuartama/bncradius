# 🌐 Borneo Network Center (BNC)

<div align="center">

**Modern Network Administration Solution Built on Laravel 12**

[![Laravel](https://img.shields.io/badge/Laravel-12.21.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)

</div>

---

## 📋 Overview

**Borneo Network Center (BNC)** is a comprehensive internal administration application designed to streamline customer data management, subscription services, and back-office operations. Built with the power of Laravel 12 and featuring a modern interface powered by Tailwind CSS.

The application follows Laravel's standard **Model-View-Controller (MVC)** architecture pattern, ensuring scalability and maintainable code structure.

---

## 🚀 Tech Stack

| Category | Technology | Version | Description |
|----------|-----------|---------|-------------|
| **Backend Framework** | Laravel | `12.21.0` | Leading PHP framework for web artisans |
| **Database** | MySQL | Latest | Robust relational database system |
| **Frontend Styling** | Tailwind CSS | `3.x` | Utility-first CSS framework |
| **Authentication** | Laravel Breeze | Latest | Official Laravel authentication scaffolding |
| **Package Management** | Composer & NPM | Latest | PHP and JavaScript dependency managers |

---

## 🖥️ System Requirements

Before installation, ensure your system meets Laravel's minimum server requirements:

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x & NPM >= 9.x
- **MySQL** >= 5.7 

📚 **Reference:** [Laravel Server Requirements](https://laravel.com/docs/12.x/deployment#server-requirements)

---

## ⚡ Quick Start Guide

Follow these steps to get BNC up and running on your local machine.

### 1️⃣ Clone & Install Dependencies

```bash
# Clone the repository
git clone https://github.com/BevandJanuartama/bncradius.git your-project-name

# Navigate to project directory
cd your-project-name

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2️⃣ Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

**⚙️ Configure your `.env` file:**

```env
APP_NAME="Borneo Network Center"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3️⃣ Database Setup

```bash
# Run database migrations
php artisan migrate

# Seed initial data
php artisan db:seed
```

### 4️⃣ Frontend Assets & Storage

```bash
# Compile frontend assets (development)
npm run dev

# For production build
# npm run build

# Create storage symbolic link
php artisan storage:link
```

### 5️⃣ Launch Application

```bash
# Start the development server
php artisan serve
```

🎉 **Access your application at:** [http://localhost:8000](http://localhost:8000)

---

## 👥 Default User Accounts

After seeding, the following test accounts are available:

| Phone (Username) | Name | Password | Role |
|-----------------|------|----------|------|
| `0801` | user | `user` | user |
| `0802` | admin | `admin` | admin |
| `0803` | administrator | `administrator` | administrator |
| `0804` | teknisi | `teknisi` | teknisi |
| `0805` | keuangan | `keuangan` | keuangan |
| `0806` | operator | `operator` | operator |


> ⚠️ **Security Note:** Change these default credentials immediately in production environments!

---

## 🛠️ Additional Commands

### Fresh Installation

Reset and reinstall the entire database:

```bash
# Drop all tables, re-migrate, and seed
php artisan migrate:fresh --seed
```

### Cache Management

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear
```

### Optimization (Production)

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

---

## 👨‍💻 Developer

** Muhammad Bevand Januartama**
- 💼 Software Engineer (Rekayasa Perangkat Lunak)
- 🏫 SMK Telkom Banjarbaru, Indonesia
- 🔗 GitHub: [@BevandJanuartama](https://github.com/BevandJanuartama)

---

## 📄 License

This project is proprietary software. All rights reserved.

---

## 📞 Support

If you encounter any issues or have questions, please:
- Open an issue on [GitHub Issues](https://github.com/BevandJanuartama/bncradius/issues)
- Contact the developer directly

---

<div align="center">

**Made with ❤️ in Banjarbaru, Indonesia**

⭐ **Star this repository if you find it helpful!**

</div>
