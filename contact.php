<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Contact Us | RentGo Black Gold Luxury</title>

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
=========================*/

.navbar{

background:rgba(0,0,0,.88);
backdrop-filter:blur(15px);
border-bottom:1px solid rgba(212,175,55,.15);
padding:15px 0;
transition:.35s;

}

.navbar.scrolled{

background:#000;
box-shadow:0 8px 25px rgba(0,0,0,.4);

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
margin:0 12px;
position:relative;
transition:.3s;

}

.nav-link:hover{

color:#d4af37!important;

}

.nav-link::after{

content:"";
position:absolute;
left:0;
bottom:-8px;
width:0;
height:2px;
background:#d4af37;
transition:.35s;

}

.nav-link:hover::after{

width:100%;

}

.btn-login{

border:2px solid #d4af37;
color:#d4af37;
border-radius:35px;
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
border-radius:35px;
padding:10px 24px;
font-weight:700;
transition:.3s;

}

.btn-register:hover{

background:#f3cb54;
transform:translateY(-2px);

}

/*=========================
HERO
=========================*/

.hero{

height:60vh;

background:

linear-gradient(

90deg,

rgba(0,0,0,.90),

rgba(0,0,0,.55),

rgba(0,0,0,.20)

),

url('assets/img/contact-bg.jpg');

background-size:cover;
background-position:center;

display:flex;
align-items:center;

padding-top:90px;

}

.hero h1{

font-size:64px;
font-weight:800;
margin-bottom:20px;

}

.hero p{

font-size:19px;
max-width:650px;
line-height:1.8;
color:#ddd;

}

/*=========================
SECTION
=========================*/

.section{

padding:100px 0;

}

.title{

font-size:44px;
font-weight:800;
text-align:center;
margin-bottom:60px;

}

.title span{

color:#d4af37;

}

/*=========================
CARD
=========================*/

.contact-card{

background:#111;
border-radius:20px;
padding:35px;
border:1px solid rgba(212,175,55,.15);
transition:.35s;
height:100%;

}

.contact-card:hover{

transform:translateY(-8px);

border-color:#d4af37;

box-shadow:0 20px 40px rgba(212,175,55,.12);

}

.contact-card i{

font-size:42px;
color:#d4af37;
margin-bottom:20px;

}

.contact-card h4{

font-weight:700;
margin-bottom:15px;

}

.contact-card p{

color:#bbb;
line-height:1.8;

}

/*=========================
FORM
=========================*/

.form-box{

background:#111;
padding:40px;
border-radius:20px;
border:1px solid rgba(212,175,55,.15);

}

.form-control{

background:#191919;
border:1px solid #333;
color:#fff;
padding:14px;

}

.form-control:focus{

background:#191919;
color:#fff;
border-color:#d4af37;
box-shadow:none;

}

textarea.form-control{

min-height:180px;

}

.btn-gold{

background:#d4af37;
border:none;
color:#000;
padding:14px 36px;
font-weight:700;
border-radius:40px;
transition:.3s;

}

.btn-gold:hover{

transform:translateY(-3px);
box-shadow:0 12px 25px rgba(212,175,55,.25);

}

/*=========================
MAP
=========================*/

.map-box{

border-radius:20px;
overflow:hidden;
border:1px solid rgba(212,175,55,.15);

}

.map-box iframe{

width:100%;
height:450px;
border:0;

}

/*=========================
FOOTER
=========================*/

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
margin-top:12px;

}

/*=========================
RESPONSIVE
=========================*/

@media(max-width:991px){

.hero{

text-align:center;

}

.hero h1{

font-size:46px;

}

.hero p{

margin:auto;

}

}

