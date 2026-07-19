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

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>

Riwayat Booking | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

--gold:#d4af37;
--gold-light:#f4d46b;
--dark:#050505;
--card:#111111;
--card2:#1a1a1a;
--text:#ffffff;
--muted:#c5c5c5;

}

*{

margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;

}

html{

scroll-behavior:smooth;

}

body{

background:var(--dark);
color:var(--text);
overflow-x:hidden;

}

/* ===========================
        NAVBAR
=========================== */

.navbar{

background:rgba(5,5,5,.96);

backdrop-filter:blur(14px);

border-bottom:1px solid rgba(212,175,55,.15);

padding:15px 0;

position:sticky;

top:0;

z-index:999;

}

.logo{

font-size:32px;

font-weight:800;

color:var(--gold);

text-decoration:none;

letter-spacing:1px;

}

.logo:hover{

color:var(--gold-light);

}

/* ===========================
            HERO
=========================== */

.hero{

min-height:42vh;

display:flex;

align-items:center;

text-align:center;

background:

linear-gradient(
rgba(0,0,0,.72),
rgba(0,0,0,.82)
),

url('../../assets/img/hero.jpg');

background-size:cover;

background-position:center;

position:relative;

overflow:hidden;

}

.hero::before{

content:"";

position:absolute;

width:450px;

height:450px;

border-radius:50%;

background:rgba(212,175,55,.05);

filter:blur(120px);

top:-180px;

right:-120px;

}

.hero h1{

font-size:58px;

font-weight:900;

margin-bottom:15px;

}

.hero span{

color:var(--gold);

}

.hero p{

font-size:18px;

color:#ddd;

}

/* ===========================
        SECTION
=========================== */

.section{

padding:90px 0;

}

/* ===========================
        CARD
=========================== */

.table-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid rgba(212,175,55,.15);

border-radius:25px;

padding:30px;

box-shadow:0 20px 40px rgba(0,0,0,.35);

overflow:hidden;

}

/* ===========================
        TABLE
=========================== */

.table{

color:#fff;

margin-bottom:0;

}

.table thead{

background:#1b1b1b;

}

.table thead th{

border:none;

color:var(--gold);

font-weight:700;

padding:18px;

white-space:nowrap;

}

.table tbody td{

border-color:#262626;

padding:18px;

vertical-align:middle;

}

.table tbody tr{

transition:.3s;

}

.table tbody tr:hover{

background:#181818;

}

/* ===========================
        BADGE
=========================== */

.badge{

padding:8px 14px;

font-size:13px;

border-radius:30px;

font-weight:600;

}

/* ===========================
        BUTTON
=========================== */

.btn-gold{

background:linear-gradient(
135deg,
var(--gold),
#b98d12
);

border:none;

color:#000;

font-weight:700;

border-radius:12px;

transition:.3s;

}

.btn-gold:hover{

color:#000;

transform:translateY(-2px);

box-shadow:0 10px 20px rgba(212,175,55,.25);

}

.btn-outline-gold{

border:1px solid var(--gold);

color:var(--gold);

border-radius:12px;

}

.btn-outline-gold:hover{

background:var(--gold);

color:#000;

}

/* ===========================
        PRICE
=========================== */

.price{

color:var(--gold);

font-weight:800;

font-size:18px;

}

/* ===========================
        FOOTER
=========================== */

.footer{

margin-top:80px;

padding:35px;

text-align:center;

border-top:1px solid rgba(212,175,55,.15);

color:#999;

}

/* ===========================
        RESPONSIVE
=========================== */

@media(max-width:768px){

.hero h1{

font-size:42px;

}

.table-card{

padding:18px;

}

}

</style>

</head>

<body>

<!-- ===========================
        NAVBAR
=========================== -->

<nav class="navbar navbar-expand-lg">

<div class="container">

<a href="../dashboard.php" class="logo">

<i class="fas fa-car-side me-2"></i>

RentGo

</a>

<div class="ms-auto">

<a href="../dashboard.php"
class="btn btn-outline-gold me-2">

<i class="fas fa-house me-2"></i>

Dashboard

</a>

<a href="../../auth/logout.php"
class="btn btn-gold">

<i class="fas fa-right-from-bracket me-2"></i>

Logout

</a>

</div>

</div>

</nav>

<!-- ===========================
            HERO
=========================== -->

<section class="hero">

<div class="container text-center">

<h1>

Riwayat

<span>

Booking

</span>

</h1>

<p>

Pantau seluruh aktivitas penyewaan mobil Anda bersama
RentGo Black Gold Luxury.

</p>

</div>

</section>

<!-- ===========================
            CONTENT
=========================== -->

<section class="section">

<div class="container">

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

<div>

<h2 class="mb-2 text-warning">

<i class="fas fa-clock-rotate-left me-2"></i>

Riwayat Rental

</h2>

<p class="text-secondary mb-0">

Daftar seluruh transaksi booking Anda.

</p>

</div>

<div>

<span class="badge bg-dark border border-warning px-3 py-2">

