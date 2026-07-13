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

<title>Dashboard User - RentGo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{
    --gold:#d4af37;
    --dark:#050505;
    --card:#111111;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    background:#050505;
    color:white;
}

/* NAVBAR */

.navbar{
    background:#0a0a0a;
    border-bottom:1px solid rgba(212,175,55,.2);
}

.logo{
    color:var(--gold);
    font-size:38px;
    font-weight:800;
    text-decoration:none;
}

/* HERO */

.hero{
    padding:70px 0;
    background:
    linear-gradient(
        rgba(0,0,0,.75),
        rgba(0,0,0,.75)
    ),
    url('../assets/img/hero.jpg');

    background-size:cover;
    background-position:center;
}

.hero h1{
    font-size:55px;
    font-weight:800;
}

.hero span{
    color:var(--gold);
}

/* CARD */

.dashboard-card{
    background:#111;
    border:1px solid rgba(212,175,55,.15);
    border-radius:20px;
    transition:.3s;
    height:100%;
}

.dashboard-card:hover{
    transform:translateY(-8px);
    border-color:var(--gold);
}

.dashboard-card i{
    font-size:45px;
    color:var(--gold);
}

.dashboard-card h4{
    margin-top:15px;
}

/* WELCOME */

.welcome-box{

    background:
    linear-gradient(
        135deg,
        #111,
        #1a1a1a
    );

    border:1px solid rgba(212,175,55,.2);

    border-radius:25px;

    padding:35px;
}

.welcome-box h2{
    font-weight:800;
}

.welcome-box h2 span{
    color:var(--gold);
}

/* BUTTON */

.btn-gold{
    background:var(--gold);
    color:#000;
    border:none;
    font-weight:700;
}

.btn-gold:hover{
    background:#c69d22;
}

/* FOOTER */

.footer{
    margin-top:80px;
    border-top:1px solid rgba(212,175,55,.15);
    padding:25px;
    text-align:center;
    color:#aaa;
}

</style>
</head>
<body>

<!-- NAVBAR -->

<nav class="navbar navbar-expand-lg">
<div class="container">

<a href="../index.php" class="logo">
RentGo
</a>

<div class="ms-auto">

<a href="../auth/logout.php"
class="btn btn-outline-warning">

Logout

</a>

</div>

</div>
</nav>

<!-- HERO -->

<section class="hero">

<div class="container">

<div class="welcome-box">

<h2>

Selamat Datang,

<span>

<?= htmlspecialchars($_SESSION['nama']); ?>

</span>

</h2>

<p class="mt-3 text-light">

Kelola pemesanan mobil, pembayaran,
dan riwayat rental Anda dengan mudah.

</p>

</div>

</div>

</section>

<!-- MENU -->

<div class="container mt-5">

<div class="row">

<div class="col-md-3 mb-4">

<a href="mobil/index.php"
class="text-decoration-none">

<div class="dashboard-card text-center p-4">

<i class="fas fa-car"></i>

<h4 class="text-white">

Lihat Mobil

</h4>

</div>

</a>

</div>

<div class="col-md-3 mb-4">

<a href="booking/riwayat.php"
class="text-decoration-none">

<div class="dashboard-card text-center p-4">

<i class="fas fa-clipboard-list"></i>

<h4 class="text-white">

Riwayat Booking

</h4>

</div>

</a>

</div>

<div class="col-md-3 mb-4">

<a href="pembayaran/status.php"
class="text-decoration-none">

<div class="dashboard-card text-center p-4">

<i class="fas fa-credit-card"></i>

<h4 class="text-white">

Pembayaran

</h4>

</div>

</a>

</div>

<div class="col-md-3 mb-4">

<a href="profile/index.php"
class="text-decoration-none">

<div class="dashboard-card text-center p-4">

<i class="fas fa-user"></i>

<h4 class="text-white">

Profil Saya

</h4>

</div>

</a>

</div>

</div>

</div>

<!-- FOOTER -->

<div class="footer">

© <?= date('Y'); ?> RentGo Luxury Rental

</div>

</body>
</html>