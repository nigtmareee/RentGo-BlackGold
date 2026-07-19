<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = mysqli_query(
    $conn,
    "SELECT * FROM mobil WHERE id='$id'"
);

$mobil = mysqli_fetch_assoc($query);

if(!$mobil){
    die("Mobil tidak ditemukan.");
}

/* =========================
   RATING
========================= */

$qRating = mysqli_query(
    $conn,
    "SELECT
        AVG(rating) AS rata_rating,
        COUNT(id) AS total_review
    FROM review
    WHERE mobil_id='$id'"
);

$ratingData = mysqli_fetch_assoc($qRating);

$rataRating = round($ratingData['rata_rating'] ?? 0,1);

$totalReview = $ratingData['total_review'] ?? 0;

/* =========================
   REVIEW
========================= */

$review = mysqli_query(
    $conn,
    "SELECT
        review.*,
        users.nama
    FROM review
    JOIN users
        ON review.user_id = users.id
    WHERE review.mobil_id='$id'
    ORDER BY review.id DESC"
);

/* =========================
   GAMBAR
========================= */

if (
    !empty($mobil['gambar']) &&
    file_exists('../../assets/img/mobil/' . $mobil['gambar'])
) {

    $gambar = '../../assets/img/mobil/' . $mobil['gambar'];

} else {

    $gambar = '../../assets/img/hero.jpg';

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>

<?= htmlspecialchars($mobil['nama_mobil']) ?>

| RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

--gold:#d4af37;
--gold-light:#f4d46b;
--dark:#050505;
--card:#111;
--card2:#1a1a1a;
--text:#ffffff;
--muted:#c7c7c7;

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

background:rgba(5,5,5,.95);

backdrop-filter:blur(12px);

border-bottom:1px solid rgba(212,175,55,.18);

padding:15px 0;

position:sticky;

top:0;

z-index:999;

}

.logo{

color:var(--gold);

text-decoration:none;

font-size:34px;

font-weight:800;

letter-spacing:1px;

}

.logo:hover{

color:var(--gold-light);

}

/* ===========================
          HERO
=========================== */

.hero{

position:relative;

min-height:45vh;

display:flex;

align-items:center;

background:

linear-gradient(
rgba(0,0,0,.72),
rgba(0,0,0,.82)
),

url('../../assets/img/hero.jpg');

background-size:cover;

background-position:center;

overflow:hidden;

}

.hero::before{

content:"";

position:absolute;

width:500px;

height:500px;

background:rgba(212,175,55,.05);

filter:blur(120px);

border-radius:50%;

top:-180px;

right:-150px;

}

.hero h1{

font-size:60px;

font-weight:900;

margin-bottom:15px;

}

.hero p{

font-size:18px;

color:#ddd;

}

/* ===========================
      IMAGE
=========================== */

.car-image{

width:100%;

height:560px;

object-fit:cover;

border-radius:25px;

border:1px solid rgba(212,175,55,.18);

box-shadow:0 20px 40px rgba(0,0,0,.45);

transition:.4s;

}

.car-image:hover{

transform:scale(1.02);

}

/* ===========================
      INFO CARD
=========================== */

.info-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid rgba(212,175,55,.15);

border-radius:25px;

padding:35px;

height:100%;

}

.info-card h2{

font-size:42px;

font-weight:800;

margin-bottom:10px;

}

.rating{

font-size:22px;

color:var(--gold);

font-weight:700;

}

.price{

font-size:42px;

font-weight:900;

color:var(--gold);

margin-top:25px;

}

.price span{

font-size:16px;

color:#bbb;

font-weight:400;

}

.detail-text{

color:#ddd;

margin-bottom:12px;

display:flex;

align-items:center;

gap:12px;

}

.detail-text i{

color:var(--gold);

width:24px;

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

border-radius:14px;

padding:14px;

transition:.35s;

}

.btn-gold:hover{

transform:translateY(-3px);

color:#000;

box-shadow:0 12px 30px rgba(212,175,55,.30);

}

.btn-outline-gold{

border:1px solid var(--gold);

color:var(--gold);

border-radius:14px;

padding:12px 25px;

transition:.35s;

}

.btn-outline-gold:hover{

background:var(--gold);

color:#000;

}

