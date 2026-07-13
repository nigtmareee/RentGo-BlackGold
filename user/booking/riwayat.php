<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$user_id = $_SESSION['id'];

$data = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        mobil.nama_mobil
    FROM booking
    JOIN mobil
        ON booking.mobil_id = mobil.id
    WHERE booking.user_id='$user_id'
    ORDER BY booking.id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Riwayat Booking - RentGo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{
    --gold:#d4af37;
    --dark:#050505;
    --card:#111111;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:var(--dark);
    color:white;
}

/* HERO */

.hero{

    min-height:40vh;

    display:flex;
    align-items:center;

    text-align:center;

    background:
    linear-gradient(
        rgba(0,0,0,.78),
        rgba(0,0,0,.78)
    ),
    url('../../assets/img/hero.jpg');

    background-size:cover;
    background-position:center;
}

.hero h1{

    font-size:60px;

    font-weight:900;
}

.hero span{
    color:var(--gold);
}

.hero p{
    color:#ddd;
}

/* CARD */

.table-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:25px;

    padding:30px;

    overflow:hidden;
}

/* TABLE */

.table{
    color:white;
}

.table thead{
    background:#1a1a1a;
}

.table tbody tr{
    border-color:#222;
}

.table tbody tr:hover{
    background:#181818;
}

/* BUTTON */

.btn-gold{

    background:var(--gold);

    color:#000;

    border:none;

    font-weight:700;
}

.btn-gold:hover{

    background:#c79d1c;

    color:#000;
}

.section{
    padding:80px 0;
}

</style>

</head>

<body>

<section class="hero">

<div class="container">

<h1>

Riwayat <span>Booking</span>

</h1>

<p>

Pantau seluruh aktivitas rental mobil Anda bersama RentGo

</p>

<a
href="../dashboard.php"
class="btn btn-warning mt-3"
>

← Dashboard

</a>

</div>

</section>

<section class="section">

<div class="container">

<div class="table-card">

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No</th>
<th>Mobil</th>
<th>Periode Rental</th>
<th>Total Hari</th>
<th>Total Harga</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php
$no = 1;
while ($row = mysqli_fetch_assoc($data)):
?>

<tr>

<td><?= $no++; ?></td>

<td>

<strong>

<?= htmlspecialchars($row['nama_mobil']); ?>

</strong>

</td>

<td>

<?= $row['tanggal_mulai']; ?>

<br>

s/d

<br>

<?= $row['tanggal_selesai']; ?>

</td>

<td>

<?= $row['total_hari']; ?>

Hari

</td>

<td>

<span style="color:#d4af37;font-weight:800;">

Rp <?= number_format(
    $row['total_harga'],
    0,
    ',',
    '.'
); ?>

</span>

</td>

<td>

<?php if($row['status'] == 'Menunggu Pembayaran'): ?>

<span class="badge bg-warning text-dark">
Menunggu Pembayaran
</span>

<?php elseif($row['status'] == 'Menunggu Verifikasi'): ?>

<span class="badge bg-info text-dark">
Menunggu Verifikasi
</span>

<?php elseif($row['status'] == 'Sedang Disewa'): ?>

<span class="badge bg-primary">
Sedang Berlangsung
</span>

<?php elseif($row['status'] == 'Selesai'): ?>

<span class="badge bg-success">
Rental Selesai
</span>

<?php elseif($row['status'] == 'Ditolak'): ?>

<span class="badge bg-danger">
Booking Ditolak
</span>

<?php else: ?>

<span class="badge bg-secondary">
<?= $row['status']; ?>
</span>

<?php endif; ?>

</td>

<td>

<?php

if($row['status'] == 'Menunggu Pembayaran'):

?>

<a
href="../pembayaran/upload.php?booking_id=<?= $row['id']; ?>"
class="btn btn-success btn-sm"
>

Upload Pembayaran

</a>

<?php

elseif($row['status'] == 'Menunggu Verifikasi'):

?>

<button
class="btn btn-warning btn-sm"
disabled
>

Menunggu Verifikasi

</button>

<?php

elseif($row['status'] == 'Sedang Disewa'):

?>

<a
href="../invoice/index.php?id=<?= $row['id']; ?>"
class="btn btn-info btn-sm"
>

Invoice

</a>

<?php

elseif($row['status'] == 'Selesai'):

$booking_id = $row['id'];

$cekReview = mysqli_query(
    $conn,
    "SELECT id
    FROM review
    WHERE booking_id='$booking_id'"
);

$sudahReview =
    mysqli_num_rows($cekReview) > 0;

?>

<div class="d-flex gap-1">

<a
href="../invoice/index.php?id=<?= $row['id']; ?>"
class="btn btn-primary btn-sm"
>

Invoice

</a>

<?php if(!$sudahReview): ?>

<a
href="../review/tambah.php?booking_id=<?= $row['id']; ?>"
class="btn btn-gold btn-sm"
>

Review

</a>

<?php elseif($row['status'] == 'Ditolak'): ?>

<button
class="btn btn-danger btn-sm"
disabled
>

Pembayaran Ditolak

</button>

<?php else: ?>

<button
class="btn btn-success btn-sm"
disabled
>

Sudah Review

</button>

<?php endif; ?>

</div>

<?php else: ?>

<button
class="btn btn-secondary btn-sm"
disabled
>

-

</button>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</section>

</body>
</html>
