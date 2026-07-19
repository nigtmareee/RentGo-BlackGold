<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT no_hp, alamat
        FROM users
        WHERE id='$user_id'"
    )
);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_query(
    $conn,
    "SELECT * FROM mobil WHERE id = $id"
);

if (!$query) {
    die("Query Error : " . mysqli_error($conn));
}

$mobil = mysqli_fetch_assoc($query);

if (!$mobil) {
    die("Mobil tidak ditemukan.");
}

if ($mobil['status'] != 'Tersedia') {

    echo "
    <script>
        alert('Mobil sedang disewa dan tidak dapat dibooking.');
        window.location='../mobil/index.php';
    </script>
    ";

    exit;
}

/* =========================
   GAMBAR MOBIL
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
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Booking Mobil | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

--gold:#d4af37;
--gold2:#f4d46b;
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

body{

background:var(--dark);
color:var(--text);
overflow-x:hidden;

}

html{

scroll-behavior:smooth;

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

color:var(--gold2);

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

filter:blur(110px);

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
        LUXURY CARD
=========================== */

.luxury-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid rgba(212,175,55,.15);

border-radius:25px;

padding:30px;

box-shadow:0 20px 40px rgba(0,0,0,.35);

transition:.35s;

height:100%;

}

.luxury-card:hover{

transform:translateY(-4px);

border-color:rgba(212,175,55,.35);

}

/* ===========================
        IMAGE
=========================== */

.car-image{

width:100%;

height:330px;

object-fit:cover;

border-radius:20px;

border:1px solid rgba(212,175,55,.20);

box-shadow:0 15px 30px rgba(0,0,0,.40);

}

/* ===========================
        PRICE
=========================== */

.price{

font-size:38px;

font-weight:900;

color:var(--gold);

margin-top:20px;

}

.price span{

font-size:16px;

font-weight:400;

color:#ccc;

}

/* ===========================
        FORM
=========================== */

label{

font-weight:600;

margin-bottom:8px;

display:block;

color:#eee;

}

.form-control,
textarea{

background:#181818 !important;

border:1px solid #333 !important;

color:#fff !important;

border-radius:12px;

padding:12px 15px;

}

