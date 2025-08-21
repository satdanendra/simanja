# 📊 SIMANJA - Sistem Informasi Manajemen Jadwal

## 🎓 **Informasi Skripsi**

| **Field** | **Detail** |
|-----------|------------|
| **NIM** | 222112354 |
| **Nama Mahasiswa** | Satrio Putyo Danendra |
| **Judul Skripsi** | Pembangunan Sistem Informasi Manajemen Tugas dan Pekerjaan (SiManja) BPS Kota Magelang |
| **Dosen Pembimbing** | Dr. Rindang Bangun Prasetyo, S.S.T., M.Si. |

---

## 📋 **Deskripsi Singkat**

**SiMantap** adalah sistem informasi berbasis web yang dirancang khusus untuk mengelola jadwal kegiatan statistik di BPS (Badan Pusat Statistik) Kota Magelang. Sistem ini memungkinkan manajemen yang efisien terhadap berbagai kegiatan survei statistik, alokasi pegawai, dan monitoring progress proyek statistik dengan interface yang user-friendly dan fitur yang komprehensif.

### 🎯 **Tujuan Utama**
- Mengoptimalkan pengelolaan jadwal kegiatan statistik
- Meningkatkan koordinasi antar tim dalam pelaksanaan survei
- Menyediakan dashboard monitoring real-time untuk keperluan manajemen
- Mendigitalkan proses administratif yang sebelumnya manual

### ✨ **Fitur Utama**
- 👥 **Manajemen Pegawai**: CRUD data pegawai dengan informasi lengkap
- 📊 **Manajemen Proyek**: Pengelolaan proyek statistik berdasarkan IKU (Indikator Kinerja Utama)
- 📅 **Penjadwalan**: Sistem penjadwalan kegiatan dengan alokasi SDM
- 📈 **Dashboard Analytics**: Visualisasi data dan progress monitoring
- 📄 **Export/Import**: Fitur export ke PDF dan import dari Excel
- 🔐 **Multi-role Authentication**: Sistem login dengan berbagai level akses
- 📱 **Responsive Design**: Interface yang optimal di berbagai device

---

## 🛠️ **Teknologi yang Digunakan**

### **Backend**
- **Framework**: Laravel 11.31 (PHP 8.2+)
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **API Integration**: Google Drive API

### **Frontend**
- **CSS Framework**: Tailwind CSS 3.1.0
- **JavaScript**: Alpine.js 3.4.2
- **Icons**: Various icon libraries
- **Build Tool**: Vite 6.0

### **Libraries & Dependencies**
- **Excel Processing**: PhpSpreadsheet, Maatwebsite Excel
- **PDF Generation**: TCPDF, FPDI
- **Cloud Storage**: Google Cloud Storage integration
- **Development Tools**: Laravel Pail, Laravel Sail

---

## 📁 **Struktur Folder Project**

```
simanja/
├── 📁 app/                          # Core aplikasi Laravel
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/          # Controller untuk logika bisnis
│   │   │   ├── MasterPegawaiController.php    # Manajemen data pegawai
│   │   │   ├── MasterDirektoratController.php # Manajemen direktorat
│   │   │   ├── ProyekController.php           # Manajemen proyek statistik
│   │   │   └── DashboardController.php        # Dashboard analytics
│   │   ├── 📁 Middleware/           # Middleware untuk autentikasi
│   │   └── 📁 Requests/             # Form request validation
│   ├── 📁 Models/                   # Eloquent models
│   │   ├── MasterPegawai.php        # Model data pegawai
│   │   ├── MasterProyek.php         # Model proyek statistik
│   │   ├── MasterDirektorat.php     # Model direktorat
│   │   └── User.php                 # Model user authentication
│   ├── 📁 Services/                 # Business logic services
│   └── 📁 Providers/                # Service providers
│
├── 📁 bootstrap/                    # Bootstrap Laravel
│   └── 📁 cache/                    # Cache file aplikasi
│
├── 📁 config/                       # Konfigurasi aplikasi
│   ├── app.php                      # Konfigurasi aplikasi utama
│   ├── database.php                 # Konfigurasi database
│   └── services.php                 # Konfigurasi service external
│
├── 📁 database/                     # Database related files
│   ├── 📁 migrations/               # Database migrations
│   ├── 📁 seeders/                  # Database seeders
│   └── 📁 factories/                # Model factories
│
├── 📁 public/                       # Public assets
│   ├── 📁 css/                      # Compiled CSS files
│   ├── 📁 js/                       # Compiled JavaScript files
│   ├── 📁 images/                   # Static images
│   └── index.php                    # Entry point aplikasi
│
├── 📁 resources/                    # Resources dan views
│   ├── 📁 views/                    # Blade templates
│   │   ├── 📁 layouts/              # Layout templates
│   │   ├── 📁 components/           # Reusable components
│   │   ├── 📁 dashboard/            # Dashboard views
│   │   ├── 📁 master-pegawai/       # Views manajemen pegawai
│   │   └── 📁 master-proyek/        # Views manajemen proyek
│   ├── 📁 css/                      # Source CSS files
│   └── 📁 js/                       # Source JavaScript files
│
├── 📁 routes/                       # Route definitions
│   ├── web.php                      # Web routes
│   ├── api.php                      # API routes
│   └── console.php                  # Artisan commands
│
├── 📁 storage/                      # Storage untuk files
│   ├── 📁 app/                      # Application storage
│   ├── 📁 framework/                # Framework storage
│   └── 📁 logs/                     # Application logs
│
├── 📁 tests/                        # Test files
│   ├── 📁 Feature/                  # Feature tests
│   └── 📁 Unit/                     # Unit tests
│
├── 📁 vendor/                       # Composer dependencies
│
├── .env.example                     # Environment configuration template
├── .gitignore                       # Git ignore file
├── artisan                          # Laravel Artisan CLI
├── composer.json                    # Composer dependencies
├── package.json                     # NPM dependencies
├── tailwind.config.js               # Tailwind CSS configuration
├── vite.config.js                   # Vite build configuration
└── README.md                        # This file
```

