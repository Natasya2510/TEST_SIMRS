## 1. Cara Menjalankan Program

### 1.1 Download Project

Download repository atau clone project **SIMRS** dari GitHub.

### 1.2 Menempatkan Project

Copy folder **SIMRS** ke dalam: 
    C:\xampp\htdocs\
Sehingga menjadi: 
    C:\xampp\htdocs\SIMRS

### 1.3 Restore Database

Buka **SQL Server Management Studio (SSMS)**, kemudian restore database
menggunakan file **SIMRS.bak**.

### 1.4 Konfigurasi Database

Pastikan nama database adalah **SIMRS**. Apabila berbeda, sesuaikan pada file **koneksi.php**.

    $serverName = "LAPTOP-A14J2JIC\\SQLEXPRESS";
    $database = "SIMRS";

### 1.5 Menjalankan Aplikasi

1.  Pastikan service **SQL Server** aktif.
2.  Jalankan **Apache** pada XAMPP.
3.  Akses aplikasi melalui: http://localhost/SIMRS/dashboard.php

## 2. Cara Menggunakan Program

### 2.1 Dashboard

Halaman Dashboard menampilkan menu **Registrasi Pasien**, **Data Admin**, **Summary jumlah pasien berdasarkan poliklinik**, dan **List Registrasi Pasien**.

### 2.2 Registrasi Pasien

#### 2.2.1 Menambah Registrasi

1.  Klik **Registrasi Pasien**.
2.  Isi Nomor Rekam Medis, Nama Pasien, Jenis Kelamin, Tanggal Lahir, Poliklinik, dan Alamat.
3.  Nomor Pendaftaran, Kode Poliklinik, dan Tanggal Pendaftaran akan terisi otomatis.
4.  Klik **Simpan**.
5.  Sistem akan menyimpan data dan menampilkan notifikasi berhasil.

### 2.3 Data Admin

#### 2.3.1 Menambah Data

1.  Klik **Tambah Pasien**.
2.  Isi data pasien.
3.  Klik **Simpan**.

#### 2.3.2 Mengubah Data

1.  Klik **Edit** pada data pasien.
2.  Lakukan perubahan data.
3.  Klik **Update**.

#### 2.3.3 Menghapus Data

1.  Klik **Hapus** pada data pasien.
2.  Pilih **Ya** pada konfirmasi.
3.  Data akan dihapus dari database.

#### 2.3.4 Pencarian Data

Pencarian dapat dilakukan berdasarkan: 
- Nomor Pendaftaran 
- Nomor Rekam Medis 
- Nama Pasien

## 3. Teknologi yang Digunakan

- PHP Native
- Microsoft SQL Server
- SQL Server Management Studio (SSMS)
- PDO SQL Server Driver
- Bootstrap 5
- Bootstrap Icons
- SweetAlert2
- HTML5
- CSS3
- Visual Studio Code (VS Code)
- XAMPP