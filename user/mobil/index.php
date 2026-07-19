<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT * FROM mobil ORDER BY id DESC"
);

if (!$data) {
    die("Query Error : " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Premium Fleet | RentGo Black Gold Luxury</title>

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
    --muted:#bdbdbd;

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

    min-height:60vh;

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

    top:-150px;

    right:-150px;

}

.hero h1{

    font-size:64px;

    font-weight:900;

    margin-bottom:20px;

}

.hero span{

    color:var(--gold);

}

.hero p{

    max-width:720px;

    color:#d6d6d6;

    font-size:19px;

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

    border-radius:14px;

    padding:13px 28px;

    transition:.35s;

}

.btn-gold:hover{

    transform:translateY(-3px);

    color:#000;

    box-shadow:0 10px 30px rgba(212,175,55,.30);

}

.btn-outline-gold{

    border:1px solid var(--gold);

    color:var(--gold);

    border-radius:14px;

    padding:13px 28px;

    transition:.35s;

}

.btn-outline-gold:hover{

    background:var(--gold);

    color:#000;

}

/* ===========================
        SECTION TITLE
=========================== */

.section{

    padding:90px 0;

}

.section-title{

    color:var(--gold);

    font-size:34px;

    font-weight:800;

    margin-bottom:10px;

}

.section-subtitle{

    color:#bdbdbd;

    margin-bottom:45px;

}

/* ===========================
        CARD MOBIL
=========================== */

.car-card{

    background:linear-gradient(
        145deg,
        var(--card),
        var(--card2)
    );

    border:1px solid rgba(212,175,55,.15);

    border-radius:24px;

    overflow:hidden;

    transition:.35s;

    height:100%;

    position:relative;

}

.car-card::before{

    content:"";

    position:absolute;

    width:140px;

    height:140px;

    background:rgba(212,175,55,.04);

    border-radius:50%;

    top:-40px;

    right:-40px;

}

.car-card:hover{

    transform:translateY(-10px);

    border-color:var(--gold);

    box-shadow:
    0 20px 40px rgba(0,0,0,.45);

}

.car-card img{

    width:100%;

    height:250px;

    object-fit:cover;

    transition:.4s;

}

.car-card:hover img{

    transform:scale(1.05);

}

.car-body{

    padding:28px;

}

.car-name{

    font-size:28px;

    font-weight:800;

    color:#fff;

    margin-bottom:15px;

}

.car-info{

    color:#d4d4d4;

    margin-bottom:12px;

    display:flex;

    align-items:center;

    gap:10px;

}

.car-info i{

    color:var(--gold);

    width:22px;

}

.car-price{

    color:var(--gold);

    font-size:34px;

    font-weight:900;

    margin-top:18px;

}

.car-price span{

    font-size:15px;

    color:#aaa;

    font-weight:400;

}

/* ===========================
         STATUS
=========================== */

.badge{

    padding:9px 16px;

    border-radius:50px;

    font-size:13px;

    font-weight:600;

}

.status-tersedia{

    background:#198754;

}

.status-disewa{

    background:#dc3545;

}

/* ===========================
      DETAIL BUTTON
=========================== */

.btn-detail{

    background:linear-gradient(
        135deg,
        var(--gold),
        #b98d12
    );

    color:#000;

    border:none;

    border-radius:12px;

    font-weight:700;

    padding:13px;

    transition:.35s;

}

.btn-detail:hover{

    color:#000;

    transform:translateY(-2px);

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

.hero{

    min-height:50vh;

}

.hero h1{

    font-size:42px;

}

.hero p{

    font-size:16px;

}

.section{

    padding:60px 0;

}

.section-title{

    font-size:28px;

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

<div class="container">

<div class="row align-items-center">

<div class="col-lg-7">

<h1>

Premium <span>Fleet</span>

</h1>

<p>

Temukan kendaraan terbaik untuk setiap perjalanan Anda.
RentGo menghadirkan armada premium dengan kenyamanan,
keamanan, dan pelayanan profesional.

</p>

<div class="mt-4">

<a href="#fleet"
class="btn btn-gold me-3">

<i class="fas fa-car me-2"></i>

Lihat Armada

</a>

<a href="../booking/riwayat.php"
class="btn btn-outline-gold">

<i class="fas fa-clock-rotate-left me-2"></i>

Riwayat Booking

</a>

</div>

</div>

<div class="col-lg-5 text-center mt-5 mt-lg-0">

<i class="fas fa-car-side"
style="font-size:180px;color:#d4af37;opacity:.9;"></i>

</div>

</div>

</div>

</section>

<!-- ===========================
      DAFTAR ARMADA
=========================== -->

<section class="section" id="fleet">

<div class="container">

<div class="text-center mb-5">

<h2 class="section-title">

Luxury Vehicle Collection

</h2>

<p class="section-subtitle">

Pilih kendaraan yang sesuai dengan kebutuhan perjalanan Anda.

</p>

</div>

<div class="row g-4">

<?php while($mobil = mysqli_fetch_assoc($data)) : ?>

<?php

if (
    !empty($mobil['gambar']) &&
    file_exists('../../assets/img/mobil/' . $mobil['gambar'])
) {

    $gambar = '../../assets/img/mobil/' . $mobil['gambar'];

} else {

    $gambar = '../../assets/img/hero.jpg';

}

?>

<div class="col-xl-4 col-lg-6">

<div class="car-card">

<img
src="<?= $gambar ?>"
alt="<?= htmlspecialchars($mobil['nama_mobil']) ?>">

<div class="car-body">

<h3 class="car-name">

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h3>

<div class="car-info">

<i class="fas fa-industry"></i>

<span>

<?= htmlspecialchars($mobil['merk']) ?>

</span>

</div>

<div class="car-info">

<i class="fas fa-calendar"></i>

<span>

<?= htmlspecialchars($mobil['tahun']) ?>

</span>

</div>

<div class="car-info">

<i class="fas fa-gears"></i>

<span>

<?= htmlspecialchars($mobil['transmisi']) ?>

</span>

</div>

<div class="mt-3">

<strong>Status :</strong>

<?php if($mobil['status']=='Tersedia'): ?>

<span class="badge status-tersedia">

<i class="fas fa-circle-check me-1"></i>

Tersedia

</span>

<?php else: ?>

<span class="badge status-disewa">

<i class="fas fa-circle-xmark me-1"></i>

<?= htmlspecialchars($mobil['status']) ?>

</span>

<?php endif; ?>

</div>

<div class="car-price">

Rp <?= number_format(
    $mobil['harga_per_hari'],
    0,
    ',',
    '.'
); ?>

<span>/ Hari</span>

</div>

<div class="d-grid mt-4">

<a
href="detail.php?id=<?= $mobil['id'] ?>"
class="btn btn-detail">

<i class="fas fa-eye me-2"></i>

Lihat Detail

</a>

</div>

</div>

</div>

</div>

<?php endwhile; ?>

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

Drive With Confidence

</h3>

<p>

Seluruh armada RentGo selalu mendapatkan perawatan berkala,
kebersihan yang terjaga, serta perlindungan asuransi untuk
memberikan pengalaman berkendara yang aman, nyaman, dan
berkelas.

</p>

<div class="mt-4">

<a href="../booking/riwayat.php"
class="btn btn-outline-gold me-2">

<i class="fas fa-clock-rotate-left me-2"></i>

Riwayat Booking

</a>

<a href="../dashboard.php"
class="btn btn-gold">

<i class="fas fa-house me-2"></i>

Dashboard

</a>

</div>

</div>

<div class="col-lg-4 text-center mt-4 mt-lg-0">

<i class="fas fa-shield-halved"
style="font-size:120px;color:#d4af37;"></i>

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

<p class="text-secondary mb-0">

Luxury • Comfort • Professional Service

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