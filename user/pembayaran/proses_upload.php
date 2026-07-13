<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_POST['booking_id'])) {
    die("Booking ID tidak ditemukan.");
}

$booking_id = (int) $_POST['booking_id'];

$metode = $_POST['metode'];
$jumlah = (float) $_POST['jumlah'];

if (!isset($_FILES['bukti'])) {
    die("File bukti transfer belum dipilih.");
}

$folder = '../../assets/uploads/pembayaran/';

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$nama_file =
    time() . "_" .
    basename($_FILES['bukti']['name']);

$tmp =
    $_FILES['bukti']['tmp_name'];

$upload = move_uploaded_file(
    $tmp,
    $folder . $nama_file
);

if (!$upload) {
    die("Upload bukti transfer gagal.");
}

/*
|--------------------------------------------------------------------------
| Simpan pembayaran
|--------------------------------------------------------------------------
*/

$sql = "
INSERT INTO pembayaran
(
    booking_id,
    metode_pembayaran,
    bukti_transfer,
    jumlah_bayar,
    status
)
VALUES
(
    '$booking_id',
    '$metode',
    '$nama_file',
    '$jumlah',
    'Menunggu Verifikasi'
)
";

$simpan = mysqli_query($conn, $sql);

if (!$simpan) {
    die(mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| Update status booking
|--------------------------------------------------------------------------
*/

mysqli_query(
    $conn,
    "UPDATE booking
    SET status='Menunggu Verifikasi'
    WHERE id='$booking_id'"
);

echo "
<script>
    alert('Bukti pembayaran berhasil diupload');
    window.location='../booking/riwayat.php';
</script>
";
exit;