<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>About Us | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>

:root{

    --gold:#d4af37;
    --gold-light:#f5d76e;
    --dark:#050505;
    --card:#111111;
    --card2:#1b1b1b;
    --white:#ffffff;
    --gray:#bdbdbd;

}

*{

    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;

}

html{

    scroll-behavior:smooth;

}

body{

    background:var(--dark);
    color:#fff;
    overflow-x:hidden;

}

/* ===========================
        NAVBAR
=========================== */

.navbar{

    background:rgba(5,5,5,.95);

    backdrop-filter:blur(12px);

    border-bottom:1px solid rgba(212,175,55,.15);

    padding:15px 0;

}

.logo{

    color:var(--gold);

    font-size:32px;

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

    min-height:90vh;

    display:flex;

    align-items:center;

    background:

    linear-gradient(
    rgba(0,0,0,.75),
    rgba(0,0,0,.82)
    ),

    url('assets/img/about-bg.jpg');

    background-size:cover;

    background-position:center;

    overflow:hidden;

}

.hero::before{

    content:"";

    position:absolute;

    width:550px;

    height:550px;

    background:rgba(212,175,55,.08);

    border-radius:50%;

    filter:blur(140px);

    right:-180px;

    top:-180px;

}

.hero-content{

    position:relative;

    z-index:2;

}

.hero h5{

    color:var(--gold);

    letter-spacing:3px;

    text-transform:uppercase;

    margin-bottom:20px;

}

.hero h1{

    font-size:64px;

    font-weight:800;

    line-height:1.2;

    margin-bottom:25px;

}

.hero h1 span{

    color:var(--gold);

}

.hero p{

    color:#dddddd;

    font-size:18px;

    line-height:1.9;

    max-width:650px;

}

