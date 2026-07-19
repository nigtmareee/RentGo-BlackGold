<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$booking_id = isset($_GET['booking_id'])
    ? (int)$_GET['booking_id']
    : 0;

$data = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        mobil.nama_mobil
    FROM booking
    JOIN mobil
        ON booking.mobil_id = mobil.id
    WHERE booking.id='$booking_id'"
);

$booking = mysqli_fetch_assoc($data);

if (!$booking) {
    die("Booking tidak ditemukan.");
}

if ($booking['status'] != 'Selesai') {
    die("Review hanya dapat diberikan setelah rental selesai.");
}

$cekReview = mysqli_query(
    $conn,
    "SELECT *
    FROM review
    WHERE booking_id='$booking_id'"
);

if (mysqli_num_rows($cekReview) > 0) {
    die("Review untuk booking ini sudah pernah diberikan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>

Review Mobil | RentGo Black Gold Luxury

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

min-height:38vh;

display:flex;

align-items:center;

justify-content:center;

text-align:center;

background:
linear-gradient(
rgba(0,0,0,.74),
rgba(0,0,0,.84)
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

background:rgba(212,175,55,.05);

border-radius:50%;

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
        REVIEW CARD
=========================== */

.review-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid rgba(212,175,55,.15);

border-radius:25px;

padding:35px;

box-shadow:0 20px 40px rgba(0,0,0,.35);

}

/* ===========================
      INFO BOX
=========================== */

.info-box{

background:#181818;

border-left:5px solid var(--gold);

border-radius:15px;

padding:20px;

margin-bottom:30px;

}

/* ===========================
      FORM
=========================== */

label{

font-weight:600;

margin-bottom:8px;

display:block;

}

.form-control{

background:#181818 !important;

border:1px solid #333 !important;

color:#fff !important;

border-radius:12px;

padding:12px 15px;

}

.form-control:focus{

border-color:var(--gold) !important;

box-shadow:0 0 0 .15rem rgba(212,175,55,.15);

}

/* ===========================
      STAR RATING
=========================== */

.star-rating{

display:flex;

justify-content:center;

gap:12px;

margin:20px 0;

}

.star-rating i{

font-size:40px;

color:#555;

cursor:pointer;

transition:.25s;

}

.star-rating i:hover{

transform:scale(1.15);

}

.star-rating i.active{

color:var(--gold);

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

padding:14px;

border-radius:14px;

transition:.3s;

}

.btn-gold:hover{

color:#000;

transform:translateY(-3px);

box-shadow:0 12px 25px rgba(212,175,55,.25);

}

.btn-outline-gold{

border:1px solid var(--gold);

color:var(--gold);

border-radius:14px;

padding:12px;

transition:.3s;

}

.btn-outline-gold:hover{

background:var(--gold);

color:#000;

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

.review-card{

padding:22px;

}

.star-rating i{

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

<div class="ms-auto">

<a
href="../booking/riwayat.php"
class="btn btn-outline-gold me-2">

<i class="fas fa-clock-rotate-left me-2"></i>

Riwayat

</a>

<a
href="../../auth/logout.php"
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

Beri

<span>

Review

</span>

</h1>

<p>

Bagikan pengalaman Anda setelah menggunakan layanan RentGo Black Gold Luxury.

</p>

</div>

</section>

<!-- ===========================
        CONTENT
=========================== -->

<section class="section">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="review-card">

<h3 class="text-warning mb-4">

<i class="fas fa-star me-2"></i>

Review Kendaraan

</h3>

<div class="info-box">

<h4 class="mb-3">

<i class="fas fa-car-side me-2 text-warning"></i>

<?= htmlspecialchars($booking['nama_mobil']); ?>

</h4>

<p class="mb-2">

<strong>Booking ID :</strong>

<?= $booking['id']; ?>

</p>

<p class="mb-0 text-secondary">

Terima kasih telah menggunakan layanan RentGo Black Gold Luxury.
Masukan Anda akan membantu kami meningkatkan kualitas pelayanan.

</p>

</div>

<form action="simpan.php" method="POST">

<input
type="hidden"
name="booking_id"
value="<?= $booking['id']; ?>">

<input
type="hidden"
name="mobil_id"
value="<?= $booking['mobil_id']; ?>">

<input
type="hidden"
name="rating"
id="rating"
required>

<div class="mb-4">

<label>

<i class="fas fa-star text-warning me-2"></i>

Berikan Rating

</label>

<div class="star-rating">

<i class="fas fa-star"
data-value="1"></i>

<i class="fas fa-star"
data-value="2"></i>

<i class="fas fa-star"
data-value="3"></i>

<i class="fas fa-star"
data-value="4"></i>

<i class="fas fa-star"
data-value="5"></i>

</div>

<div class="text-center">

<small
id="ratingText"
class="text-secondary">

Silakan pilih rating.

</small>

</div>

</div>

<div class="mb-4">

<label>

<i class="fas fa-comment-dots text-warning me-2"></i>

Komentar

</label>

<textarea
name="komentar"
class="form-control"
rows="6"
placeholder="Bagikan pengalaman Anda selama menggunakan kendaraan ini..."
required></textarea>

</div>

<div class="d-grid gap-3 mt-4">

    <button
        type="submit"
        class="btn btn-gold btn-lg">

        <i class="fas fa-paper-plane me-2"></i>

        Kirim Review

    </button>

    <a
        href="../booking/riwayat.php"
        class="btn btn-outline-gold btn-lg">

        <i class="fas fa-arrow-left me-2"></i>

        Kembali ke Riwayat

    </a>

</div>

</form>

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

Terima kasih telah mempercayakan perjalanan Anda bersama RentGo.
Setiap ulasan yang Anda berikan sangat berarti untuk membantu kami
meningkatkan kualitas kendaraan dan pelayanan di masa mendatang.

</p>

<hr class="border-secondary my-4">

<p class="mb-0 text-secondary">

&copy; <?= date('Y'); ?> RentGo Black Gold Luxury.
All Rights Reserved.

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

/* ===========================
      STAR RATING
=========================== */

const stars = document.querySelectorAll('.star-rating i');

const ratingInput = document.getElementById('rating');

const ratingText = document.getElementById('ratingText');

const ratingLabel = {
    1: "Sangat Buruk",
    2: "Buruk",
    3: "Cukup",
    4: "Baik",
    5: "Sangat Baik"
};

stars.forEach(star => {

    star.addEventListener('click', function(){

        const value = this.dataset.value;

        ratingInput.value = value;

        stars.forEach(s => {

            if(s.dataset.value <= value){

                s.classList.add('active');

            }else{

                s.classList.remove('active');

            }

        });

        ratingText.innerHTML =
            "Rating : <strong>" +
            value +
            "/5</strong> (" +
            ratingLabel[value] +
            ")";

    });

});

</script>

</body>

</html>