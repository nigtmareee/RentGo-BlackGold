<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    die("Silakan login terlebih dahulu.");
}

$user_id  = (int)$_SESSION['id'];
$mobil_id = (int)$_POST['mobil_id'];

$no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

$tanggal_mulai    = $_POST['tanggal_mulai'];
$tanggal_selesai  = $_POST['tanggal_selesai'];

/* Update profil user */
mysqli_query($conn,"
UPDATE users
SET
    no_hp='$no_hp',
    alamat='$alamat'
WHERE id='$user_id'
");

/* Ambil data mobil */
$queryMobil = mysqli_query($conn,"
SELECT *
FROM mobil
WHERE id='$mobil_id'
");

$mobil = mysqli_fetch_assoc($queryMobil);

if(!$mobil){
    die("Mobil tidak ditemukan.");
}

/*
|--------------------------------------------------------------------------
| CEK STATUS MOBIL
|--------------------------------------------------------------------------
| Mobil hanya boleh dibooking jika status = Tersedia
*/

if(trim($mobil['status']) != 'Tersedia'){

    echo "<script>
    alert('Mobil sedang tidak tersedia.');
    window.location='../mobil/index.php';
    </script>";
    exit;
}

/* Hitung lama sewa */

$mulai    = strtotime($tanggal_mulai);
$selesai  = strtotime($tanggal_selesai);

$total_hari = ceil(($selesai-$mulai)/86400);

if($total_hari<=0){

    echo "<script>
    alert('Tanggal selesai harus lebih besar dari tanggal mulai.');
    history.back();
    </script>";
    exit;
}

$total_harga = $total_hari * $mobil['harga_per_hari'];

$diskon = 0;

if($total_hari >= 3){
    $diskon = $total_harga * 0.10;
}

$total_bayar = $total_harga - $diskon;

/*
|--------------------------------------------------------------------------
| SIMPAN BOOKING
|--------------------------------------------------------------------------
*/

$simpan = mysqli_query($conn,"
INSERT INTO booking
(
user_id,
mobil_id,
tanggal_mulai,
tanggal_selesai,
total_hari,
total_harga,
diskon,
status
)
VALUES
(
'$user_id',
'$mobil_id',
'$tanggal_mulai',
'$tanggal_selesai',
'$total_hari',
'$total_bayar',
'$diskon',
'Menunggu Pembayaran'
)
");

if(!$simpan){
    die(mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| PENTING !!
|--------------------------------------------------------------------------
| JANGAN mengubah status mobil di sini.
|
| Mobil tetap 'Tersedia' sampai Admin
| menerima pembayaran.
|
| Status mobil baru berubah menjadi
| 'Disewa' di:
| admin/pembayaran/verifikasi.php
|--------------------------------------------------------------------------
*/

/* Redirect */

echo "<script>

alert(
'Booking berhasil dibuat!\n\n'+
'Status : Menunggu Pembayaran\n'+
'Silakan upload bukti pembayaran.'
);

window.location='riwayat.php';

</script>";

exit;