/* ===========================
      REVIEW
=========================== */

.review-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid rgba(212,175,55,.12);

border-radius:20px;

padding:25px;

margin-bottom:20px;

transition:.3s;

}

.review-card:hover{

border-color:var(--gold);

transform:translateY(-5px);

}

/* ===========================
      SECTION
=========================== */

.section{

padding:90px 0;

}

.section-title{

font-size:34px;

font-weight:800;

color:var(--gold);

margin-bottom:35px;

}

/* ===========================
      FOOTER
=========================== */

.footer{

border-top:1px solid rgba(212,175,55,.18);

margin-top:80px;

padding:35px;

text-align:center;

color:#999;

}

.footer h5{

color:var(--gold);

margin-bottom:10px;

}

/* ===========================
      RESPONSIVE
=========================== */

@media(max-width:768px){

.hero h1{

font-size:42px;

}

.car-image{

height:320px;

}

.info-card h2{

font-size:30px;

}

.price{

font-size:32px;

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

<div class="ms-auto d-flex align-items-center">

<span class="text-light me-3">

<i class="fas fa-user-circle text-warning me-2"></i>

<?= htmlspecialchars($_SESSION['nama']); ?>

</span>

<a href="index.php"
class="btn btn-outline-gold me-2">

<i class="fas fa-arrow-left me-2"></i>

Kembali

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

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h1>

<p>

Luxury Vehicle Details

</p>

</div>

</section>

<!-- ===========================
        DETAIL MOBIL
=========================== -->

<section class="section">

<div class="container">

<div class="row g-5 align-items-start">

<!-- FOTO -->

<div class="col-lg-6">

<img
src="<?= $gambar ?>"
class="car-image"
alt="<?= htmlspecialchars($mobil['nama_mobil']) ?>">

</div>

<!-- INFORMASI -->

<div class="col-lg-6">

<div class="info-card">

<h2>

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h2>

<div class="rating mb-3">

<?php

$bintang = round($rataRating);

for($i=1;$i<=$bintang;$i++){

echo '<i class="fas fa-star"></i> ';

}

?>

<span class="ms-2">

<?= $rataRating ?>/5

</span>

</div>

<p class="text-secondary mb-4">

<?= $totalReview ?> Review Pelanggan

</p>

<hr class="border-secondary">

<p class="detail-text">

<i class="fas fa-industry"></i>

<strong>Merk :</strong>

<?= htmlspecialchars($mobil['merk']) ?>

</p>

<p class="detail-text">

<i class="fas fa-calendar"></i>

<strong>Tahun :</strong>

<?= htmlspecialchars($mobil['tahun']) ?>

</p>

<p class="detail-text">

<i class="fas fa-id-card"></i>

<strong>Plat Nomor :</strong>

<?= htmlspecialchars($mobil['plat_nomor']) ?>

</p>

<p class="detail-text">

<i class="fas fa-palette"></i>

<strong>Warna :</strong>

<?= htmlspecialchars($mobil['warna']) ?>

</p>

<p class="detail-text">

<i class="fas fa-gears"></i>

<strong>Transmisi :</strong>

<?= htmlspecialchars($mobil['transmisi']) ?>

</p>

<p class="detail-text">

<i class="fas fa-gas-pump"></i>

<strong>Bahan Bakar :</strong>

<?= htmlspecialchars($mobil['bahan_bakar']) ?>

</p>

<p class="detail-text">

<i class="fas fa-users"></i>

<strong>Kapasitas :</strong>

<?= htmlspecialchars($mobil['kapasitas_penumpang']) ?>

Orang

</p>

<p class="detail-text">

<i class="fas fa-circle-info"></i>

<strong>Status :</strong>

<?php if($mobil['status']=='Tersedia'): ?>

<span class="badge bg-success ms-2">

<i class="fas fa-circle-check me-1"></i>

Tersedia

</span>

<?php else: ?>

<span class="badge bg-danger ms-2">

<i class="fas fa-circle-xmark me-1"></i>

<?= htmlspecialchars($mobil['status']) ?>

</span>

<?php endif; ?>

</p>

<hr class="border-secondary">

<h5 class="text-warning mb-3">

<i class="fas fa-file-lines me-2"></i>

Deskripsi

</h5>

<p class="text-light" style="line-height:1.9;">

<?= nl2br(htmlspecialchars($mobil['deskripsi'])); ?>

</p>

<div class="price">

Rp <?= number_format(
$mobil['harga_per_hari'],
0,
',',
'.'
); ?>

<span>/ Hari</span>

</div>

<hr class="border-secondary my-4">

<?php if($mobil['status']=='Tersedia'): ?>

<a
href="../booking/sewa.php?id=<?= $mobil['id'] ?>"
class="btn btn-gold btn-lg w-100">

<i class="fas fa-calendar-check me-2"></i>

Booking Sekarang

</a>

<?php else: ?>

<button
class="btn btn-danger btn-lg w-100"
disabled>

<i class="fas fa-ban me-2"></i>

Mobil Sedang Disewa

</button>

<?php endif; ?>

</div>

</div>

</div>

</div>

</section>

<!-- ===========================
        CUSTOMER REVIEWS
=========================== -->

<section class="section">

<div class="container">

<h2 class="section-title">

<i class="fas fa-star text-warning me-2"></i>

Customer Reviews

</h2>

<?php if(mysqli_num_rows($review)>0): ?>

<div class="row">

<?php while($r=mysqli_fetch_assoc($review)): ?>

<div class="col-lg-6 mb-4">

<div class="review-card h-100">

<div class="d-flex justify-content-between align-items-center mb-3">

<div>

<h5 class="mb-1">

<i class="fas fa-user-circle text-warning me-2"></i>

<?= htmlspecialchars($r['nama']) ?>

</h5>

<small class="text-secondary">

<?= $r['created_at'] ?>

</small>

</div>

<div class="rating">

<?php

for($i=1;$i<=$r['rating'];$i++){

echo '<i class="fas fa-star"></i>';

}

?>

</div>

</div>

<hr class="border-secondary">

<p class="text-light mb-0" style="line-height:1.8;">

<?= nl2br(htmlspecialchars($r['komentar'])) ?>

</p>

</div>

</div>

<?php endwhile; ?>

</div>

<?php else: ?>

<div class="alert alert-dark border border-warning text-center py-4">

<h5 class="text-warning">

<i class="fas fa-comments me-2"></i>

Belum Ada Review

</h5>

<p class="mb-0 text-light">

Mobil ini belum memiliki ulasan dari pelanggan.

</p>

</div>

<?php endif; ?>

</div>

</section>

<!-- ===========================
        LUXURY EXPERIENCE
=========================== -->

<section class="container mb-5">

<div class="info-card">

<div class="row align-items-center">

<div class="col-lg-8">

<h2 class="mb-3 text-warning">

<i class="fas fa-crown me-2"></i>

Luxury Driving Experience

</h2>

<p class="text-light" style="line-height:1.9;">

Nikmati pengalaman berkendara terbaik bersama RentGo Black Gold Luxury.
Setiap kendaraan mendapatkan perawatan rutin, kebersihan maksimal,
serta pelayanan profesional agar perjalanan Anda selalu aman,
nyaman, dan berkelas.

</p>

<div class="mt-4">

<a href="index.php"
class="btn btn-outline-gold me-2">

<i class="fas fa-car me-2"></i>

Lihat Armada

</a>

<a href="../dashboard.php"
class="btn btn-gold">

<i class="fas fa-house me-2"></i>

Dashboard

</a>

</div>

</div>

<div class="col-lg-4 text-center mt-4 mt-lg-0">

<i class="fas fa-car-side"
style="font-size:130px;color:#d4af37;"></i>

</div>

</div>

</div>

</section>

<!-- ===========================
            FOOTER
=========================== -->

<footer class="footer">

<div class="container">

<h5>

<i class="fas fa-car-side me-2"></i>

RentGo Black Gold Luxury

</h5>

<p class="mb-2">

Premium Car Rental System

</p>

<p class="text-secondary">

Luxury • Comfort • Safety • Professional Service

</p>

<hr class="border-secondary my-4">

<small>

© <?= date('Y'); ?> RentGo Black Gold Luxury.
All Rights Reserved.

</small>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>