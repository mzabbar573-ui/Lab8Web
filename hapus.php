<?php
include_once 'koneksi.php';
$id = $_GET['id'];   // ← Error jika tidak ada parameter id
$sql = "DELETE FROM data_barang WHERE id_barang='{$id}'";
$result = mysqli_query($conn, $sql);
header('location: index.php');
?>