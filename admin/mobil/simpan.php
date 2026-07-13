<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */


$nama_mobil = $_POST['nama_mobil'];
$merk = $_POST['merk'];
$tahun = $_POST['tahun'];
$plat_nomor = $_POST['plat_nomor'];
$warna = $_POST['warna'];
$transmisi = $_POST['transmisi'];
$bahan_bakar = $_POST['bahan_bakar'];
$kapasitas_penumpang = $_POST['kapasitas_penumpang'];
$harga_per_hari = $_POST['harga_per_hari'];

$query = mysqli_query($conn, "
INSERT INTO mobil (
    nama_mobil,
    merk,
    tahun,
    plat_nomor,
    warna,
    transmisi,
    bahan_bakar,
    kapasitas_penumpang,
    harga_per_hari
)
VALUES (
    '$nama_mobil',
    '$merk',
    '$tahun',
    '$plat_nomor',
    '$warna',
    '$transmisi',
    '$bahan_bakar',
    '$kapasitas_penumpang',
    '$harga_per_hari'
)
");

if($query){
    header('Location: index.php');
    exit;
}else{
    die(mysqli_error($conn));
}