---

## 🚀 **Instalasi dan Setup**

### **Prerequisites**
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL/MariaDB
- Git

### **Langkah Instalasi**

1. **Clone Repository**
   ```bash
   git clone https://github.com/satdanendra/simanja.git
   cd simanja
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install
   
   # Install Node.js dependencies
   npm install
   ```

3. **Environment Setup**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

4. **Database Configuration**
   ```bash
   # Edit .env file dengan konfigurasi database Anda
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Database Migration & Seeding**
   ```bash
   # Run migrations
   php artisan migrate
   
   # Run seeders (optional)
   php artisan db:seed
   ```

6. **Build Assets**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run build
   ```

7. **Start Development Server**
   ```bash
   # Method 1: Laravel built-in server
   php artisan serve
   
   # Method 2: Using Laravel Sail (Docker)
   ./vendor/bin/sail up
   
   # Method 3: All services (recommended for development)
   composer dev
   ```

---

## 🔧 **Konfigurasi Tambahan**

### **Google Drive Integration**
```env
GOOGLE_DRIVE_CLIENT_ID=your_client_id
GOOGLE_DRIVE_CLIENT_SECRET=your_client_secret
GOOGLE_DRIVE_REFRESH_TOKEN=your_refresh_token
GOOGLE_DRIVE_FOLDER_ID=your_folder_id
```

## 📊 **Database Schema**

### **Tabel Utama**
- **master_pegawai**: Data pegawai BPS
- **master_proyek**: Data proyek statistik
- **master_direktorat**: Data direktorat/unit kerja
- **master_rk_tim**: Data rencana kerja tim
- **master_generic_activity**: Aktivitas generik
- **alokasi**: Alokasi pegawai ke proyek
- **users**: Data pengguna sistem

### **Relasi Utama**
- Pegawai ↔ Alokasi ↔ Proyek
- Proyek ↔ RK Tim ↔ Direktorat
- Generic Activity ↔ Proyek

---

## 🎨 **Fitur-Fitur Unggulan**

### **1. Dashboard Analytics** 📈
- Statistik pegawai aktif/non-aktif
- Progress proyek real-time
- Grafik alokasi SDM
- Summary kegiatan per direktorat

### **2. Manajemen Pegawai** 👥
- CRUD data pegawai lengkap
- Import/Export Excel
- Filter dan pencarian advanced
- Tracking status aktif/non-aktif

### **3. Manajemen Proyek** 📊
- Pengelolaan proyek berdasarkan IKU
- Alokasi anggota tim
- Tracking kegiatan lapangan
- Integration dengan Generic Activity

### **4. Export/Import System** 📄
- Export data ke PDF format
- Import data dari Excel/CSV
- Template download
- Validation data import

### **5. Responsive Design** 📱
- Mobile-first approach
- Tailwind CSS framework
- Alpine.js interactions
- Cross-browser compatibility

---

## 📞 **Contact & Support**

- **Developer**: [Satrio Putyo Danendra]
- **Email**: [222112354@stis.ac.id]
- **GitHub**: [@satdanendra](https://github.com/satdanendra)
- **Project Link**: [https://github.com/satdanendra/simanja](https://github.com/satdanendra/simanja)

---

**✨ Terima kasih telah menggunakan SIMANJA! ✨**
