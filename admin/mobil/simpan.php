<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

// ==============================
// Ambil Data Form
// ==============================

$nama_mobil = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
$merk = mysqli_real_escape_string($conn, $_POST['merk']);
$tahun = $_POST['tahun'];
$plat_nomor = mysqli_real_escape_string($conn, $_POST['plat_nomor']);
$warna = mysqli_real_escape_string($conn, $_POST['warna']);
$transmisi = mysqli_real_escape_string($conn, $_POST['transmisi']);
$bahan_bakar = mysqli_real_escape_string($conn, $_POST['bahan_bakar']);
$kapasitas_penumpang = $_POST['kapasitas_penumpang'];
$harga_per_hari = $_POST['harga_per_hari'];

// ==============================
// Upload Gambar
// ==============================

$gambar = "";

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

    $folder = "../../assets/img/mobil/";

    $namaFile = $_FILES['gambar']['name'];
    $tmpFile  = $_FILES['gambar']['tmp_name'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allowed)) {
        die("Format gambar tidak didukung.");
    }

    $gambar = uniqid('mobil_') . "." . $ext;

    move_uploaded_file($tmpFile, $folder . $gambar);
}

// ==============================
// Simpan Database
// ==============================

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
harga_per_hari,
gambar

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
'$harga_per_hari',
'$gambar'

)

");

// ==============================
// Redirect
// ==============================

if($query){

    header("Location: index.php");
    exit;

}else{

    die(mysqli_error($conn));

}

?>