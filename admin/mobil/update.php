<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = (int) $_POST['id'];

$nama_mobil = mysqli_real_escape_string($conn, $_POST['nama_mobil']);
$merk = mysqli_real_escape_string($conn, $_POST['merk']);
$tahun = $_POST['tahun'];
$plat_nomor = mysqli_real_escape_string($conn, $_POST['plat_nomor']);
$warna = mysqli_real_escape_string($conn, $_POST['warna']);
$transmisi = mysqli_real_escape_string($conn, $_POST['transmisi']);
$bahan_bakar = mysqli_real_escape_string($conn, $_POST['bahan_bakar']);
$kapasitas_penumpang = $_POST['kapasitas_penumpang'];
$harga_per_hari = $_POST['harga_per_hari'];

$gambar = $_POST['gambar_lama'];

/*
|--------------------------------------------------------------------------
| Upload Gambar Baru
|--------------------------------------------------------------------------
*/

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

    $folder = "../../assets/img/mobil/";

    $namaFile = $_FILES['gambar']['name'];
    $tmpFile  = $_FILES['gambar']['tmp_name'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $allowed = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allowed)) {
        die("Format gambar tidak didukung.");
    }

    $namaBaru = uniqid("mobil_") . "." . $ext;

    if (move_uploaded_file($tmpFile, $folder . $namaBaru)) {

        if (!empty($gambar) && file_exists($folder . $gambar)) {
            unlink($folder . $gambar);
        }

        $gambar = $namaBaru;
    }
}

/*
|--------------------------------------------------------------------------
| Update Database
|--------------------------------------------------------------------------
*/

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
harga_per_hari='$harga_per_hari',
gambar='$gambar'

WHERE id='$id'

";

$query = mysqli_query($conn, $sql);

if (!$query) {
    die('Error Update: ' . mysqli_error($conn));
}

header("Location: index.php");
exit;

?>