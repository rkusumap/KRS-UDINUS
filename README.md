# KRS UDINUS API

Sistem Kartu Rencana Studi (KRS) Mahasiswa berbasis Laravel REST API.

## ✅ Persyaratan

- PHP **8.3**
- MySQL **5.7+ / 8.0+**
- Composer versi terbaru sudah terinstall

## 🛠️ Instalasi

1. **Clone repository ini**

   ```bash
   git clone https://github.com/username/krs-udinus.git
   cd krs-udinus
   ```

2. **Copy file environment**

   ```bash
   cp .env.example .env
   ```

3. \*\*Atur konfigurasi database di \*\*\`\`

   ```dotenv
   DB_DATABASE=krs_udinus
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. **Install dependency Laravel**

   ```bash
   composer install
   ```

5. **Import database**

   - Import file `krs_udinus.sql` ke database MySQL Anda menggunakan phpMyAdmin atau command line:
     ```bash
     mysql -u root -p krs_udinus < krs_udinus.sql
     ```

6. **Generate application key**

   ```bash
   php artisan key:generate
   ```

7. **Jalankan server lokal**

   ```bash
   php artisan serve
   ```

## 🚀 API Usage

Gunakan tools seperti Postman, curl, atau HTTP client lainnya untuk mengakses endpoint berikut:

### 🔐 Login

**POST** `/api/login`

#### Body (x-www-form-urlencoded / JSON):

| Field      | Type | Contoh         |
| ---------- | ---- | -------------- |
| `nim`      | text | A11.2022.09434 |
| `password` | text | 12345678       |

### 🔓 Logout

**POST** `/api/logout`

Gunakan header berikut:

```
Authorization: Bearer {token}
```

### 📚 Lihat KRS Mahasiswa Saat Ini

**GET** `/api/v1/students/{nim}/krs/current`

### 📋 Daftar Mata Kuliah Tersedia

**GET** `/api/v1/students/{nim}/courses/available`

### ➕ Tambah Mata Kuliah KRS

**POST** `/api/v1/students/{nim}/krs/courses`

#### Body:

| Field       | Type | Contoh |
| ----------- | ---- | ------ |
| `id_jadwal` | text | 275233 |

### ❌ Hapus Mata Kuliah dari KRS

**DELETE** `/api/v1/students/{nim}/krs/courses/{id_jadwal}`

### 📘 Status KRS Mahasiswa

**GET** `/api/v1/students/{nim}/krs/status`

## 🧑‍💻 Kontributor

- [Nama Kamu] - Pengembang Utama

## 📄 Lisensi

Proyek ini berada di bawah lisensi MIT.
