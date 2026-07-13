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

<title>Premium Fleet - RentGo</title>

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
    background:var(--dark);
    color:white;
}

/* HERO */

.hero{

    min-height:55vh;

    display:flex;
    align-items:center;

    background:
    linear-gradient(
        rgba(0,0,0,.75),
        rgba(0,0,0,.75)
    ),
    url('../../assets/img/hero.jpg');

    background-size:cover;
    background-position:center;

    color:white;
}

.hero h1{

    font-size:65px;

    font-weight:900;

    margin-bottom:15px;
}

.hero h1 span{

    color:var(--gold);
}

.hero p{

    color:#d7d7d7;

    font-size:20px;

    max-width:700px;

    margin:auto;
}

/* BUTTON */

.btn-gold{

    background:var(--gold);

    color:#000;

    font-weight:700;

    border:none;

    border-radius:14px;

    padding:14px 25px;
}

.btn-gold:hover{

    background:#c79d1c;

    color:#000;
}

/* SECTION */

.section{
    padding:90px 0;
}

/* CARD */

.car-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:22px;

    overflow:hidden;

    transition:.35s;

    height:100%;
}

.car-card:hover{

    transform:translateY(-10px);

    border-color:var(--gold);

    box-shadow:
    0 0 30px rgba(212,175,55,.12);
}

.car-card img{

    width:100%;

    height:260px;

    object-fit:cover;
}

.car-body{

    padding:25px;
}

.car-name{

    font-size:28px;

    font-weight:800;

    color:white;
}

.car-info{

    color:#d7d7d7;
}

.car-price{

    color:var(--gold);

    font-size:30px;

    font-weight:900;
}

/* STATUS */

.status-tersedia{

    background:#198754;

    padding:8px 12px;
}

.status-disewa{

    background:#dc3545;

    padding:8px 12px;
}

/* DETAIL BUTTON */

.btn-detail{

    background:var(--gold);

    color:#000;

    border:none;

    font-weight:700;

    border-radius:12px;

    padding:12px;
}

.btn-detail:hover{

    background:#c79d1c;

    color:#000;
}

/* RESPONSIVE */

@media(max-width:768px){

.hero h1{
    font-size:42px;
}

.hero p{
    font-size:16px;
}

}

</style>

</head>

<body>

<!-- HERO -->

<section class="hero">

<div class="container text-center">

<h1>

Our <span>Premium Fleet</span>

</h1>

<p>

Luxury vehicles for every journey.
Temukan armada terbaik dengan kenyamanan premium,
aman, dan terpercaya bersama RentGo.

</p>

<a
href="../dashboard.php"
class="btn btn-gold mt-4"
>

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

</section>

<!-- DAFTAR MOBIL -->

<section class="section">

<div class="container">

<div class="row">

<?php while($mobil = mysqli_fetch_assoc($data)) : ?>

<?php

$namaMobil = strtolower(trim($mobil['nama_mobil']));

if (strpos($namaMobil,'alphard') !== false) {

    $gambar =
    '../../assets/img/alphard.jpg';

}
elseif (strpos($namaMobil,'innova') !== false) {

    $gambar =
    '../../assets/img/innova.jpg';

}
elseif (strpos($namaMobil,'avanza') !== false) {

    $gambar =
    '../../assets/img/avanza.jpg';

}
else {

    $gambar =
    '../../assets/img/hero.jpg';

}

?>

<div class="col-lg-4 col-md-6 mb-4">

<div class="car-card">

<img
src="<?= $gambar ?>"
alt="<?= htmlspecialchars($mobil['nama_mobil']) ?>"
>

<div class="car-body">

<h3 class="car-name">

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h3>

<hr class="text-secondary">

<p class="car-info">

<strong>Merk :</strong>

<?= htmlspecialchars($mobil['merk']) ?>

</p>

<p class="car-info">

<strong>Tahun :</strong>

<?= htmlspecialchars($mobil['tahun']) ?>

</p>

<p class="car-info">

<strong>Transmisi :</strong>

<?= htmlspecialchars($mobil['transmisi']) ?>

</p>

<p>

<strong>Status :</strong>

<?php if($mobil['status'] == 'Tersedia'): ?>

<span class="badge status-tersedia">

Tersedia

</span>

<?php else: ?>

<span class="badge status-disewa">

<?= htmlspecialchars($mobil['status']) ?>

</span>

<?php endif; ?>

</p>

<div class="car-price mb-3">

Rp <?= number_format(
    $mobil['harga_per_hari'],
    0,
    ',',
    '.'
); ?>

<span style="font-size:16px;color:#bbb;">
/ Hari
</span>

</div>

<div class="d-grid">

<a
href="detail.php?id=<?= $mobil['id'] ?>"
class="btn btn-detail"
>

<i class="fas fa-car me-2"></i>

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

</body>
</html>
```
