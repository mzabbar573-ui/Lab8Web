# Lab8Web
# Modul Praktikum 8: PHP dan Database MySQL (CRUD Data Barang)
Dibuat oleh:
[Nama Anda]
[NIM Anda]
Program Studi Teknik Informatika
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
**koneksi.php:**
```sql
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
<img width="1279" height="666" alt="koneksi" src="https://github.com/user-attachments/assets/0c4ac620-2850-4c12-9051-ae03668bdb8a" />

### 4. Menampilkan Data / Read (index.php)
File ini berfungsi untuk menampilkan data barang dari database ke dalam bentuk tabel HTML. Dilengkapi dengan link aksi untuk Mengubah dan Menghapus data.
**index.php:**
```sql
<?php
include("koneksi.php");

// query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Data Barang</title>
</head>
<body>
    <div class="container">
        <h1>Data Barang</h1>
        <div class="main">
             <p>
                <a href="tambah.php" class="btn-tambah">+ Tambah Barang</a>
            </p>
            <table>
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Katagori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php if($result): ?>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><img src="gambar/<?= $row['gambar'];?>" alt="<?= $row['nama'];?>"></td>
                <td><?= $row['nama'];?></td>
                <td><?= $row['kategori'];?></td>
                <td><?= $row['harga_beli'];?></td>
                <td><?= $row['harga_jual'];?></td>
                <td><?= $row['stok'];?></td>
                <td>
                    <a href="ubah.php?id=<?= $row['id_barang']; ?>">Ubah</a> |
                    <a href="hapus.php?id=<?= $row['id_barang']; ?>"
                       onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>
            <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>
```
<img width="1279" height="668" alt="index" src="https://github.com/user-attachments/assets/ee712130-271c-48e2-82c1-12d051d3de0d" />

### 5. Menambah Data / Create (tambah.php)
File ini berisi form HTML untuk menambahkan data barang baru. Form ini mendukung upload file gambar (enctype="multipart/form-data"). Data yang diinput akan diproses dan disimpan ke tabel data_barang.
**tambah.php:**
```sql
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

if (isset($_POST['submit']))
{
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    if ($file_gambar['error'] == 0)
    {
        $filename = str_replace(' ', '_',$file_gambar['name']);
        $destination = dirname(__FILE__) .'/gambar/' . $filename;
        if(move_uploaded_file($file_gambar['tmp_name'], $destination))
        {
            $gambar = 'gambar/' . $filename;
        }
    }
    $sql = 'INSERT INTO data_barang (nama, kategori,harga_jual, harga_beli, stok, gambar) ';
    $sql .= "VALUES ('{$nama}', '{$kategori}','{$harga_jual}', '{$harga_beli}', '{$stok}', '{$gambar}')";
    $result = mysqli_query($conn, $sql);
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Tambah Barang</title>
</head>
<body>
<div class="container">
    <h1>Tambah Barang</h1>
    <div class="main">
        <form method="post" action="tambah.php" enctype="multipart/formdata">
            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama" />
            </div>
            <div class="input">
                <label>Kategori</label>
                <select name="kategori">
                    <option value="Komputer">Komputer</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Hand Phone">Hand Phone</option>
                </select>
            </div>
            <div class="input">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" />
            </div>
            <div class="input">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" />
            </div>
            <div class="input">
                <label>Stok</label>
                <input type="text" name="stok" />
            </div>
            <div class="input">
                <label>File Gambar</label>
                <input type="file" name="file_gambar" />
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Simpan" />
            </div>
        </form>
    </div>
</div>
</body>
</html>
```
<img width="1279" height="669" alt="tambah barang" src="https://github.com/user-attachments/assets/138f7ed5-bcd4-476f-9ce6-4ab86f1949ea" />

### 6. Mengubah Data / Update (ubah.php)
File ini menampilkan form yang sudah terisi dengan data lama berdasarkan id_barang yang dipilih. Pengguna dapat mengubah informasi barang dan/atau mengganti file gambar. Script akan melakukan query UPDATE ke database.
**ubah.php**
```sql
<?php
error_reporting(E_ALL);
include_once 'koneksi.php';

if (isset($_POST['submit']))
{
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kategori = $_POST['kategori'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $file_gambar = $_FILES['file_gambar'];
    $gambar = null;
    
    if ($file_gambar['error'] == 0)
    {
        $filename = str_replace(' ', '_', $file_gambar['name']);
        $destination = dirname(__FILE__) . '/gambar/' . $filename;
        if (move_uploaded_file($file_gambar['tmp_name'], $destination))
        {
            $gambar = 'gambar/' . $filename;
        }
    }

    $sql = 'UPDATE data_barang SET ';
    $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
    $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}', stok = '{$stok}' ";
    if (!empty($gambar))         
        $sql .= ", gambar = '{$gambar}' ";
    $sql .= "WHERE id_barang = '{$id}'";
    $result = mysqli_query($conn, $sql);

    header('location: index.php');
    exit;
}


if (!isset($_GET['id'])) {
    die('Error: ID tidak ditemukan. Akses melalui tombol Ubah di index.php');
}

$id = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) die('Error: Data tidak tersedia');
$data = mysqli_fetch_array($result);