@media(max-width:576px){

.hero h1{

font-size:36px;

}

.title{

font-size:32px;

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

<i class="fas fa-car-side me-2"></i>

RentGo

</a>

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbarMenu">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbarMenu">

<ul class="navbar-nav mx-auto">

<li class="nav-item">

<a class="nav-link" href="index.php">

Home

</a>

</li>

<li class="nav-item">

<a class="nav-link" href="about.php">

About Us

</a>

</li>

<li class="nav-item">

<a class="nav-link active" href="contact.php">

Contact

</a>

</li>

</ul>

<div class="d-flex">

<a href="auth/login.php" class="btn btn-login me-2">

<i class="fas fa-right-to-bracket me-2"></i>

Login

</a>

<a href="auth/register.php" class="btn btn-register">

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

<div class="row">

<div class="col-lg-8">

<span class="badge bg-warning text-dark px-3 py-2 mb-3">

Contact RentGo Luxury

</span>

<h1>

Contact Us

</h1>

<p>

Kami siap membantu kebutuhan rental mobil Anda.
Hubungi tim RentGo Black Gold Luxury untuk informasi,
reservasi maupun kerja sama bisnis.

</p>

</div>

</div>

</div>

</section>

<!-- =========================
     CONTACT INFO
========================= -->

<section class="section">

<div class="container">

<h2 class="title">

Get In
<span>Touch</span>

</h2>

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<div class="contact-card text-center">

<i class="fas fa-location-dot"></i>

<h4>

Office

</h4>

<p>

Jl. Nightmare No.88<br>

Medan<br>

Sumatera Utara

</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="contact-card text-center">

<i class="fas fa-phone"></i>

<h4>

Phone

</h4>

<p>

+62 812-1447-1886<br>

+62 852-6881-7441

</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="contact-card text-center">

<i class="fas fa-envelope"></i>

<h4>

Email

</h4>

<p>

info@rentgo.com

<br>

support@rentgo.com

</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="contact-card text-center">

<i class="fas fa-clock"></i>

<h4>

Open Hours

</h4>

<p>

Senin - Minggu

<br>

08.00 - 22.00 WIB

</p>

</div>

</div>

</div>

</div>

</section>

<!-- =========================
     GOOGLE MAP
========================= -->

<section class="pb-5">

<div class="container">

<h2 class="title">

Our
<span>Location</span>

</h2>

<div class="map-box">

<iframe

src="https://www.google.com/maps?q=Medan&output=embed"

allowfullscreen=""

loading="lazy">

</iframe>

</div>

</div>

</section>

<!-- =========================
     CONTACT FORM
========================= -->

<section class="section pt-0">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="form-box">

<h2 class="text-center mb-4">

Send Message

</h2>

<form>

<div class="row">

<div class="col-md-6 mb-3">

<input
type="text"
class="form-control"
placeholder="Full Name">

</div>

<div class="col-md-6 mb-3">

<input
type="email"
class="form-control"
placeholder="Email Address">

</div>

</div>

<div class="mb-3">

<input
type="text"
class="form-control"
placeholder="Subject">

</div>

<div class="mb-4">

<textarea
class="form-control"
placeholder="Write your message here..."></textarea>

</div>

<div class="text-center">

<button
type="submit"
class="btn btn-gold">

<i class="fas fa-paper-plane me-2"></i>

Send Message

</button>

</div>

</form>

</div>

</div>

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
armada terbaik,
harga kompetitif,
dan pengalaman berkendara yang nyaman serta aman.

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

<p>

<a href="auth/login.php" class="text-decoration-none text-light">

Login

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

<p class="mt-4 text-secondary">

Email :
info@rentgo.com

<br>

Phone :
+62 812-1447-1886

</p>

</div>

</div>

<hr class="border-secondary my-4">

<p class="text-center text-secondary mb-0">

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
NAVBAR SCROLL EFFECT
========================= -->

<script>

window.addEventListener("scroll",function(){

const navbar=document.querySelector(".navbar");

if(window.scrollY>50){

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

const observer=new IntersectionObserver(function(entries){

entries.forEach(function(entry){

if(entry.isIntersecting){

entry.target.style.opacity="1";

entry.target.style.transform="translateY(0)";

}

});

});

document.querySelectorAll(".contact-card,.form-box,.map-box").forEach(function(el){

el.style.opacity="0";

el.style.transform="translateY(40px)";

el.style.transition=".8s";

observer.observe(el);

});

</script>

<!-- =========================
SMOOTH SCROLL
========================= -->

<script>

document.querySelectorAll('a[href^="#"]').forEach(anchor=>{

anchor.addEventListener("click",function(e){

e.preventDefault();

const target=document.querySelector(this.getAttribute("href"));

if(target){

target.scrollIntoView({

behavior:"smooth"

});

}

});

});

</script>

</body>

</html>