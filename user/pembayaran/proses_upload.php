<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = (int) $_SESSION['id'];

if (!isset($_POST['booking_id'])) {
    die("Booking ID tidak ditemukan.");
}

$booking_id = (int) $_POST['booking_id'];

$cekBooking = mysqli_prepare(
    $conn,
    "SELECT id
     FROM booking
     WHERE id = ?
     AND user_id = ?"
);

mysqli_stmt_bind_param(
    $cekBooking,
    "ii",
    $booking_id,
    $user_id
);

mysqli_stmt_execute($cekBooking);

$hasil = mysqli_stmt_get_result($cekBooking);

if (mysqli_num_rows($hasil) == 0) {
    die("Booking tidak ditemukan atau bukan milik Anda.");
}

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