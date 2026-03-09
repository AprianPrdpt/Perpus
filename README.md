# 📚 Aplikasi Perpustakaan - PHP Native

Aplikasi Perpustakaan adalah sistem manajemen perpustakaan berbasis **PHP Native + MySQL** yang memungkinkan admin dan user mengelola data buku, peminjaman, serta pengembalian buku secara mudah melalui antarmuka web yang modern.

---

# 🚀 Fitur Utama

## 👤 Authentication
- Login
- Register
- Logout
- Role User & Admin

## 👨‍💼 Admin
Admin memiliki akses penuh terhadap sistem:

- Dashboard statistik
- CRUD Buku
- CRUD User
- Manajemen Peminjaman
- Manajemen Pengembalian
- Edit profil

## 👥 User
User dapat melakukan:

- Melihat dashboard
- Mencari buku
- Melihat histori peminjaman
- Mengedit profil

## 🔍 Pencarian Buku
- Search buku secara **realtime menggunakan AJAX**

---

# 🏗️ Struktur Project
nemo/
│
├── assets/
│ └── images/ # Cover buku
│
├── config/
│ └── database.php
│
├── includes/
│ ├── navbar.php
│ ├── sidebar.php
│ └── footer.php
│
├── pages/
│ ├── admin/
│ │ ├── dashboard.php
│ │ ├── buku.php
│ │ ├── user.php
│ │ ├── peminjaman.php
│ │ └── pengembalian.php
│ │
│ ├── user/
│ │ ├── dashboard.php
│ │ └── history.php
│ │
│ ├── login.php
│ ├── register.php
│ ├── search.php
│ ├── profil.php
│ └── home.php
│
├── proses/ # Logic proses CRUD
│ ├── login.php
│ ├── register.php
│ ├── buku_tambah.php
│ ├── buku_edit.php
│ ├── buku_hapus.php
│ ├── user_tambah.php
│ ├── user_edit.php
│ ├── user_hapus.php
│ ├── peminjaman_tambah.php
│ ├── peminjaman_edit.php
│ ├── peminjaman_kembali.php
│ └── ajax_search.php
│
├── library.sql
│
└── index.php

---

## 🛠️ Teknologi yang Digunakan

- PHP Native
- MySQL
- Bootstrap
- JavaScript
- AJAX
- HTML5
- CSS3

## 📊 Fitur Dashboard
Admin dapat melihat statistik seperti:

- Total Buku
- Total User
- Total Peminjaman
- Total Pengembalian

## 🔐 Role Sistem

| Role  | Akses                              |
|-------|------------------------------------|
| Admin | Mengelola seluruh sistem           |
| User  | Melihat buku & histori peminjaman  |