function is_select($var, $val) {
    if ($var == $val) return 'selected="selected"';
    return false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Ubah Barang</title>
</head>
<body>
<div class="container">
    <h1>Ubah Barang</h1>
    <div class="main">
        <form method="post" action="ubah.php" enctype="multipart/form-data">
            <div class="input">
                <label>Nama Barang</label>
                <input type="text" name="nama" value="<?php echo $data['nama'];?>" />
            </div>
            <div class="input">
                <label>Kategori</label> 
                <select name="kategori"> 
                    <option <?php echo is_select('Komputer', $data['kategori']);?> value="Komputer">Komputer</option>  
                    <option <?php echo is_select('Elektronik', $data['kategori']);?> value="Elektronik">Elektronik</option> 
                    <option <?php echo is_select('Hand Phone', $data['kategori']);?> value="Hand Phone">Hand Phone</option> 
                </select> 
            </div>
            <div class="input">
                <label>Harga Jual</label>
                <input type="text" name="harga_jual" value="<?php echo $data['harga_jual'];?>" />
            </div>
            <div class="input">
                <label>Harga Beli</label>
                <input type="text" name="harga_beli" value="<?php echo $data['harga_beli'];?>" />
            </div>
            <div class="input">
                <label>Stok</label>
                <input type="text" name="stok" value="<?php echo $data['stok'];?>" />
            </div>
            <div class="input">
                <label>File Gambar</label>
                <input type="file" name="file_gambar" />
            </div>
            <div class="submit">
                <input type="hidden" name="id" value="<?php echo $data['id_barang'];?>" />
                <input type="submit" name="submit" value="Simpan" />
            </div>
        </form>
    </div>
</div>
</body>
</html> 
```
<img width="1279" height="668" alt="ubah barang" src="https://github.com/user-attachments/assets/be7c85dc-0832-42ed-89de-ae1c43867ff4" />

### 7. Menghapus Data / Delete (hapus.php)
File ini menerima parameter id melalui URL ($_GET['id']), lalu menjalankan query DELETE untuk menghapus baris data tersebut dari database, dan mengalihkan halaman kembali ke index.php.
**hapus.php**
```sql
<?php
include_once 'koneksi.php';
$id = $_GET['id'];   // ← Error jika tidak ada parameter id
$sql = "DELETE FROM data_barang WHERE id_barang='{$id}'";
$result = mysqli_query($conn, $sql);
header('location: index.php');
?>
```
<img width="1279" height="667" alt="hapus" src="https://github.com/user-attachments/assets/9918d0eb-c4ca-4091-acba-f2dc6f371c2a" />

### 8. Styling Tampilan (style.css)
Menambahkan file style.css untuk mempercantik tampilan antarmuka (UI) dari halaman index.php, tambah.php, dan ubah.php. CSS ini mengatur tata letak container, tabel, form input, dan tombol agar lebih rapi dan responsif.
**style.css**
```sql
<?php
include_once 'koneksi.php';
$id = $_GET['id'];   // ← Error jika tidak ada parameter id
$sql = "DELETE FROM data_barang WHERE id_barang='{$id}'";
$result = mysqli_query($conn, $sql);
header('location: index.php');
?>
```
<img width="1279" height="667" alt="index css" src="https://github.com/user-attachments/assets/e2a1923d-a90a-4fee-839b-283dc5c84761" />
<img width="1279" height="667" alt="tambah barang css" src="https://github.com/user-attachments/assets/0a3ed445-a3b5-4955-bda3-7df74249a66e" />
<img width="1279" height="667" alt="tambah barang css" src="https://github.com/user-attachments/assets/d3c6fc3a-d393-4ede-97da-d8435863372f" />
<img width="1279" height="667" alt="tambah barang css" src="https://github.com/user-attachments/assets/3b9f7534-347d-4aad-836a-243600bb412f" />

### Struktur File
```
lab8_php_database/
│
├── gambar/                 
│   ├── hp_samsung.jpg
│   ├── hp_xiaomi.jpg
│   └── hp_oppo.jpg
│
├── koneksi.php
├── index.php
├── tambah.php
├── ubah.php
├── hapus.php
├── style.css
└── README.md
```
### Cara Menjalankan Aplikasi
Pastikan Apache dan MySQL di XAMPP Control Panel sudah dalam status Running.
Letakkan folder lab8_php_database di dalam direktori htdocs (contoh: C:\xampp\htdocs\lab8_php_database atau D:\xampp\htdocs\lab8_php_database).
Buka browser dan akses URL: http://localhost/lab8_php_database/
Pastikan folder gambar memiliki hak akses tulis (write permission) agar fitur upload gambar berfungsi dengan baik.