.btn-gold{

    background:linear-gradient(135deg,var(--gold),#b98d12);

    color:#000;

    border:none;

    padding:14px 34px;

    border-radius:12px;

    font-weight:700;

    transition:.35s;

}

.btn-gold:hover{

    color:#000;

    transform:translateY(-3px);

    box-shadow:0 15px 30px rgba(212,175,55,.25);

}

/* ===========================
        SECTION
=========================== */

.section{

    padding:90px 0;

}

.section-title{

    color:var(--gold);

    font-size:40px;

    font-weight:800;

    margin-bottom:20px;

}

.section-subtitle{

    color:var(--gray);

    max-width:700px;

    margin:auto;

    line-height:1.9;

}

/* ===========================
        PREMIUM CARD
=========================== */

.premium-card{

    background:linear-gradient(
    145deg,
    var(--card),
    var(--card2)
    );

    border:1px solid rgba(212,175,55,.15);

    border-radius:22px;

    padding:35px;

    transition:.35s;

    height:100%;

    box-shadow:0 15px 40px rgba(0,0,0,.45);

}

.premium-card:hover{

    transform:translateY(-10px);

    border-color:var(--gold);

}

.premium-card i{

    width:80px;

    height:80px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:rgba(212,175,55,.08);

    color:var(--gold);

    border-radius:20px;

    font-size:34px;

    margin-bottom:25px;

}

.premium-card h4{

    margin-bottom:15px;

    font-weight:700;

}

.premium-card p{

    color:#bfbfbf;

    line-height:1.8;

}

/* ===========================
        STATISTIC
=========================== */

.stat-card{

    background:#111;

    border:1px solid rgba(212,175,55,.18);

    border-radius:22px;

    padding:35px;

    text-align:center;

    transition:.35s;

}

.stat-card:hover{

    transform:translateY(-8px);

}

.stat-card h2{

    color:var(--gold);

    font-size:48px;

    font-weight:800;

}

.stat-card p{

    color:#bbb;

    margin-top:10px;

}

/* ===========================
        TEAM CARD
=========================== */

.team-card{

    background:#111;

    border-radius:22px;

    overflow:hidden;

    border:1px solid rgba(212,175,55,.15);

    transition:.35s;

}

.team-card:hover{

    transform:translateY(-10px);

}

.team-card img{

    width:100%;

    height:320px;

    object-fit:cover;

}

.team-info{

    padding:25px;

    text-align:center;

}

.team-info h5{

    margin-bottom:8px;

    font-weight:700;

}

.team-info span{

    color:var(--gold);

}

/* ===========================
        CTA
=========================== */

.cta{

    background:linear-gradient(
    135deg,
    #111,
    #1c1c1c
    );

    border-radius:25px;

    border:1px solid rgba(212,175,55,.15);

    padding:60px;

    text-align:center;

}

.cta h2{

    font-weight:800;

    margin-bottom:20px;

}

.cta p{

    color:#cfcfcf;

    margin-bottom:30px;

}

/* ===========================
        FOOTER
=========================== */

.footer{

    margin-top:90px;

    border-top:1px solid rgba(212,175,55,.15);

    padding:40px;

    text-align:center;

    color:#999;

}

.footer h4{

    color:var(--gold);

    margin-bottom:10px;

}

/* ===========================
        RESPONSIVE
=========================== */

@media(max-width:768px){

.hero{

    min-height:75vh;

    text-align:center;

}

.hero h1{

    font-size:42px;

}

.section-title{

    font-size:32px;

}

.hero p{

    font-size:16px;

}

}

</style>

</head>

<body>

<!-- ===========================
            NAVBAR
=========================== -->

<nav class="navbar navbar-expand-lg fixed-top">

<div class="container">

<a href="index.php" class="logo">

<i class="fas fa-car-side me-2"></i>

RentGo

</a>

<button class="navbar-toggler bg-warning" type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarNav">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav ms-auto align-items-lg-center">

<li class="nav-item">

<a class="nav-link text-white mx-2" href="index.php">

Home

</a>

</li>

<li class="nav-item">

<a class="nav-link text-warning fw-bold mx-2" href="about.php">

About

</a>

</li>

<li class="nav-item">

<a class="nav-link text-white mx-2" href="contact.php">

Contact

</a>

</li>

<li class="nav-item ms-lg-3">

<a href="auth/login.php" class="btn btn-gold">

<i class="fas fa-right-to-bracket me-2"></i>

Login

</a>

</li>

</ul>

</div>

</div>

</nav>

<!-- ===========================
            HERO
=========================== -->

<section class="hero">

<div class="container">

<div class="hero-content">

<h5>

WELCOME TO RENTGO

</h5>

<h1>

Luxury Car Rental

<span>Experience</span>

</h1>

<p>

RentGo Black Gold Luxury merupakan perusahaan rental mobil premium
yang menghadirkan armada berkualitas tinggi, pelayanan profesional,
serta sistem pemesanan digital yang cepat, aman, dan mudah digunakan.
Kami percaya bahwa setiap perjalanan layak mendapatkan kenyamanan,
keamanan, dan kemewahan.

</p>

<div class="mt-4">

<a href="contact.php" class="btn btn-gold">

<i class="fas fa-phone me-2"></i>

Hubungi Kami

</a>

</div>

</div>

</div>

</section>

<!-- ===========================
        ABOUT COMPANY
=========================== -->

<section class="section">

<div class="container">

<div class="text-center mb-5">

<h2 class="section-title">

Tentang RentGo

</h2>

<p class="section-subtitle">

RentGo Black Gold Luxury adalah perusahaan penyedia layanan rental
mobil premium yang berkomitmen memberikan pengalaman berkendara yang
aman, nyaman, dan berkelas. Dengan armada kendaraan terbaik serta
pelayanan profesional, kami siap menjadi solusi transportasi untuk
kebutuhan bisnis, perjalanan keluarga, wisata, hingga acara khusus.

</p>

</div>

<div class="row g-4">

<div class="col-lg-6">

<div class="premium-card">

<i class="fas fa-eye"></i>

<h4>

Visi

</h4>

<p>

Menjadi perusahaan rental mobil premium terpercaya di Indonesia
yang mengutamakan kualitas pelayanan, keamanan pelanggan,
serta inovasi teknologi dalam setiap proses penyewaan kendaraan.

</p>

</div>

</div>

<div class="col-lg-6">

<div class="premium-card">

<i class="fas fa-bullseye"></i>

<h4>

Misi

</h4>

<p>

• Menyediakan armada kendaraan yang selalu dalam kondisi terbaik.<br>

• Memberikan pelayanan yang cepat, ramah, dan profesional.<br>

• Menghadirkan sistem pemesanan berbasis digital yang modern.<br>

• Menjamin keamanan serta kenyamanan pelanggan selama perjalanan.

</p>

</div>

</div>

</div>

</div>

</section>

<!-- ===========================
        WHY CHOOSE US
=========================== -->

<section class="section pt-0">

<div class="container">

<div class="text-center mb-5">

<h2 class="section-title">

Mengapa Memilih RentGo?

</h2>

<p class="section-subtitle">

Kami menghadirkan pengalaman rental mobil premium dengan pelayanan
berkualitas tinggi dan teknologi modern.

</p>

</div>

<div class="row g-4">

<div class="col-lg-4 col-md-6">

<div class="premium-card">

<i class="fas fa-car-side"></i>

<h4>

Armada Premium

</h4>

<p>

Berbagai pilihan kendaraan terbaru dengan kondisi prima dan
siap digunakan kapan saja.

</p>

</div>

</div>

<div class="col-lg-4 col-md-6">

<div class="premium-card">

<i class="fas fa-shield-halved"></i>

<h4>

Keamanan Terjamin

</h4>

<p>

Seluruh kendaraan melalui proses inspeksi berkala sehingga
tetap aman dan nyaman digunakan.

</p>

</div>

</div>

<div class="col-lg-4 col-md-6">

<div class="premium-card">

<i class="fas fa-clock"></i>

<h4>

Layanan 24 Jam

</h4>

<p>

Customer service siap membantu pelanggan kapan saja selama
24 jam penuh.

</p>

</div>

</div>

<div class="col-lg-4 col-md-6">

<div class="premium-card">

<i class="fas fa-wallet"></i>

<h4>

Harga Kompetitif

</h4>

<p>

Harga transparan tanpa biaya tersembunyi dengan kualitas
layanan terbaik.

</p>

</div>

</div>

<div class="col-lg-4 col-md-6">

<div class="premium-card">

<i class="fas fa-calendar-check"></i>

<h4>

Booking Online

</h4>

<p>

Pemesanan kendaraan dapat dilakukan kapan saja melalui
website RentGo.

</p>

</div>

</div>

<div class="col-lg-4 col-md-6">

<div class="premium-card">

<i class="fas fa-headset"></i>

<h4>

Support Profesional

</h4>

<p>

Tim kami selalu siap membantu mulai dari proses booking
hingga penyewaan selesai.

</p>

</div>

</div>

</div>

</div>

</section>

<!-- ===========================
        COMPANY STATISTIC
=========================== -->

<section class="section pt-0">

<div class="container">

<div class="text-center mb-5">

<h2 class="section-title">

RentGo Dalam Angka

</h2>

</div>

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<h2>1000+</h2>

<p>Pelanggan Puas</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<h2>150+</h2>

<p>Armada Mobil</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<h2>98%</h2>

<p>Customer Satisfaction</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card">

<h2>24/7</h2>

<p>Customer Support</p>

</div>

</div>

</div>

</div>

</section>

<!-- ===========================
            OUR TEAM
=========================== -->

<section class="section pt-0">

<div class="container">

<div class="text-center mb-5">

<h2 class="section-title">

Tim Profesional Kami

</h2>

<p class="section-subtitle">

RentGo didukung oleh tim yang berpengalaman dan profesional
untuk memberikan pelayanan terbaik kepada setiap pelanggan.

</p>

</div>

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<div class="team-card">

<img src="assets/img/team1.jpg" alt="CEO">

<div class="team-info">

<h5>

Andi Pratama

</h5>

<span>

Chief Executive Officer

</span>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="team-card">

<img src="assets/img/team2.jpg" alt="Manager">

<div class="team-info">

<h5>

Budi Santoso

</h5>

<span>

Operational Manager

</span>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="team-card">

<img src="assets/img/team3.jpg" alt="Customer Service">

<div class="team-info">

<h5>

Citra Lestari

</h5>

<span>

Customer Service

</span>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="team-card">

<img src="assets/img/team4.jpg" alt="Driver">

<div class="team-info">

<h5>

Dedi Saputra

</h5>

<span>

Professional Driver

</span>

</div>

</div>

</div>

</div>

</div>

</section>

<!-- ===========================
        CALL TO ACTION
=========================== -->

<section class="container mb-5">

<div class="cta">

<h2>

<i class="fas fa-crown text-warning me-2"></i>

Siap Menemukan Mobil Impian Anda?

</h2>

<p>

Nikmati pengalaman rental mobil premium dengan armada terbaik,
pelayanan profesional, dan proses booking yang cepat serta aman.
Bergabunglah bersama ribuan pelanggan yang telah mempercayakan
perjalanannya kepada RentGo Black Gold Luxury.

</p>

<div class="mt-4">

<a href="auth/login.php" class="btn btn-gold me-3">

<i class="fas fa-car me-2"></i>

Booking Sekarang

</a>

<a href="contact.php" class="btn btn-outline-light">

<i class="fas fa-phone me-2"></i>

Hubungi Kami

</a>

</div>

</div>

</section>

<!-- ===========================
            FOOTER
=========================== -->

<footer class="footer">

<div class="container">

<div class="row">

<div class="col-lg-4 mb-4">

<h4>

<i class="fas fa-car-side me-2"></i>

RentGo

</h4>

<p>

Premium Car Rental dengan pelayanan profesional,
armada berkualitas, dan pengalaman berkendara
yang aman serta nyaman.

</p>

</div>

<div class="col-lg-4 mb-4">

<h4>

Menu

</h4>

<p>

<a href="index.php" class="text-decoration-none text-secondary">

Home

</a>

</p>

<p>

<a href="about.php" class="text-decoration-none text-secondary">

About Us

</a>

</p>

<p>

<a href="contact.php" class="text-decoration-none text-secondary">

Contact

</a>

</p>

</div>

<div class="col-lg-4 mb-4">

<h4>

Ikuti Kami

</h4>

<div class="mt-3">

<a href="#" class="text-warning fs-3 me-3">

<i class="fab fa-facebook"></i>

</a>

<a href="#" class="text-warning fs-3 me-3">

<i class="fab fa-instagram"></i>

</a>

<a href="#" class="text-warning fs-3 me-3">

<i class="fab fa-youtube"></i>

</a>

<a href="#" class="text-warning fs-3">

<i class="fab fa-tiktok"></i>

</a>

</div>

</div>

</div>

<hr class="border-secondary">

<p class="text-center text-secondary mb-0">

© <?= date('Y'); ?>

RentGo Black Gold Luxury.

All Rights Reserved.

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

/* ===========================
      CARD ANIMATION
=========================== */

document.querySelectorAll('.premium-card,.team-card,.stat-card').forEach(card=>{

card.addEventListener('mouseenter',()=>{

card.style.transform='translateY(-10px)';

});

card.addEventListener('mouseleave',()=>{

card.style.transform='translateY(0)';

});

});

/* ===========================
        COUNTER EFFECT
=========================== */

const stats=document.querySelectorAll('.stat-card h2');

stats.forEach(stat=>{

stat.style.transition=".6s";

});

/* ===========================
        SMOOTH NAVBAR
=========================== */

window.addEventListener("scroll",function(){

const nav=document.querySelector(".navbar");

if(window.scrollY>80){

nav.style.background="rgba(5,5,5,.98)";
nav.style.boxShadow="0 10px 30px rgba(0,0,0,.35)";

}else{

nav.style.background="rgba(5,5,5,.95)";
nav.style.boxShadow="none";

}

});

</script>

</body>

</html>