.form-control:focus,
textarea:focus{

border-color:var(--gold) !important;

box-shadow:0 0 0 .15rem rgba(212,175,55,.15);

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

transform:translateY(-3px);

color:#000;

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
        TITLE
=========================== */

.card-title{

font-size:26px;

font-weight:700;

margin-bottom:25px;

color:var(--gold);

}

/* ===========================
        RESPONSIVE
=========================== */

@media(max-width:768px){

.hero h1{

font-size:42px;

}

.car-image{

height:240px;

}

.price{

font-size:30px;

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

<a href="../mobil/index.php" class="btn btn-outline-gold me-2">

<i class="fas fa-arrow-left me-2"></i>

Kembali

</a>

<a href="../../auth/logout.php" class="btn btn-gold">

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

Book Your

<span>

Luxury Ride

</span>

</h1>

<p>

Lengkapi data penyewaan dan nikmati pengalaman berkendara premium bersama RentGo Black Gold Luxury.

</p>

</div>

</section>

<!-- ===========================
        CONTENT
=========================== -->

<section class="section">

<div class="container">

<div class="row g-4">

<!-- ===========================
        INFORMASI MOBIL
=========================== -->

<div class="col-lg-4">

<div class="luxury-card">

<img
src="<?= $gambar ?>"
class="car-image"
alt="<?= htmlspecialchars($mobil['nama_mobil']) ?>">

<h3 class="mt-4 mb-3">

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h3>

<hr class="border-secondary">

<p>

<i class="fas fa-industry text-warning me-2"></i>

<strong>Merk :</strong>

<?= htmlspecialchars($mobil['merk']) ?>

</p>

<p>

<i class="fas fa-calendar text-warning me-2"></i>

<strong>Tahun :</strong>

<?= htmlspecialchars($mobil['tahun']) ?>

</p>

<p>

<i class="fas fa-gears text-warning me-2"></i>

<strong>Transmisi :</strong>

<?= htmlspecialchars($mobil['transmisi']) ?>

</p>

<p>

<i class="fas fa-circle-check text-success me-2"></i>

<strong>Status :</strong>

<span class="badge bg-success">

<?= htmlspecialchars($mobil['status']) ?>

</span>

</p>

<div class="price">

Rp <?= number_format(
$mobil['harga_per_hari'],
0,
',',
'.'
); ?>

<span>

/ Hari

</span>

</div>

<hr class="border-secondary my-4">

<p class="text-secondary mb-0">

<i class="fas fa-shield-halved text-warning me-2"></i>

Semua kendaraan telah melalui proses inspeksi dan perawatan berkala untuk memberikan kenyamanan maksimal selama perjalanan Anda.

</p>

</div>

</div>

<!-- ===========================
        FORM BOOKING
=========================== -->

<div class="col-lg-8">

<form action="proses_booking.php" method="POST">

<input
type="hidden"
name="mobil_id"
value="<?= $mobil['id'] ?>">

<div class="luxury-card mb-4">

<h3 class="card-title">

<i class="fas fa-user me-2"></i>

Data Penyewa

</h3>

<div class="row">

<div class="col-md-6 mb-3">

<label>

<i class="fas fa-phone me-2 text-warning"></i>

Nomor HP

</label>

<input
type="text"
name="no_hp"
class="form-control"
required
value="<?= htmlspecialchars($user['no_hp'] ?? '') ?>">

</div>

<div class="col-md-6 mb-3">

<label>

<i class="fas fa-user me-2 text-warning"></i>

Nama Penyewa

</label>

<input
type="text"
class="form-control"
value="<?= htmlspecialchars($_SESSION['nama']) ?>"
readonly>

</div>

</div>

<div class="mb-3">

<label>

<i class="fas fa-location-dot me-2 text-warning"></i>

Alamat Lengkap

</label>

<textarea
name="alamat"
rows="5"
class="form-control"
required><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>

</div>

</div>

<!-- ===========================
        DATA RENTAL
=========================== -->

<div class="luxury-card">

<h3 class="card-title">

<i class="fas fa-calendar-check me-2"></i>

Data Rental

</h3>

<div class="row">

<div class="col-md-6 mb-3">

<label>

<i class="fas fa-calendar-day text-warning me-2"></i>

Tanggal Mulai

</label>

<input
type="date"
name="tanggal_mulai"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>

<i class="fas fa-calendar-week text-warning me-2"></i>

Tanggal Selesai

</label>

<input
type="date"
name="tanggal_selesai"
class="form-control"
required>

</div>

</div>

<hr class="border-secondary my-4">

<div class="row align-items-center">

<div class="col-md-8">

<div class="p-4 rounded"
style="background:rgba(212,175,55,.08);
border:1px solid rgba(212,175,55,.18);">

<h5 class="text-warning mb-3">

<i class="fas fa-circle-info me-2"></i>

Informasi Booking

</h5>

<ul class="mb-0 text-light" style="line-height:2;">

<li>
Pastikan tanggal yang dipilih sesuai kebutuhan perjalanan Anda.
</li>

<li>
Harga sewa dihitung berdasarkan jumlah hari penyewaan.
</li>

<li>
Pembayaran dilakukan setelah booking berhasil dibuat.
</li>

<li>
Admin akan melakukan verifikasi pembayaran sebelum kendaraan dapat digunakan.
</li>

</ul>

</div>

</div>

<div class="col-md-4 text-center mt-4 mt-md-0">

<h6 class="text-secondary mb-2">

Harga Mulai

</h6>

<div class="price">

Rp <?= number_format(
$mobil['harga_per_hari'],
0,
',',
'.'
); ?>

<span>/ Hari</span>

</div>

</div>

</div>

<div class="d-grid gap-3 mt-5">

<button
type="submit"
class="btn btn-gold btn-lg">

<i class="fas fa-calendar-check me-2"></i>

Booking Sekarang

</button>

<a
href="../mobil/index.php"
class="btn btn-outline-gold btn-lg">

<i class="fas fa-arrow-left me-2"></i>

Kembali ke Daftar Mobil

</a>

</div>

</div>

</form>

</div>

</div>

</div>

</section>

<!-- ===========================
        FOOTER
=========================== -->

<footer class="py-5 mt-5"
style="border-top:1px solid rgba(212,175,55,.15);
background:#080808;">

<div class="container text-center">

<h4 class="mb-3 text-warning">

<i class="fas fa-car-side me-2"></i>

RentGo Black Gold Luxury

</h4>

<p class="text-secondary mb-3">

Premium Car Rental Experience

</p>

<div class="row justify-content-center">

<div class="col-lg-8">

<p class="text-light">

Terima kasih telah memilih RentGo Black Gold Luxury.
Kami berkomitmen menghadirkan kendaraan premium,
pelayanan profesional, serta pengalaman berkendara
yang aman, nyaman, dan berkelas.

</p>

</div>

</div>

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