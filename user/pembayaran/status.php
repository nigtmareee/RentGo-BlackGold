<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = (int) $_SESSION['id'];

$data = mysqli_query(
    $conn,
    "
    SELECT
        p.*,
        b.total_harga,
        m.nama_mobil
    FROM pembayaran p
    JOIN booking b ON p.booking_id = b.id
    JOIN mobil m ON b.mobil_id = m.id
    WHERE b.user_id = '$user_id'
    ORDER BY p.id DESC
    "
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Status Pembayaran - RentGo</title>

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

    min-height:35vh;

    display:flex;
    align-items:center;
    justify-content:center;

    text-align:center;

    background:
    linear-gradient(
        rgba(0,0,0,.80),
        rgba(0,0,0,.80)
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

/* SECTION */

.section{
    padding:80px 0;
}

/* CARD */

.table-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:25px;

    padding:30px;
}

/* TABLE */

.table{
    color:white;
    margin-bottom:0;
}

.table thead{
    background:#1a1a1a;
}

.table th{
    border-color:#333;
}

.table td{
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

    border-radius:12px;
}

.btn-gold:hover{

    background:#c79d1c;

    color:#000;
}

/* PRICE */

.price{

    color:var(--gold);

    font-weight:800;
}

/* STATUS */

.status-wait{
    background:#ffc107;
    color:#000;
}

.status-ok{
    background:#198754;
}

.status-no{
    background:#dc3545;
}

</style>

</head>

<body>

<!-- HERO -->

<section class="hero">

<div class="container">

<h1>

Status <span>Pembayaran</span>

</h1>

<p>

Pantau proses verifikasi pembayaran rental Anda

</p>

<a
href="../dashboard.php"
class="btn btn-warning mt-3"
>

← Dashboard

</a>

</div>

</section>

<!-- CONTENT -->

<section class="section">

<div class="container">

<div class="table-card">

<h3 class="mb-4">

<i class="fas fa-credit-card me-2"></i>

Riwayat Pembayaran

</h3>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No</th>
<th>Mobil</th>
<th>Total Tagihan</th>
<th>Metode</th>
<th>Status</th>
<th>Bukti Transfer</th>

</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($data)):
?>

<tr>

<td>

<?= $no++ ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['nama_mobil']) ?>

</strong>

</td>

<td>

<span class="price">

Rp <?= number_format(
    $row['total_harga'],
    0,
    ',',
    '.'
); ?>

</span>

</td>

<td>

<?= htmlspecialchars($row['metode_pembayaran']) ?>

</td>

<td>

<?php if($row['status'] == 'Menunggu Verifikasi'): ?>

<span class="badge status-wait">

Menunggu Verifikasi

</span>

<?php elseif($row['status'] == 'Diterima'): ?>

<span class="badge status-ok">

Pembayaran Diterima

</span>

<?php else: ?>

<span class="badge status-no">

Pembayaran Ditolak

</span>

<?php endif; ?>

</td>

<td>

<?php if(!empty($row['bukti_transfer'])): ?>

<a
href="/rentgo/assets/uploads/pembayaran/<?= $row['bukti_transfer']; ?>"
target="_blank"
class="btn btn-gold btn-sm"
>

<i class="fas fa-image me-1"></i>

Lihat Bukti

</a>

<?php else: ?>

<span class="text-secondary">

Belum Upload

</span>

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
