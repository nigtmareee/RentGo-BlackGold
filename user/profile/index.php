<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$user_id = $_SESSION['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users
    WHERE id='$user_id'"
);

$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

Profil Saya | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

    --gold:#d4af37;
    --gold-light:#f3cf63;
    --dark:#050505;
    --card:#111111;
    --card2:#1b1b1b;
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

/* ==========================
        NAVBAR
========================== */

.navbar{

    background:rgba(5,5,5,.96);
    backdrop-filter:blur(12px);
    border-bottom:1px solid rgba(212,175,55,.15);
    padding:15px 0;
    position:sticky;
    top:0;
    z-index:999;

}

.logo{

    color:var(--gold);
    text-decoration:none;
    font-size:30px;
    font-weight:800;
    letter-spacing:1px;

}

.logo:hover{

    color:var(--gold-light);

}

/* ==========================
          HERO
========================== */

.hero{

    min-height:40vh;

    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;

    background:
    linear-gradient(
    rgba(0,0,0,.78),
    rgba(0,0,0,.86)
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

    background:rgba(212,175,55,.05);

    border-radius:50%;

    filter:blur(120px);

    top:-150px;
    right:-120px;

}

.hero h1{

    font-size:60px;
    font-weight:900;
    margin-bottom:15px;

}

.hero span{

    color:var(--gold);

}

.hero p{

    color:#dddddd;
    font-size:18px;

}

/* ==========================
        CONTENT
========================== */

.section{

    padding:80px 0;

}

/* ==========================
      PROFILE CARD
========================== */

.profile-card{

    background:linear-gradient(
    145deg,
    var(--card),
    var(--card2)
    );

    border:1px solid var(--border);

    border-radius:24px;

    padding:40px;

    box-shadow:
    0 20px 45px rgba(0,0,0,.45);

}

/* ==========================
        AVATAR
========================== */

.avatar{

    width:130px;
    height:130px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    margin:auto;

    background:
    linear-gradient(
    135deg,
    #d4af37,
    #b98d12
    );

    color:#000;

    font-size:52px;
    font-weight:bold;

    box-shadow:
    0 0 30px rgba(212,175,55,.25);

}

/* ==========================
      PROFILE INFO
========================== */

.profile-info{

    text-align:center;
    margin-top:25px;
    margin-bottom:40px;

}

.profile-info h3{

    font-weight:800;
    color:#fff;

}

.profile-info p{

    color:#bdbdbd;

}

/* ==========================
          FORM
========================== */

.form-label{

    color:var(--gold);
    font-weight:600;

}

.form-control{

    background:#181818 !important;
    border:1px solid #333 !important;
    color:#fff !important;
    border-radius:12px;
    padding:12px 15px;

}

.form-control:focus{

    border-color:var(--gold)!important;
    box-shadow:
    0 0 0 .15rem rgba(212,175,55,.15);

}

textarea.form-control{

    resize:none;

}

/* ==========================
         BUTTON
========================== */

.btn-gold{

    background:
    linear-gradient(
    135deg,
    var(--gold),
    #b98d12
    );

    color:#000;
    border:none;
    font-weight:700;
    border-radius:12px;
    padding:12px 24px;
    transition:.3s;

}

.btn-gold:hover{

    color:#000;

    transform:translateY(-3px);

    box-shadow:
    0 10px 25px rgba(212,175,55,.25);

}

.btn-outline-gold{

    border:1px solid var(--gold);

    color:var(--gold);

    border-radius:12px;

    padding:12px 24px;

    transition:.3s;

}

.btn-outline-gold:hover{

    background:var(--gold);

    color:#000;

}

/* ==========================
          FOOTER
========================== */

.footer{

    margin-top:80px;

    padding:35px;

    text-align:center;

    border-top:1px solid rgba(212,175,55,.15);

    color:#999;

}

/* ==========================
       RESPONSIVE
========================== */

@media(max-width:768px){

.hero h1{

    font-size:42px;

}

.profile-card{

    padding:25px;

}

.avatar{

    width:100px;
    height:100px;

    font-size:42px;

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
href="../dashboard.php"
class="btn btn-outline-gold">

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

<div class="container">

<h1>

Profil <span>Saya</span>

</h1>

<p>

Kelola informasi akun Anda dengan aman dan nikmati pengalaman
premium bersama RentGo Black Gold Luxury.

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

<div class="profile-card">

<div class="avatar">

<?= strtoupper(substr($user['nama'],0,1)); ?>

</div>

<div class="profile-info">

<h3>

<?= htmlspecialchars($user['nama']); ?>

</h3>

<p>

<i class="fas fa-crown text-warning me-2"></i>

Member RentGo Premium

</p>

</div>

<form
action="update.php"
method="POST">

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-user me-2"></i>

Nama Lengkap

</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= htmlspecialchars($user['nama']); ?>"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-envelope me-2"></i>

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($user['email']); ?>"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-phone me-2"></i>

Nomor HP

</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= htmlspecialchars($user['no_hp']); ?>">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-user-tag me-2"></i>

Status Akun

</label>

<input
type="text"
class="form-control"
value="Member RentGo Premium"
readonly>

</div>

<div class="col-12 mb-4">

<label class="form-label">

<i class="fas fa-location-dot me-2"></i>

Alamat

</label>

<textarea
name="alamat"
class="form-control"
rows="5"><?= htmlspecialchars($user['alamat']); ?></textarea>

</div>

<div class="col-12">

<div class="d-flex justify-content-end gap-3 flex-wrap">

<a
href="../dashboard.php"
class="btn btn-outline-gold">

<i class="fas fa-arrow-left me-2"></i>

Kembali

</a>

<button
type="submit"
class="btn btn-gold">

<i class="fas fa-save me-2"></i>

Simpan Perubahan

</button>

</div>

</div>

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

Terima kasih telah menggunakan layanan RentGo Black Gold Luxury.
Perbarui informasi akun Anda secara berkala agar proses pemesanan,
konfirmasi, dan komunikasi dapat berjalan dengan lebih aman dan nyaman.

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
      INPUT ANIMATION
=========================== */

document.querySelectorAll(".form-control").forEach(function(input){

    input.addEventListener("focus",function(){

        this.style.transform="translateY(-2px)";
        this.style.transition=".3s";

    });

    input.addEventListener("blur",function(){

        this.style.transform="translateY(0)";

    });

});

/* ===========================
      BUTTON EFFECT
=========================== */

document.querySelectorAll(".btn").forEach(function(btn){

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