<i class="fas fa-car me-2 text-warning"></i>

Total Booking :
<strong>

<?= mysqli_num_rows($data); ?>

</strong>

</span>

</div>

</div>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>No</th>

<th>Mobil</th>

<th>Periode</th>

<th>Lama</th>

<th>Total</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($data)):
?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<div>

<strong>

<i class="fas fa-car-side text-warning me-2"></i>

<?= htmlspecialchars($row['nama_mobil']); ?>

</strong>

</div>

</td>

<td>

<div>

<i class="fas fa-calendar-day text-warning me-2"></i>

<?= $row['tanggal_mulai']; ?>

</div>

<div class="text-secondary">

s/d

</div>

<div>

<i class="fas fa-calendar-check text-warning me-2"></i>

<?= $row['tanggal_selesai']; ?>

</div>

</td>

<td>

<span class="badge bg-secondary">

<?= $row['total_hari']; ?>

Hari

</span>

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

<?php if($row['status']=='Menunggu Pembayaran'): ?>

<span class="badge bg-warning text-dark">

<i class="fas fa-wallet me-1"></i>

Menunggu Pembayaran

</span>

<?php elseif($row['status']=='Menunggu Verifikasi'): ?>

<span class="badge bg-info text-dark">

<i class="fas fa-magnifying-glass me-1"></i>

Menunggu Verifikasi

</span>

<?php elseif($row['status']=='Sedang Disewa'): ?>

<span class="badge bg-primary">

<i class="fas fa-road me-1"></i>

Sedang Disewa

</span>

<?php elseif($row['status']=='Selesai'): ?>

<span class="badge bg-success">

<i class="fas fa-circle-check me-1"></i>

Selesai

</span>

<?php elseif($row['status']=='Ditolak'): ?>

<span class="badge bg-danger">

<i class="fas fa-circle-xmark me-1"></i>

Ditolak

</span>

<?php else: ?>

<span class="badge bg-secondary">

<?= htmlspecialchars($row['status']); ?>

</span>

<?php endif; ?>

</td>

<td>

<?php

if($row['status'] == 'Menunggu Pembayaran'):

?>

<a
href="../pembayaran/upload.php?booking_id=<?= $row['id']; ?>"
class="btn btn-success btn-sm">

<i class="fas fa-upload me-1"></i>

Upload Pembayaran

</a>

<?php

elseif($row['status'] == 'Menunggu Verifikasi'):

?>

<button
class="btn btn-warning btn-sm"
disabled>

<i class="fas fa-hourglass-half me-1"></i>

Menunggu Verifikasi

</button>

<?php

elseif($row['status'] == 'Sedang Disewa'):

?>

<a
href="../invoice/index.php?id=<?= $row['id']; ?>"
class="btn btn-info btn-sm">

<i class="fas fa-file-invoice me-1"></i>

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

$sudahReview = mysqli_num_rows($cekReview) > 0;

?>

<div class="d-flex gap-2 flex-wrap">

<a
href="../invoice/index.php?id=<?= $row['id']; ?>"
class="btn btn-primary btn-sm">

<i class="fas fa-file-invoice me-1"></i>

Invoice

</a>

<?php if(!$sudahReview): ?>

<a
href="../review/tambah.php?booking_id=<?= $row['id']; ?>"
class="btn btn-gold btn-sm">

<i class="fas fa-star me-1"></i>

Review

</a>

<?php else: ?>

<button
class="btn btn-success btn-sm"
disabled>

<i class="fas fa-circle-check me-1"></i>

Sudah Review

</button>

<?php endif; ?>

</div>

<?php

elseif($row['status'] == 'Ditolak'):

?>

<button
class="btn btn-danger btn-sm"
disabled>

<i class="fas fa-circle-xmark me-1"></i>

Pembayaran Ditolak

</button>

<?php else: ?>

<button
class="btn btn-secondary btn-sm"
disabled>

-

</button>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

<?php if(mysqli_num_rows($data) == 0): ?>

<tr>

<td colspan="7" class="text-center py-5">

<i class="fas fa-folder-open fa-4x text-warning mb-3"></i>

<h4 class="mt-3">

Belum Ada Riwayat Booking

</h4>

<p class="text-secondary">

Anda belum pernah melakukan booking mobil.

</p>

<a
href="../mobil/index.php"
class="btn btn-gold mt-3">

<i class="fas fa-car-side me-2"></i>

Mulai Booking

</a>

</td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</section>

<!-- ===========================
        FOOTER
=========================== -->

<footer class="footer">

<div class="container">

<h4 class="text-warning mb-3">

<i class="fas fa-car-side me-2"></i>

RentGo Black Gold Luxury

</h4>

<p class="text-light">

Lihat seluruh riwayat penyewaan Anda dengan mudah,
mulai dari proses booking, pembayaran,
hingga penyelesaian rental.

</p>

<hr class="border-secondary my-4">

<p class="mb-0 text-secondary">

&copy; <?= date('Y'); ?>

RentGo Black Gold Luxury.

All Rights Reserved.

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>