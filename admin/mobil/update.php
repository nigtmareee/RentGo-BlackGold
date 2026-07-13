<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = (int) $_POST['id'];

$nama_mobil = $_POST['nama_mobil'];
$merk = $_POST['merk'];
$tahun = $_POST['tahun'];
$plat_nomor = $_POST['plat_nomor'];
$warna = $_POST['warna'];
$transmisi = $_POST['transmisi'];
$bahan_bakar = $_POST['bahan_bakar'];
$kapasitas_penumpang = $_POST['kapasitas_penumpang'];
$harga_per_hari = $_POST['harga_per_hari'];

$sql = "
UPDATE mobil SET
    nama_mobil='$nama_mobil',
    merk='$merk',
    tahun='$tahun',
    plat_nomor='$plat_nomor',
    warna='$warna',
    transmisi='$transmisi',
    bahan_bakar='$bahan_bakar',
    kapasitas_penumpang='$kapasitas_penumpang',
    harga_per_hari='$harga_per_hari'
WHERE id='$id'
";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die('Error Update: ' . mysqli_error($conn));
}

header("Location: index.php");
exit;
?>
