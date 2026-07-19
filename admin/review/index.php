<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT
        review.*,
        users.nama,
        mobil.nama_mobil
    FROM review
    JOIN users
        ON review.user_id = users.id
    JOIN mobil
        ON review.mobil_id = mobil.id
    ORDER BY review.id DESC"
);

$totalReview = mysqli_num_rows($data);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

Kelola Review | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

--gold:#d4af37;
--gold-light:#f5d56d;
--dark:#050505;
--card:#111111;
--card2:#1a1a1a;
--border:rgba(212,175,55,.18);
--text:#ffffff;
--muted:#bdbdbd;

}

*{

margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;

}

body{

background:var(--dark);
color:var(--text);
overflow-x:hidden;

}

/*==========================
        NAVBAR
==========================*/

.navbar{

background:rgba(5,5,5,.96);

backdrop-filter:blur(15px);

border-bottom:1px solid rgba(212,175,55,.15);

padding:15px 0;

position:sticky;

top:0;

z-index:999;

}

.logo{

font-size:30px;

font-weight:800;

text-decoration:none;

color:var(--gold);

letter-spacing:1px;

}

.logo:hover{

color:var(--gold-light);

}

/*==========================
          HERO
==========================*/

.hero{

min-height:38vh;

display:flex;

align-items:center;

justify-content:center;

text-align:center;

background:
linear-gradient(
rgba(0,0,0,.75),
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

width:420px;
height:420px;

background:rgba(212,175,55,.06);

border-radius:50%;

filter:blur(120px);

right:-120px;
top:-150px;

}

.hero h1{

font-size:56px;

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

/*==========================
          SECTION
==========================*/

.section{

padding:80px 0;

}

/*==========================
        CARD PREMIUM
==========================*/

.card-premium{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid var(--border);

border-radius:24px;

padding:35px;

box-shadow:0 20px 45px rgba(0,0,0,.45);

}

/*==========================
      STATISTIC CARD
==========================*/

.stat-card{

background:#181818;

border-left:5px solid var(--gold);

border-radius:18px;

padding:22px;

transition:.3s;

height:100%;

}

.stat-card:hover{

transform:translateY(-6px);

box-shadow:0 15px 35px rgba(212,175,55,.15);

}

.stat-card i{

font-size:32px;

color:var(--gold);

margin-bottom:15px;

}

.stat-card h3{

font-size:34px;

font-weight:700;

margin-bottom:8px;

}

.stat-card p{

color:#bbb;

margin:0;

}

/*==========================
          TABLE
==========================*/

.table{

color:#fff;

margin-bottom:0;

}

.table thead{

background:#1d1d1d;

}

.table thead th{

color:var(--gold);

border-color:#333;

text-align:center;

vertical-align:middle;

white-space:nowrap;

}

.table tbody tr{

background:#111;

transition:.3s;

}

.table tbody tr:hover{

background:#1b1b1b;

}

.table td{

border-color:#2d2d2d;

vertical-align:middle;

}

/*==========================
          BADGE
==========================*/

.badge-rating{

background:rgba(212,175,55,.15);

color:var(--gold);

padding:8px 14px;

border-radius:30px;

font-weight:600;

}

.comment{

max-width:340px;

white-space:normal;

}

/*==========================
          BUTTON
==========================*/

.btn-gold{

background:linear-gradient(
135deg,
var(--gold),
#b98d12
);

border:none;

color:#000;

font-weight:700;

padding:12px 20px;

border-radius:12px;

transition:.3s;

}

.btn-gold:hover{

color:#000;

transform:translateY(-3px);

box-shadow:0 10px 25px rgba(212,175,55,.25);

}

.btn-delete{

background:#dc3545;

color:#fff;

border:none;

border-radius:10px;

padding:8px 15px;

transition:.3s;

}

.btn-delete:hover{

background:#bb2d3b;

color:#fff;

}

/*==========================
          FOOTER
==========================*/

.footer{

margin-top:80px;

padding:35px;

text-align:center;

border-top:1px solid rgba(212,175,55,.15);

color:#999;

}

/*==========================
        RESPONSIVE
==========================*/

@media(max-width:768px){

.hero h1{

font-size:42px;

}

.card-premium{

padding:22px;

}

.stat-card{

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

<a href="../dashboard.php" class="logo">

<i class="fas fa-car-side me-2"></i>

RentGo Admin

</a>

<div class="ms-auto">

<a
href="../dashboard.php"
class="btn btn-gold">

<i class="fas fa-gauge-high me-2"></i>

Dashboard

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

Kelola

<span>

Review

</span>

</h1>

<p>

Lihat seluruh ulasan pelanggan untuk meningkatkan kualitas layanan RentGo Black Gold Luxury.

</p>

</div>

</section>

<!-- ===========================
            CONTENT
=========================== -->

<section class="section">

<div class="container">

<!-- Statistik -->

<div class="row g-4 mb-5">

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-comments"></i>

<h3><?= $totalReview ?></h3>

<p>Total Review</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-star"></i>

<h3>★★★★★</h3>

<p>Rating Pelanggan</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-car-side"></i>

<h3>Premium</h3>

<p>Layanan Mobil</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-users"></i>

<h3><?= $totalReview ?></h3>

<p>Pelanggan Aktif</p>

</div>

</div>

</div>

<!-- Card -->

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

<div>

<h2 class="text-warning fw-bold">

<i class="fas fa-star me-2"></i>

Daftar Review Pelanggan

</h2>

<p class="text-secondary mb-0">

Seluruh ulasan yang telah diberikan oleh pelanggan RentGo.

</p>

</div>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>
<th>Pelanggan</th>
<th>Mobil</th>
<th>Rating</th>
<th>Komentar</th>
<th>Tanggal</th>
<th width="120">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

mysqli_data_seek($data,0);

while($row=mysqli_fetch_assoc($data)):

?>

<tr>

<td class="text-center">

<?= $no++; ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['nama']); ?>

</strong>

</td>

<td>

<?= htmlspecialchars($row['nama_mobil']); ?>

</td>

<td class="text-center">

<span class="badge-rating">

<?php

for($i=1;$i<=$row['rating'];$i++){

echo '<i class="fas fa-star"></i>';

}

?>

</span>

</td>

<td class="comment">

<?= nl2br(htmlspecialchars($row['komentar'])); ?>

</td>

<td class="text-center">

<?= $row['created_at']; ?>

</td>

<td class="text-center">

<a
href="hapus.php?id=<?= $row['id']; ?>"
class="btn btn-delete btn-sm"
onclick="return confirm('Hapus review ini?')">

<i class="fas fa-trash-alt me-1"></i>

Hapus

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

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

Halaman ini digunakan untuk mengelola seluruh ulasan pelanggan.
Review yang diberikan pelanggan menjadi bahan evaluasi untuk
meningkatkan kualitas kendaraan dan pelayanan RentGo Black Gold Luxury.

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

<script>

/* ===========================
      TABLE ANIMATION
=========================== */

document.querySelectorAll("tbody tr").forEach((row,index)=>{

    row.style.opacity="0";

    row.style.transform="translateY(20px)";

    setTimeout(()=>{

        row.style.transition=".4s";

        row.style.opacity="1";

        row.style.transform="translateY(0)";

    },index*80);

});

/* ===========================
      DELETE BUTTON EFFECT
=========================== */

document.querySelectorAll(".btn-delete").forEach(btn=>{

    btn.addEventListener("mouseenter",function(){

        this.style.transform="translateY(-2px)";

    });

    btn.addEventListener("mouseleave",function(){

        this.style.transform="translateY(0)";

    });

});

</script>

</body>

</html>