<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard User | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{
    --gold:#d4af37;
    --gold-light:#f4d46b;
    --dark:#050505;
    --card:#111111;
    --card2:#181818;
    --text:#ffffff;
    --muted:#b8b8b8;
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

    font-size:34px;

    font-weight:800;

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

    position:relative;

    padding:90px 0;

    background:

    linear-gradient(
        rgba(0,0,0,.75),
        rgba(0,0,0,.75)
    ),

    url('../assets/img/hero.jpg');

    background-size:cover;

    background-position:center;

    overflow:hidden;
}

.hero::before{

    content:"";

    position:absolute;

    width:500px;

    height:500px;

    background:rgba(212,175,55,.06);

    filter:blur(130px);

    border-radius:50%;

    right:-150px;

    top:-150px;
}

/* ===========================
      WELCOME BOX
=========================== */

.welcome-box{

    position:relative;

    z-index:2;

    background:linear-gradient(
        135deg,
        rgba(17,17,17,.96),
        rgba(30,30,30,.92)
    );

    border:1px solid rgba(212,175,55,.25);

    border-radius:25px;

    padding:45px;

    backdrop-filter:blur(10px);

    box-shadow:
        0 15px 40px rgba(0,0,0,.45);
}

.welcome-box h2{

    font-size:42px;

    font-weight:800;

    margin-bottom:20px;
}

.welcome-box span{

    color:var(--gold);
}

.welcome-box p{

    color:var(--muted);

    font-size:17px;

    line-height:1.8;
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

    color:#000;

    border:none;

    font-weight:700;

    border-radius:12px;

    padding:12px 28px;

    transition:.35s;
}

.btn-gold:hover{

    transform:translateY(-3px);

    box-shadow:0 12px 30px rgba(212,175,55,.35);

    color:#000;
}

.btn-outline-gold{

    border:1px solid var(--gold);

    color:var(--gold);

    border-radius:12px;

    padding:12px 28px;

    transition:.35s;
}

.btn-outline-gold:hover{

    background:var(--gold);

    color:#000;
}

/* ===========================
      SECTION TITLE
=========================== */

.section-title{

    font-size:30px;

    font-weight:800;

    color:var(--gold);

    margin-bottom:35px;
}

/* ===========================
      DASHBOARD CARD
=========================== */

.dashboard-card{

    background:linear-gradient(
        145deg,
        var(--card),
        var(--card2)
    );

    border:1px solid rgba(212,175,55,.15);

    border-radius:22px;

    padding:35px 25px;

    transition:.35s;

    text-align:center;

    height:100%;

    position:relative;

    overflow:hidden;
}

.dashboard-card::before{

    content:"";

    position:absolute;

    width:120px;

    height:120px;

    background:rgba(212,175,55,.05);

    border-radius:50%;

    top:-40px;

    right:-40px;
}

.dashboard-card:hover{

    transform:translateY(-10px);

    border-color:var(--gold);

    box-shadow:
        0 18px 40px rgba(0,0,0,.45);
}

.dashboard-card i{

    font-size:55px;

    color:var(--gold);

    margin-bottom:20px;
}

.dashboard-card h4{

    font-size:22px;

    margin-bottom:10px;
}

.dashboard-card p{

    color:var(--muted);

    margin-bottom:0;
}

/* ===========================
        PROMO CARD
=========================== */

.promo-card{

    background:linear-gradient(
        135deg,
        #161616,
        #0b0b0b
    );

    border:1px solid rgba(212,175,55,.20);

    border-radius:25px;

    padding:45px;
}

.promo-card h3{

    color:var(--gold);

    font-weight:800;

    margin-bottom:15px;
}

.promo-card p{

    color:#cfcfcf;

    line-height:1.8;
}

/* ===========================
          FOOTER
=========================== */

.footer{

    margin-top:90px;

    border-top:1px solid rgba(212,175,55,.18);

    padding:35px;

    text-align:center;

    color:#9d9d9d;
}

.footer h5{

    color:var(--gold);

    margin-bottom:10px;

    font-weight:700;
}

.footer small{

    color:#777;
}

