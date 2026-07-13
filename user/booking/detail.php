<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_query(
    $conn,
    "SELECT booking.*, mobil.nama_mobil
     FROM booking
     JOIN mobil ON booking.mobil_id = mobil.id
     WHERE booking.id = $id"
);

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Booking tidak ditemukan.");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Detail Booking</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-5">

<h2>Detail Booking</h2>

<hr>

<table class="table table-bordered">

<tr>
<th>ID Booking</th>
<td><?= $data['id'] ?></td>
</tr>

<tr>
<th>Mobil</th>
<td><?= $data['nama_mobil'] ?></td>
</tr>

<tr>
<th>Tanggal Mulai</th>
<td><?= $data['tanggal_mulai'] ?></td>
</tr>

<tr>
<th>Tanggal Selesai</th>
<td><?= $data['tanggal_selesai'] ?></td>
</tr>

<tr>
<th>Total Hari</th>
<td><?= $data['total_hari'] ?> Hari</td>
</tr>

<tr>
<th>Total Harga</th>
<td>
Rp <?= number_format($data['total_harga'],0,',','.') ?>
</td>
</tr>

<tr>
<th>Status</th>
<td><?= $data['status'] ?></td>
</tr>

</table>

<a
href="riwayat.php"
class="btn btn-secondary">
Kembali
</a>

<?php if($data['status'] == 'Menunggu Pembayaran'): ?>

<a
href="../pembayaran/upload.php?booking_id=<?= $data['id'] ?>"
class="btn btn-success">
Upload Pembayaran
</a>

<?php endif; ?>

</div>

</body>
</html>