<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT * FROM mobil ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Booking Mobil - RentGo</title>

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

    min-height:45vh;

    display:flex;
    align-items:center;

    text-align:center;

    background:
    linear-gradient(
        rgba(0,0,0,.75),
        rgba(0,0,0,.75)
    ),
    url('../../assets/img/hero.jpg');

    background-size:cover;
    background-position:center;
}

.hero h1{

    font-size:65px;

    font-weight:900;
}

.hero span{
    color:var(--gold);
}

.hero p{
    color:#d8d8d8;
}

/* CARD */

.car-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:22px;

    overflow:hidden;

    transition:.3s;

    height:100%;
}

.car-card:hover{

    transform:translateY(-10px);

    border-color:var(--gold);

    box-shadow:
    0 0 30px rgba(212,175,55,.12);
}

.car-body{

    padding:25px;
}

.car-name{

    font-size:28px;

    font-weight:800;
}

.car-price{

    color:var(--gold);

    font-size:30px;

    font-weight:900;
}

/* BUTTON */

.btn-gold{

    background:var(--gold);

    color:#000;

    border:none;

    font-weight:700;

    border-radius:12px;
}

.btn-gold:hover{

    background:#c79d1c;

    color:#000;
}

.section{
    padding:80px 0;
}

</style>

</head>

<body>

<section class="hero">

<div class="container">

<h1>

Book Your

<span>

Luxury Ride

</span>

</h1>

<p>

Pilih mobil terbaik dan nikmati perjalanan premium bersama RentGo

</p>

<a
href="../dashboard.php"
class="btn btn-warning mt-3"
>

← Dashboard

</a>

</div>

</section>

<section class="section">

<div class="container">

<div class="row">

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<?php

$namaMobil =
strtolower(trim($row['nama_mobil']));

if(strpos($namaMobil,'alphard') !== false){

    $gambar =
    '../../assets/img/alphard.jpg';

}
elseif(strpos($namaMobil,'innova') !== false){

    $gambar =
    '../../assets/img/innova.jpg';

}
elseif(strpos($namaMobil,'avanza') !== false){

    $gambar =
    '../../assets/img/avanza.jpg';

}
else{

    $gambar =
    '../../assets/img/hero.jpg';

}

?>

<div class="col-lg-4 col-md-6 mb-4">

<div class="car-card">

<img
src="<?= $gambar ?>"
style="
width:100%;
height:260px;
object-fit:cover;
"
>

<div class="car-body">

<h3 class="car-name">

<?= htmlspecialchars($row['nama_mobil']); ?>

</h3>

<hr class="text-secondary">

<p>

<strong>Merk :</strong>

<?= htmlspecialchars($row['merk']); ?>

</p>

<p>

<strong>Tahun :</strong>

<?= htmlspecialchars($row['tahun']); ?>

</p>

<p>

<strong>Plat :</strong>

<?= htmlspecialchars($row['plat_nomor']); ?>

</p>

<div class="car-price mb-3">

Rp <?= number_format(
$row['harga_per_hari'],
0,
',',
'.'
); ?>

<span
style="
font-size:16px;
color:#bbb;
"
>

/ Hari

</span>

</div>

<div class="d-grid">

<a
href="../booking/sewa.php?id=<?= $row['id']; ?>"
class="btn btn-gold"
>

<i class="fas fa-calendar-check me-2"></i>

Sewa Sekarang

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
