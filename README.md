# 🎫 TIXEVENT - Event Ticketing Platform with Smart Queue System

![Laravel](https://img.shields.io/badge/Laravel-11.x%20%2F%2012.x-red?style=for-the-badge\&logo=laravel)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v3.x-blue?style=for-the-badge\&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.x-orange?style=for-the-badge\&logo=mysql)

TIXEVENT adalah platform manajemen dan penjualan tiket acara (*event ticketing platform*) berbasis web yang dirancang untuk mengoptimalkan proses transaksi antara Admin, Event Organizer, dan Pengguna. Fitur unggulan dari platform ini adalah **Smart Waiting List & Queue Automation System**, yang membantu mengatasi masalah kehabisan tiket pada event dengan tingkat permintaan tinggi melalui sistem antrean otomatis yang adil dan terstruktur.

---

# 📌 Project Overview

Sistem ini menyediakan manajemen tiket secara end-to-end yang mencakup:

### 1. Multi-Role Access Management

Memisahkan hak akses berdasarkan peran pengguna:

* **Admin** → Mengelola event, kategori, dan data pengguna.
* **Organizer** → Mengelola tiket, kuota, dan waiting list.
* **User** → Membeli tiket dan bergabung ke daftar tunggu.

### 2. Dynamic Ticket Quota Control

Organizer dapat menambah kuota tiket kapan saja apabila kapasitas acara ditingkatkan.

### 3. FIFO Queue System

Menggunakan prinsip **First In First Out (FIFO)** untuk menjaga keadilan antrean ketika tiket habis terjual.

### 4. Automated Email Notification

Sistem mengirimkan email otomatis menggunakan Mailtrap kepada pengguna yang berada di urutan teratas waiting list ketika tiket tersedia kembali.

---

# ⚙️ Technologies Used

| Technology            | Description                |
| --------------------- | -------------------------- |
| Laravel               | Backend Framework          |
| PHP                   | Programming Language       |
| MySQL                 | Database Management System |
| Tailwind CSS          | Frontend Styling           |
| Mailtrap              | Email Testing Service      |
| Blade Template Engine | Laravel View Engine        |

---

# 🚀 Installation & Local Setup

## 1. Clone Repository

```bash
git clone https://github.com/USERNAME/TIXEVENT.git
cd TIXEVENT
```

## 2. Install Dependencies

```bash
composer install
npm install
npm run dev
```

## 3. Configure Environment File

Salin file `.env.example` menjadi `.env`

```bash
cp .env.example .env
```

Kemudian sesuaikan konfigurasi database dan Mailtrap pada file `.env`.

### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tixevent_db
DB_USERNAME=root
DB_PASSWORD=
```

### Mailtrap Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=YOUR_MAILTRAP_USERNAME
MAIL_PASSWORD=YOUR_MAILTRAP_PASSWORD
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@tixevent.com
MAIL_FROM_NAME="TIXEVENT"
```

Generate application key:

```bash
php artisan key:generate
```

---

## 4. Database Migration & Seeding

Buat database bernama:

```sql
tixevent_db
```

Kemudian jalankan:

```bash
php artisan migrate --seed
```

---

## 5. Run Application

```bash
php artisan config:clear
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

# 🔍 Main Features

## Event Management

* Membuat event baru
* Mengubah data event
* Menghapus event
* Menampilkan detail event

## Ticket Management

* Menambah jenis tiket
* Mengatur harga tiket
* Mengatur kuota tiket
* Memantau tiket terjual

## Waiting List System

* User dapat bergabung ke waiting list ketika tiket habis.
* Sistem menyimpan urutan antrean secara otomatis.
* Organizer dapat memanggil pengguna teratas ketika kuota tersedia.

## Email Notification

* Mengirim email otomatis kepada pengguna yang dipanggil.
* Berisi informasi event dan link pembelian tiket.

---

# 🧠 Smart Queue Workflow

```text
Tiket Sold Out (Quota = 0)
            │
            ▼
User Klik "Masuk Daftar Tunggu"
            │
            ▼
Data Disimpan ke waiting_lists
(Status = waiting)
            │
            ▼
Organizer Menambah Kuota Tiket
            │
            ▼
Organizer Klik "Panggil"
            │
            ▼
Sistem Mengirim Email Notifikasi
(Status = notified)
            │
            ▼
User Membeli Tiket
            │
            ▼
Status Menjadi "done"
```

---

# 💾 Database Schema Overview

## users

Menyimpan data akun dan hak akses pengguna.

| Field    | Type                         |
| -------- | ---------------------------- |
| id       | bigint                       |
| name     | varchar                      |
| email    | varchar                      |
| password | varchar                      |
| role     | enum(admin, organizer, user) |

---

## events

Menyimpan informasi acara.

| Field       | Type     |
| ----------- | -------- |
| id          | bigint   |
| title       | varchar  |
| description | text     |
| location    | varchar  |
| event_date  | datetime |
| banner      | varchar  |

---

## ticket_types

Menyimpan data jenis tiket.

| Field         | Type    |
| ------------- | ------- |
| id            | bigint  |
| event_id      | bigint  |
| name          | varchar |
| price         | decimal |
| quota         | integer |
| sold_quantity | integer |

---

## waiting_lists

Menyimpan data antrean pengguna.

| Field      | Type                          |
| ---------- | ----------------------------- |
| id         | bigint                        |
| user_id    | bigint                        |
| event_id   | bigint                        |
| status     | enum(waiting, notified, done) |
| created_at | timestamp                     |

---

# 🎯 Results and Conclusion

TIXEVENT berhasil mengimplementasikan sistem penjualan tiket yang terintegrasi dengan fitur waiting list otomatis untuk menangani kondisi tiket habis (*sold out*).

Melalui penerapan sistem antrean FIFO dan notifikasi email otomatis, proses distribusi tiket menjadi lebih transparan, adil, dan efisien. Selain itu, organizer memiliki fleksibilitas untuk menambah kuota tiket tanpa mengganggu integritas data maupun urutan antrean pengguna.

