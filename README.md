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

Import file `Tes Udinus New.postman_collection.json` pada Postman anda.
Tata cara untuk mengakses endpoint berikut:

### 🔐 Login

**POST** `/api/login`

#### Body (x-www-form-urlencoded / JSON):

| Field      | Type | Contoh         |
| ---------- | ---- | -------------- |
| `nim`      | text | A11.2022.09434 |
| `password` | text | 12345678       |

### Responses
```
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzUyNzMwMTk2LCJleHAiOjE3NTI3MzM3OTYsIm5iZiI6MTc1MjczMDE5NiwianRpIjoiWEpQMklKQ1VFYU5Ta3VzciIsInN1YiI6IjEiLCJwcnYiOiI3ZTdhMWIyZDE0NDQ4YTY2NDZlZDU0ZjMyNWNiMDg5MTE3Y2U5OGUzIn0.GfNmxKntSfGK3ZCg7RC5e2eKtSPX2W6IBlMKrp4cD2M",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### 🔓 Logout

**POST** `/api/logout`

Gunakan header berikut:

```
Authorization: Bearer {token}
```
### Responses
```
{
    "status": "success",
    "message": "Logout berhasil"
}
```

### 📚 Lihat KRS Mahasiswa Saat Ini

**GET** `/api/v1/students/{nim}/krs/current`

Gunakan header berikut:

```
Authorization: Bearer {token}
```

Catatan

```
Rubah {nim} jadi A11.2022.09434
```

### Responses
```
{
    "success": true,
    "message": "Success",
    "data": {
        "krs_record": [
            {
                "id": 3991974,
                "ta": "20241",
                "kdmk": "A11.64405",
                "id_jadwal": 275457,
                "nim_dinus": "b08df36d75bdaba20d68c50da73f5aa0",
                "sts": "B",
                "sks": 3,
                "modul": 0,
                "allow_uji": 0,
                "jadwal_tawar": {
                    "id": 275457,
                    "ta": 20232,
                    "kdmk": "A11.64405",
                    "klpk": "A11.4404",
                    "klpk_2": null,
                    "kdds": 1008,
                    "kdds2": 0,
                    "jmax": 40,
                    "jsisa": 40,
                    "id_hari1": 4,
                    "id_hari2": 0,
                    "id_hari3": 0,
                    "id_sesi1": 12,
                    "id_sesi2": 0,
                    "id_sesi3": 0,
                    "id_ruang1": 467,
                    "id_ruang2": 0,
                    "id_ruang3": 0,
                    "jns_jam": 3,
                    "open_class": 1
                },
                "matkul_kurikulum": {
                    "kur_id": 125,
                    "kdmk": "A11.64405",
                    "nmmk": "PEMBELAJARAN MESIN",
                    "nmen": "Machine Learning",
                    "tp": "T",
                    "sks": 3,
                    "sks_t": 3,
                    "sks_p": 0,
                    "smt": 4,
                    "jns_smt": 2,
                    "aktif": 1,
                    "kur_nama": "Z11.KUR.2021/2022",
                    "kelompok_makul": "MKK",
                    "kur_aktif": 1,
                    "jenis_matkul": "wajib"
                }
            },
            {
                "id": 3991977,
                "ta": "20241",
                "kdmk": "A11.64201",
                "id_jadwal": 275233,
                "nim_dinus": "b08df36d75bdaba20d68c50da73f5aa0",
                "sts": "B",
                "sks": 3,
                "modul": 0,
                "allow_uji": 0,
                "jadwal_tawar": {
                    "id": 275233,
                    "ta": 20232,
                    "kdmk": "A11.64201",
                    "klpk": "A11.4202",
                    "klpk_2": null,
                    "kdds": 1613,
                    "kdds2": 0,
                    "jmax": 40,
                    "jsisa": 39,
                    "id_hari1": 3,
                    "id_hari2": 0,
                    "id_hari3": 0,
                    "id_sesi1": 2,
                    "id_sesi2": 0,
                    "id_sesi3": 0,
                    "id_ruang1": 464,
                    "id_ruang2": 0,
                    "id_ruang3": 0,
                    "jns_jam": 3,
                    "open_class": 1
                },
                "matkul_kurikulum": {
                    "kur_id": 130,
                    "kdmk": "A11.64201",
                    "nmmk": "MATRIKS DAN RUANG VEKTOR ",
                    "nmen": "Matrices and Vector Spaces",
                    "tp": "T",
                    "sks": 3,
                    "sks_t": 3,
                    "sks_p": 0,
                    "smt": 2,
                    "jns_smt": 2,
                    "aktif": 1,
                    "kur_nama": "A11.KUR.2023/2024",
                    "kelompok_makul": "MKK",
                    "kur_aktif": 1,
                    "jenis_matkul": "wajib"
                }
            }
        ]
    }
}
```

### 📋 Daftar Mata Kuliah Tersedia

**GET** `/api/v1/students/{nim}/courses/available`

Gunakan header berikut:

```
Authorization: Bearer {token}
```

Catatan

```
Rubah {nim} jadi A11.2022.09434
```

### ➕ Tambah Mata Kuliah KRS

**POST** `/api/v1/students/{nim}/krs/courses`

Gunakan header berikut:

```
Authorization: Bearer {token}
```

Catatan

```
Rubah {nim} jadi A11.2022.09434
```

#### Body:

| Field       | Type | Contoh |
| ----------- | ---- | ------ |
| `id_jadwal` | text | 275233 |

### ❌ Hapus Mata Kuliah dari KRS

**DELETE** `/api/v1/students/{nim}/krs/courses/{id_jadwal}`

Gunakan header berikut:

```
Authorization: Bearer {token}
```

Catatan

```
Rubah {nim} jadi A11.2022.09434
```

### 📘 Status KRS Mahasiswa

**GET** `/api/v1/students/{nim}/krs/status`

Gunakan header berikut:

```
Authorization: Bearer {token}
```

Catatan

```
Rubah {nim} jadi A11.2022.09434
```

## 🧑‍💻 Kontributor

- Radhitya Kusuma Perkasa - Pengembang Utama

## 📄 Lisensi

Proyek ini berada di bawah lisensi MIT.
