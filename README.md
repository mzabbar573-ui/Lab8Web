# Lab8Web
# Modul Praktikum 8: PHP dan Database MySQL (CRUD Data Barang)
## Persiapan & Prasyarat
- **XAMPP** (Apache dan MySQL Server sudah terinstal dan berjalan).
- **Text Editor** (misalnya: VSCode).
- **Web Browser** (Chrome, Firefox, Edge, dll).

---

## Langkah-Langkah Praktikum & Penjelasan

### 1. Persiapan Database
Menjalankan MySQL Server melalui XAMPP Control Panel dan mengakses phpMyAdmin di `http://localhost/phpmyadmin/`.

**Query Pembuatan Database dan Tabel:**
```sql
CREATE DATABASE latihan1;

USE latihan1;

CREATE TABLE data_barang(
    id_barang int(10) auto_increment Primary Key, 
    kategori varchar(30), 
    nama varchar(30), 
    gambar varchar(100), 
    harga_beli decimal(10,0), 
    harga_jual decimal(10,0),
    stok int(4)
);

INSERT INTO data_barang(kategori, nama, gambar, harga_beli, harga_jual, stok)
VALUES
('Elektronik','HP Samsung Android','hp_samsung.jpg', 2000000, 2400000, 5), 
('Elektronik','HP Xiaomi Android','hp_xiaomi.jpg', 1000000, 1400000, 5), 
('Elektronik','HP OPPO Android','hp_oppo.jpg', 1800000, 2300000, 5);
```
<img width="1279" height="665" alt="create table" src="https://github.com/user-attachments/assets/1b324ef3-90ca-4588-aa4b-2f99d1e0e8dc" />
<img width="1279" height="665" alt="insert values" src="https://github.com/user-attachments/assets/463c40d1-de18-405f-a739-2e3f79178079" />
<img width="1279" height="666" alt="database" src="https://github.com/user-attachments/assets/a2a00280-2555-453a-8fad-866913b5909f" />
<img width="1279" height="667" alt="php database" src="https://github.com/user-attachments/assets/dcdbd64e-e69a-4829-b50d-58495f13d5fe" />

### 2. Pembuatan Folder Proyek
Membuat folder baru bernama lab8_php_database di dalam direktori root web server (htdocs). Di dalam folder ini, dibuat juga sub-folder gambar untuk menyimpan file upload gambar barang.

### 3. Koneksi Database (koneksi.php)
Membuat file koneksi.php untuk menghubungkan aplikasi PHP dengan database MySQL latihan1.
```
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "latihan1";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn == false)
{
    echo "Koneksi ke server gagal.";
    die();
} 

else echo "Koneksi berhasil";
?>
```
