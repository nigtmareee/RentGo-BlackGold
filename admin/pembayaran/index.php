<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT
        pembayaran.*,
        mobil.nama_mobil,
        users.nama
    FROM pembayaran
    JOIN booking
        ON pembayaran.booking_id = booking.id
    JOIN mobil
        ON booking.mobil_id = mobil.id
    JOIN users
        ON booking.user_id = users.id
    ORDER BY pembayaran.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

<h2>Verifikasi Pembayaran</h2>

<a href="../dashboard.php" class="btn btn-secondary mb-3">
    Kembali Dashboard
</a>

<table class="table table-bordered table-striped">

<tr>
    <th>No</th>
    <th>User</th>
    <th>Mobil</th>
    <th>Metode</th>
    <th>Jumlah</th>
    <th>Bukti</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php
$no = 1;
while($row = mysqli_fetch_assoc($data)):
?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama']; ?></td>

<td><?= $row['nama_mobil']; ?></td>

<td><?= $row['metode_pembayaran']; ?></td>

<td>
Rp <?= number_format($row['jumlah_bayar']); ?>
</td>

<td>
<a
href="/rentgo/assets/uploads/pembayaran/<?= $row['bukti_transfer']; ?>"
target="_blank"
class="btn btn-primary btn-sm"
>
Lihat Bukti
</a>
</td>

<td>

<?php if($row['status']=='Menunggu Verifikasi'): ?>

<span class="badge bg-warning text-dark">
Menunggu
</span>

<?php elseif($row['status']=='Diterima'): ?>

<span class="badge bg-success">
Diterima
</span>

<?php else: ?>

<span class="badge bg-danger">
Ditolak
</span>

<?php endif; ?>

</td>

<td>

<?php if($row['status']=='Menunggu Verifikasi'): ?>

<a
href="verifikasi.php?id=<?= $row['id']; ?>&aksi=terima"
class="btn btn-success btn-sm"
>
Terima
</a>

<a
href="verifikasi.php?id=<?= $row['id']; ?>&aksi=tolak"
class="btn btn-danger btn-sm"
>
Tolak
</a>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>