@media(max-width:768px){

.hero{
    padding:70px 0;
}

.welcome-box{
    padding:30px;
}

.welcome-box h2{
    font-size:30px;
}

.section-title{
    font-size:24px;
}

.dashboard-card{
    margin-bottom:20px;
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

<a href="../index.php" class="logo">
    RentGo
</a>

<div class="ms-auto d-flex align-items-center">

<span class="text-light me-3">

<i class="fas fa-user-circle text-warning"></i>

<?= htmlspecialchars($_SESSION['nama']); ?>

</span>

<a href="../auth/logout.php" class="btn btn-outline-gold">

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

<div class="container">

<div class="welcome-box">

<div class="row align-items-center">

<div class="col-lg-8">

<h2>

Selamat Datang,

<span><?= htmlspecialchars($_SESSION['nama']); ?></span>

</h2>

<p>

Nikmati pengalaman rental mobil premium bersama
<strong class="text-warning">RentGo Black Gold Luxury</strong>.
Temukan kendaraan terbaik, lakukan booking dengan cepat,
dan pantau status pembayaran Anda melalui dashboard ini.

</p>

<div class="mt-4">

<a href="mobil/index.php" class="btn btn-gold me-3">

<i class="fas fa-car me-2"></i>

Sewa Mobil

</a>

<a href="booking/riwayat.php" class="btn btn-outline-gold">

<i class="fas fa-clock-rotate-left me-2"></i>

Riwayat Booking

</a>

</div>

</div>

<div class="col-lg-4 text-center mt-4 mt-lg-0">

<i class="fas fa-car-side"
style="font-size:150px;color:#d4af37;opacity:.9;"></i>

</div>

</div>

</div>

</div>

</section>

<!-- ===========================
      QUICK MENU
=========================== -->

<section class="container py-5">

<h2 class="section-title">

Quick Menu

</h2>

<div class="row g-4">

<!-- MOBIL -->

<div class="col-lg-3 col-md-6">

<a href="mobil/index.php"
class="text-decoration-none">

<div class="dashboard-card">

<i class="fas fa-car-side"></i>

<h4 class="text-white">

Lihat Mobil

</h4>

<p>

Jelajahi seluruh armada
mobil premium RentGo.

</p>

</div>

</a>

</div>

<!-- BOOKING -->

<div class="col-lg-3 col-md-6">

<a href="booking/riwayat.php"
class="text-decoration-none">

<div class="dashboard-card">

<i class="fas fa-calendar-check"></i>

<h4 class="text-white">

Riwayat Booking

</h4>

<p>

Lihat seluruh histori
penyewaan kendaraan Anda.

</p>

</div>

</a>

</div>

<!-- PEMBAYARAN -->

<div class="col-lg-3 col-md-6">

<a href="pembayaran/status.php"
class="text-decoration-none">

<div class="dashboard-card">

<i class="fas fa-credit-card"></i>

<h4 class="text-white">

Pembayaran

</h4>

<p>

Lihat status pembayaran
dan unggah bukti transfer.

</p>

</div>

</a>

</div>

<!-- PROFIL -->

<div class="col-lg-3 col-md-6">

<a href="profile/index.php"
class="text-decoration-none">

<div class="dashboard-card">

<i class="fas fa-user"></i>

<h4 class="text-white">

Profil Saya

</h4>

<p>

Kelola informasi akun
dan data pribadi Anda.

</p>

</div>

</a>

</div>

</div>

</section>

<!-- ===========================
        LUXURY EXPERIENCE
=========================== -->

<section class="container mb-5">

<div class="promo-card">

<div class="row align-items-center">

<div class="col-lg-8">

<h3>

<i class="fas fa-crown me-2"></i>

Luxury Experience

</h3>

<p>

RentGo menghadirkan pengalaman rental mobil yang nyaman,
aman, dan profesional. Pilih kendaraan favorit Anda,
lakukan pemesanan secara online, unggah bukti pembayaran,
serta pantau seluruh proses penyewaan langsung melalui dashboard.

</p>

<a href="mobil/index.php" class="btn btn-gold mt-3">

<i class="fas fa-arrow-right me-2"></i>

Booking Sekarang

</a>

</div>

<div class="col-lg-4 text-center mt-4 mt-lg-0">

<i class="fas fa-car-on"
style="font-size:120px;color:#d4af37;opacity:.9;"></i>

</div>

</div>

</div>

</section>

<!-- ===========================
        TIPS
=========================== -->

<section class="container mb-5">

<h2 class="section-title">

Panduan Singkat

</h2>

<div class="row g-4">

<div class="col-md-4">

<div class="dashboard-card">

<i class="fas fa-magnifying-glass"></i>

<h4 class="text-white">

Pilih Mobil

</h4>

<p>

Lihat seluruh armada yang tersedia dan pilih kendaraan sesuai kebutuhan perjalanan Anda.

</p>

</div>

</div>

<div class="col-md-4">

<div class="dashboard-card">

<i class="fas fa-calendar-plus"></i>

<h4 class="text-white">

Lakukan Booking

</h4>

<p>

Isi tanggal penyewaan kemudian lakukan konfirmasi sesuai prosedur yang tersedia.

</p>

</div>

</div>

<div class="col-md-4">

<div class="dashboard-card">

<i class="fas fa-money-check-dollar"></i>

<h4 class="text-white">

Upload Pembayaran

</h4>

<p>

Unggah bukti pembayaran dan tunggu proses verifikasi dari admin RentGo.

</p>

</div>

</div>

</div>

</section>

<!-- ===========================
          FOOTER
=========================== -->

<footer class="footer">

<h5>

<i class="fas fa-car-side me-2"></i>

RentGo Black Gold Luxury

</h5>

<p>

Premium Car Rental System

</p>

<small>

© <?= date('Y'); ?> RentGo. All Rights Reserved.

</small>

</footer>

</body>
</html>