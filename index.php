<?php
session_start();
require_once 'config/koneksi.php';

/** @var mysqli $conn */
$totalMobil = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM mobil"));
$totalUser = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='user'"));
$totalBooking = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booking"));

$review = mysqli_query($conn,"SELECT review.*,users.nama,mobil.nama_mobil
FROM review
JOIN users ON review.user_id=users.id
JOIN mobil ON review.mobil_id=mobil.id
ORDER BY review.id DESC LIMIT 3");
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RentGo Black Gold</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{background:#050505;color:#fff;font-family:Segoe UI,sans-serif;overflow-x:hidden}
.navbar{background:rgba(0,0,0,.85);backdrop-filter:blur(10px)}
.brand{font-size:34px;font-weight:800;color:#d4af37;text-decoration:none}
.nav-link{color:#fff!important}
.hero{
    min-height:100vh;

    background:
    linear-gradient(
        90deg,
        rgba(0,0,0,.78) 0%,
        rgba(0,0,0,.55) 30%,
        rgba(0,0,0,.25) 60%,
        rgba(0,0,0,.05) 100%
    ),
    url('assets/img/hero.jpg');

    background-size:cover;

    background-position:
    85% center;

    background-repeat:no-repeat;

    display:flex;
    align-items:center;

    padding-top:90px;
}
.hero h1{font-size:80px;font-weight:800}
.hero p{font-size:22px;color:#ddd;max-width:600px}
.btn-gold{background:#d4af37;color:#000;border:none;border-radius:40px;padding:14px 30px;font-weight:700}
.btn-outline-gold{border:2px solid #d4af37;color:#d4af37;border-radius:40px;padding:12px 30px}
.search-box{margin-top:40px;background:#1a1a1a;border-radius:20px;padding:20px}
.section{padding:90px 0}
.title{text-align:center;font-size:42px;font-weight:800;margin-bottom:50px}
.stat{background:#111;padding:30px;border-radius:20px;text-align:center;border:1px solid #222}
.stat h2{color:#d4af37;font-size:56px}
.card-gold{background:#111;border:1px solid #222;border-radius:20px;overflow:hidden;height:100%}
.card-gold img{width:100%;height:250px;object-fit:cover}
.card-bodyx{padding:20px}
.review{background:#111;padding:25px;border-radius:20px;border:1px solid #222;height:100%}
footer{background:#000;padding:50px;text-align:center;border-top:1px solid #222}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top navbar-dark">
<div class="container">
<a class="brand" href="#">RentGo</a>
<div class="ms-auto">
<a href="auth/login.php" class="btn btn-outline-light me-2">Login</a>
<a href="auth/register.php" class="btn btn-warning">Register</a>
</div>
</div>
</nav>

<section class="hero">
<div class="container">
<div class="row">
<div class="col-lg-7">
<span class="badge bg-warning text-dark mb-3">Luxury Car Rental</span>
<h1>Drive In Luxury<br>That Suits You</h1>
<p>Nikmati pengalaman rental mobil premium dengan armada terbaik, nyaman, aman dan terpercaya.</p>

<div class="mt-4">
<a href="auth/register.php" class="btn btn-gold me-2">Book Now</a>
<a href="#fleet" class="btn btn-outline-gold">Explore Fleet</a>
</div>
</div>
</div>
</div>
</section>

<section class="section">
<div class="container">
<div class="row g-4">
<div class="col-md-4"><div class="stat"><h2><?= $totalMobil ?></h2><p>Premium Cars</p></div></div>
<div class="col-md-4"><div class="stat"><h2><?= $totalUser ?></h2><p>Happy Clients</p></div></div>
<div class="col-md-4"><div class="stat"><h2><?= $totalBooking ?></h2><p>Completed Rentals</p></div></div>
</div>
</div>
</section>

<section class="section" id="fleet">
<div class="container">
<h2 class="title">Premium Fleet</h2>
<div class="row g-4">
<div class="col-md-4"><div class="card-gold"><img src="assets/img/alphard.jpg"><div class="card-bodyx"><h4>Alphard</h4><p>Luxury Executive MPV</p></div></div></div>
<div class="col-md-4"><div class="card-gold"><img src="assets/img/innova.jpg"><div class="card-bodyx"><h4>Innova Reborn</h4><p>Comfort For Family</p></div></div></div>
<div class="col-md-4"><div class="card-gold"><img src="assets/img/avanza.jpg"><div class="card-bodyx"><h4>Avanza</h4><p>Efficient Daily Travel</p></div></div></div>
</div>
</div>
</section>

<section class="section">
<div class="container">
<h2 class="title">Customer Reviews</h2>
<div class="row g-4">
<?php while($r=mysqli_fetch_assoc($review)): ?>
<div class="col-md-4">
<div class="review">
<h5><?= htmlspecialchars($r['nama']) ?></h5>
<p><strong><?= htmlspecialchars($r['nama_mobil']) ?></strong></p>
<p>⭐ <?= $r['rating'] ?>/5</p>
<p><?= htmlspecialchars($r['komentar']) ?></p>
</div>
</div>
<?php endwhile; ?>
</div>
</div>
</section>

<footer>
<h3>RentGo Luxury Rental</h3>
<p>© <?= date('Y') ?> All Rights Reserved</p>
</footer>

</body>
</html>