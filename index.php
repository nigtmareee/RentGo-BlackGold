<?php
session_start();
require_once 'config/koneksi.php';

/** @var mysqli $conn */
$totalMobil = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM mobil")
);

$totalUser = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM users WHERE role='user'")
);

$totalBooking = mysqli_num_rows(
    mysqli_query($conn, "SELECT * FROM booking")
);

/* ===========================
   ARMADA PREMIUM
=========================== */

$mobil = mysqli_query(
    $conn,
    "SELECT *
    FROM mobil
    ORDER BY id DESC"
);

if (!$mobil) {
    die("Query Mobil Error : " . mysqli_error($conn));
}

/* ===========================
   REVIEW
=========================== */

$review = mysqli_query(
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
    ORDER BY review.id DESC
    LIMIT 3"
);

if (!$review) {
    die("Query Review Error : " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
scroll-behavior:smooth;
}

body{

font-family:'Poppins',sans-serif;
background:#050505;
color:#fff;
overflow-x:hidden;

}

/*=========================
NAVBAR
==========================*/

.navbar{

background:rgba(0,0,0,.88);
backdrop-filter:blur(14px);
border-bottom:1px solid rgba(212,175,55,.18);
padding:15px 0;
transition:.35s;

}

.navbar.scrolled{

background:#000;
box-shadow:0 5px 25px rgba(0,0,0,.45);

}

.brand{

font-size:34px;
font-weight:800;
color:#d4af37;
text-decoration:none;
letter-spacing:1px;

}

.brand:hover{

color:#f5d76e;

}

.nav-link{

color:#fff!important;
font-weight:500;
margin:0 10px;
position:relative;
transition:.3s;

}

.nav-link:hover{

color:#d4af37!important;

}

.nav-link::after{

content:'';
position:absolute;
left:0;
bottom:-8px;
height:2px;
width:0;
background:#d4af37;
transition:.35s;

}

.nav-link:hover::after{

width:100%;

}

.btn-login{

border:2px solid #d4af37;
color:#d4af37;
border-radius:30px;
padding:10px 22px;
font-weight:600;
transition:.3s;

}

.btn-login:hover{

background:#d4af37;
color:#000;

}

.btn-register{

background:#d4af37;
color:#000;
border-radius:30px;
padding:10px 24px;
font-weight:700;
transition:.3s;

}

.btn-register:hover{

transform:translateY(-2px);
background:#f1c84b;

}

/*=========================
HERO
==========================*/

.hero{

min-height:100vh;

background:

linear-gradient(

90deg,

rgba(0,0,0,.88),

rgba(0,0,0,.55),

rgba(0,0,0,.18)

),

url('assets/img/hero.jpg');

background-size:cover;
background-position:center;
display:flex;
align-items:center;
padding-top:90px;

}

.hero h1{

font-size:76px;
font-weight:800;
line-height:1.1;

}

.hero p{

margin-top:25px;
font-size:20px;
color:#ddd;
max-width:600px;
line-height:1.8;

}

.btn-gold{

background:#d4af37;
color:#000;
padding:15px 36px;
border-radius:40px;
font-weight:700;
border:none;
transition:.3s;

}

.btn-gold:hover{

transform:translateY(-3px);
box-shadow:0 10px 25px rgba(212,175,55,.25);

}

.btn-outline-gold{

border:2px solid #d4af37;
color:#d4af37;
padding:14px 34px;
border-radius:40px;
transition:.3s;

}

.btn-outline-gold:hover{

background:#d4af37;
color:#000;

}

/*=========================
SECTION
==========================*/

.section{

padding:100px 0;

}

.title{

text-align:center;
font-size:46px;
font-weight:800;
margin-bottom:60px;
color:#fff;

}

.title span{

color:#d4af37;

}

/*=========================
STATISTIC
==========================*/

.stat{

background:#111;
border:1px solid rgba(212,175,55,.15);
border-radius:22px;
padding:40px;
text-align:center;
transition:.35s;

}

.stat:hover{

transform:translateY(-10px);
border-color:#d4af37;

}

.stat h2{

font-size:60px;
color:#d4af37;
font-weight:800;

}

.stat p{

margin-top:10px;
font-size:17px;
color:#bbb;

}

/*=========================
FLEET CARD
==========================*/

.card-gold{

background:#111;
border-radius:22px;
overflow:hidden;
border:1px solid rgba(212,175,55,.12);
transition:.35s;
height:100%;

}

.card-gold:hover{

transform:translateY(-10px);

box-shadow:0 15px 40px rgba(212,175,55,.15);

}

.card-gold img{

width:100%;
height:250px;
object-fit:cover;
transition:.4s;

}

.card-gold:hover img{

transform:scale(1.06);

}

.card-bodyx{

padding:25px;

}

.card-bodyx h4{

font-weight:700;

}

.card-bodyx p{

color:#bbb;

}

/*=========================
REVIEW
==========================*/

.review{

background:#111;
padding:28px;
border-radius:20px;
border:1px solid rgba(212,175,55,.12);
height:100%;
transition:.3s;

}

.review:hover{

transform:translateY(-8px);

}

.review h5{

color:#d4af37;
font-weight:700;

}

.review p{

color:#ddd;

}

/*=========================
FOOTER
==========================*/

footer{

background:#000;
padding:60px 20px;
text-align:center;
border-top:1px solid rgba(212,175,55,.15);

}

footer h3{

color:#d4af37;
font-weight:700;

}

footer p{

color:#aaa;
margin-top:10px;

}

/*=========================
RESPONSIVE
==========================*/

@media(max-width:991px){

.hero{

text-align:center;

}

.hero h1{

font-size:50px;

}

.hero p{

margin:auto;
margin-top:20px;

}

.navbar-nav{

margin-top:20px;
text-align:center;

}

}

@media(max-width:576px){

.hero h1{

font-size:40px;

}

.title{

font-size:34px;

}

}

</style>

</head>
<body>

<!-- =========================
     NAVBAR
========================= -->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark">

<div class="container">

<a class="brand" href="index.php">
<i class="fas fa-car-side me-2"></i>RentGo
</a>

<button class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarMenu">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarMenu">

<ul class="navbar-nav mx-auto">

<li class="nav-item">
<a class="nav-link active" href="index.php">
Home
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="about.php">
About Us
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="contact.php">
Contact
</a>
</li>

</ul>

<div class="d-flex">

<a href="auth/login.php"
class="btn btn-login me-2">

<i class="fas fa-right-to-bracket me-2"></i>

Login

</a>

<a href="auth/register.php"
class="btn btn-register">

<i class="fas fa-user-plus me-2"></i>

Register

</a>

</div>

</div>

</div>

</nav>

<!-- =========================
     HERO
========================= -->

<section class="hero">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-7">

<span class="badge bg-warning text-dark px-3 py-2 mb-3">

Luxury Car Rental

</span>

<h1>

Drive In Luxury
<br>
That Suits You

</h1>

<p>

Nikmati pengalaman rental mobil premium
dengan armada terbaik,
pelayanan profesional,
harga transparan,
serta kenyamanan maksimal
untuk setiap perjalanan Anda.

</p>

<div class="mt-5">

<a href="auth/register.php"
class="btn btn-gold me-3">

<i class="fas fa-calendar-check me-2"></i>

Book Now

</a>

<a href="#fleet"
class="btn btn-outline-gold">

<i class="fas fa-car me-2"></i>

Explore Fleet

</a>

</div>

</div>

</div>

</div>

</section>

<!-- =========================
     STATISTIC
========================= -->

<section class="section">

<div class="container">

<h2 class="title">

Why Choose
<span>RentGo</span>

</h2>

<div class="row g-4">

<div class="col-lg-4">

<div class="stat">

<i class="fas fa-car-side fa-3x mb-3 text-warning"></i>

<h2>

<?= $totalMobil ?>

</h2>

<p>

Premium Cars

</p>

</div>

</div>

<div class="col-lg-4">

<div class="stat">

<i class="fas fa-users fa-3x mb-3 text-warning"></i>

<h2>

<?= $totalUser ?>

</h2>

<p>

Happy Clients

</p>

</div>

</div>

<div class="col-lg-4">

<div class="stat">

<i class="fas fa-road fa-3x mb-3 text-warning"></i>

<h2>

<?= $totalBooking ?>

</h2>

<p>

Completed Rentals

</p>

</div>

</div>

</div>

</div>

</section>

<!-- =========================
     PREMIUM FLEET
========================= -->

<section class="section" id="fleet">

<div class="container">

<h2 class="title">

Our
<span>Premium Fleet</span>

</h2>

<div class="row g-4">

<?php while($m = mysqli_fetch_assoc($mobil)): ?>

<?php

if (
    !empty($m['gambar']) &&
    file_exists('assets/img/mobil/' . $m['gambar'])
) {

    $gambar = 'assets/img/mobil/' . $m['gambar'];

} else {

    $gambar = 'assets/img/hero.jpg';

}

?>

<div class="col-lg-4 col-md-6">

<div class="card-gold">

<img
src="<?= $gambar ?>"
alt="<?= htmlspecialchars($m['nama_mobil']) ?>">

<div class="card-bodyx">

<h4>

<?= htmlspecialchars($m['nama_mobil']) ?>

</h4>

<p>

<?= htmlspecialchars($m['merk']) ?>

•
<?= htmlspecialchars($m['tahun']) ?>

</p>

<div class="mb-3">

<?php if($m['status']=="Tersedia"): ?>

<span class="badge bg-success">

<i class="fas fa-circle-check me-1"></i>

Tersedia

</span>

<?php else: ?>

<span class="badge bg-danger">

<i class="fas fa-circle-xmark me-1"></i>

<?= htmlspecialchars($m['status']) ?>

</span>

<?php endif; ?>

</div>

<h5 class="text-warning fw-bold mb-3">

Rp <?= number_format(
$m['harga_per_hari'],
0,
',',
'.'
); ?>

<span class="text-light fs-6">

/ Hari

</span>

</h5>

<div class="d-grid">

<a
href="auth/register.php"
class="btn btn-gold">

<i class="fas fa-calendar-check me-2"></i>

Book Now

</a>

</div>

</div>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</section>

<!-- =========================
     CUSTOMER REVIEW
========================= -->

<section class="section" id="review">

<div class="container">

<h2 class="title">

Customer
<span>Reviews</span>

</h2>

<div class="row g-4">

<?php while($r=mysqli_fetch_assoc($review)): ?>

<div class="col-lg-4 col-md-6">

<div class="review">

<div class="d-flex align-items-center mb-3">

<div class="me-3">

<i class="fas fa-circle-user fa-3x text-warning"></i>

</div>

<div>

<h5 class="mb-1">

<?= htmlspecialchars($r['nama']) ?>

</h5>

<small class="text-secondary">

<?= htmlspecialchars($r['nama_mobil']) ?>

</small>

</div>

</div>

<div class="mb-3">

<?php for($i=1;$i<=5;$i++): ?>

<?php if($i <= $r['rating']): ?>

<i class="fas fa-star text-warning"></i>

<?php else: ?>

<i class="far fa-star text-warning"></i>

<?php endif; ?>

<?php endfor; ?>

<span class="ms-2 text-light">

<?= $r['rating'] ?>/5

</span>

</div>

<p class="text-light">

<?= htmlspecialchars($r['komentar']) ?>

</p>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</section>

<!-- =========================
     FOOTER
========================= -->

<footer>

<div class="container">

<div class="row">

<div class="col-lg-4 mb-4">

<h3>

<i class="fas fa-car-side me-2"></i>

RentGo

</h3>

<p class="mt-3">

Rental mobil premium dengan pelayanan profesional,
armada berkualitas,
dan pengalaman berkendara terbaik.

</p>

</div>

<div class="col-lg-4 mb-4">

<h5 class="text-warning">

Quick Menu

</h5>

<p>

<a href="index.php" class="text-decoration-none text-light">

Home

</a>

</p>

<p>

<a href="about.php" class="text-decoration-none text-light">

About Us

</a>

</p>

<p>

<a href="contact.php" class="text-decoration-none text-light">

Contact

</a>

</p>

</div>

<div class="col-lg-4 mb-4">

<h5 class="text-warning">

Follow Us

</h5>

<div class="mt-3">

<a href="#" class="text-warning me-3">

<i class="fab fa-facebook fa-2x"></i>

</a>

<a href="#" class="text-warning me-3">

<i class="fab fa-instagram fa-2x"></i>

</a>

<a href="#" class="text-warning me-3">

<i class="fab fa-whatsapp fa-2x"></i>

</a>

<a href="#" class="text-warning">

<i class="fab fa-youtube fa-2x"></i>

</a>

</div>

</div>

</div>

<hr class="border-secondary my-4">

<p class="mb-0 text-center text-secondary">

© <?= date('Y') ?> RentGo Black Gold Luxury.

All Rights Reserved.

</p>

</div>

</footer>

<!-- =========================
     BOOTSTRAP JS
========================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- =========================
     NAVBAR EFFECT
========================= -->

<script>

window.addEventListener("scroll",function(){

const navbar=document.querySelector(".navbar");

if(window.scrollY>60){

navbar.classList.add("scrolled");

}else{

navbar.classList.remove("scrolled");

}

});

</script>

<!-- =========================
     CARD ANIMATION
========================= -->

<script>

const cards=document.querySelectorAll('.card-gold,.stat,.review');

const observer=new IntersectionObserver((entries)=>{

entries.forEach(entry=>{

if(entry.isIntersecting){

entry.target.style.opacity='1';

entry.target.style.transform='translateY(0)';

}

});

});

cards.forEach(card=>{

card.style.opacity='0';

card.style.transform='translateY(40px)';

card.style.transition='all .8s ease';

observer.observe(card);

});

</script>

<!-- =========================
     SMOOTH SCROLL
========================= -->

<script>

document.querySelectorAll('a[href^="#"]').forEach(anchor=>{

anchor.addEventListener('click',function(e){

e.preventDefault();

document.querySelector(this.getAttribute('href')).scrollIntoView({

behavior:'smooth'

});

});

});

</script>

</body>

</html>