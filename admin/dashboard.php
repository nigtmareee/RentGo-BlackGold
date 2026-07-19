<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

require_once '../config/koneksi.php';

/** @var mysqli $conn */

$totalMobil = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM mobil"));
$totalUser = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='user'"));
$totalBooking = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booking"));

$mobilDisewa = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM mobil WHERE status='Disewa'"));
$verifikasi = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pembayaran WHERE status='Menunggu Verifikasi'"));

$qPendapatan = mysqli_query($conn,"SELECT SUM(total_harga) AS total FROM booking WHERE status='Selesai'");
$pendapatan = mysqli_fetch_assoc($qPendapatan);
$totalPendapatan = $pendapatan['total'] ?? 0;

$bulan = [];
$pendapatanBulanan = [];

$grafik = mysqli_query(
    $conn,
    "SELECT MONTH(tanggal_mulai) AS bulan,
            SUM(total_harga) AS total
     FROM booking
     WHERE status='Selesai'
     GROUP BY MONTH(tanggal_mulai)
     ORDER BY MONTH(tanggal_mulai)"
);

$namaBulan = [
    1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
    5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',
    9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
];

while($row=mysqli_fetch_assoc($grafik)){
    $bulan[]=$namaBulan[$row['bulan']];
    $pendapatanBulanan[]=$row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

Executive Dashboard | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

/* ===========================
        NAVBAR
=========================== */

.navbar{

background:rgba(5,5,5,.95);

backdrop-filter:blur(12px);

border-bottom:1px solid rgba(212,175,55,.15);

padding:15px 0;

position:sticky;

top:0;

z-index:999;

}

.logo{

font-size:30px;

font-weight:800;

text-decoration:none;

color:var(--gold);

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
rgba(0,0,0,.78),
rgba(0,0,0,.88)
),
url('../assets/img/hero.jpg');

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

padding:80px 0;

}

/* ===========================
        CARD KPI
=========================== */

.kpi-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid var(--border);

border-radius:22px;

padding:28px;

height:100%;

transition:.35s;

box-shadow:0 20px 45px rgba(0,0,0,.45);

}

.kpi-card:hover{

transform:translateY(-8px);

border-color:var(--gold);

box-shadow:0 25px 55px rgba(212,175,55,.12);

}

.kpi-icon{

width:70px;
height:70px;

border-radius:18px;

display:flex;

align-items:center;

justify-content:center;

background:rgba(212,175,55,.12);

margin-bottom:18px;

}

.kpi-icon i{

font-size:30px;

color:var(--gold);

}

.kpi-title{

color:#bbbbbb;

font-size:15px;

margin-bottom:8px;

}

.kpi-number{

font-size:34px;

font-weight:800;

color:var(--gold);

}

/* ===========================
        CARD
=========================== */

.dashboard-card{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid var(--border);

border-radius:22px;

padding:28px;

box-shadow:0 20px 45px rgba(0,0,0,.45);

}

/* ===========================
        MENU CARD
=========================== */

.menu-card{

background:linear-gradient(
145deg,
#111,
#1b1b1b
);

border:1px solid rgba(212,175,55,.15);

border-radius:22px;

padding:35px 20px;

text-align:center;

height:100%;

transition:.35s;

cursor:pointer;

}

.menu-card:hover{

transform:translateY(-8px);

border-color:var(--gold);

box-shadow:0 20px 40px rgba(212,175,55,.15);

}

.menu-card i{

font-size:46px;

color:var(--gold);

margin-bottom:18px;

}

.menu-card h5{

color:#fff;

font-weight:700;

margin-bottom:0;

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

padding:12px 24px;

border-radius:12px;

transition:.3s;

}

.btn-gold:hover{

color:#000;

transform:translateY(-3px);

box-shadow:0 10px 25px rgba(212,175,55,.25);

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

.kpi-number{

font-size:26px;

}

.menu-card{

padding:28px 15px;

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

<a href="dashboard.php" class="logo">

<i class="fas fa-car-side me-2"></i>

RentGo Admin

</a>

<div class="ms-auto">

<a href="profile/index.php" class="btn btn-gold">

<i class="fas fa-user-shield me-2"></i>

<?= htmlspecialchars($_SESSION['nama']); ?>

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

Executive <span>Dashboard</span>

</h1>

<p>

Selamat datang kembali,

<strong><?= htmlspecialchars($_SESSION['nama']); ?></strong>

di pusat kendali RentGo Black Gold Luxury.

</p>

</div>

</section>

<!-- ===========================
            CONTENT
=========================== -->

<section class="section">

<div class="container">

<!-- KPI -->

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<div class="kpi-card">

<div class="kpi-icon">

<i class="fas fa-car"></i>

</div>

<div class="kpi-title">

Total Mobil

</div>

<div class="kpi-number">

<?= $totalMobil ?>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="kpi-card">

<div class="kpi-icon">

<i class="fas fa-users"></i>

</div>

<div class="kpi-title">

Total User

</div>

<div class="kpi-number">

<?= $totalUser ?>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="kpi-card">

<div class="kpi-icon">

<i class="fas fa-calendar-check"></i>

</div>

<div class="kpi-title">

Total Booking

</div>

<div class="kpi-number">

<?= $totalBooking ?>

</div>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="kpi-card">

<div class="kpi-icon">

<i class="fas fa-money-bill-wave"></i>

</div>

<div class="kpi-title">

Pendapatan

</div>

<div class="kpi-number" style="font-size:24px">

Rp <?= number_format($totalPendapatan,0,',','.') ?>

</div>

</div>

</div>

</div>

<!-- SECONDARY CARD -->

<div class="row g-4 mt-2">

<div class="col-lg-6">

<div class="dashboard-card text-center">

<div class="kpi-icon mx-auto">

<i class="fas fa-car-side"></i>

</div>

<h5 class="text-warning">

Mobil Sedang Disewa

</h5>

<h2 class="kpi-number">

<?= $mobilDisewa ?>

</h2>

</div>

</div>

<div class="col-lg-6">

<div class="dashboard-card text-center">

<div class="kpi-icon mx-auto">

<i class="fas fa-money-check-dollar"></i>

</div>

<h5 class="text-warning">

Menunggu Verifikasi

</h5>

<h2 class="kpi-number">

<?= $verifikasi ?>

</h2>

</div>

</div>

</div>

<!-- GRAFIK -->

<div class="dashboard-card mt-5">

<h3 class="text-warning mb-4">

<i class="fas fa-chart-column me-2"></i>

Grafik Pendapatan Bulanan

</h3>

<canvas id="grafikPendapatan"></canvas>

</div>

<!-- MENU -->

<h3 class="mt-5 mb-4 text-warning">

<i class="fas fa-layer-group me-2"></i>

Menu Administrator

</h3>

<div class="row g-4">

<div class="col-lg-3 col-md-6">

<a href="mobil/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-car"></i>

<h5>Kelola Mobil</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="booking/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-calendar-check"></i>

<h5>Kelola Booking</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="pembayaran/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-money-check-dollar"></i>

<h5>Verifikasi Pembayaran</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="pengguna/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-users"></i>

<h5>Kelola Pengguna</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="laporan/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-chart-line"></i>

<h5>Laporan Rental</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="review/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-star"></i>

<h5>Review Pelanggan</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="profile/index.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-user-shield"></i>

<h5>Profil Admin</h5>

</div>

</a>

</div>

<div class="col-lg-3 col-md-6">

<a href="../auth/logout.php" class="text-decoration-none">

<div class="menu-card">

<i class="fas fa-right-from-bracket"></i>

<h5>Logout</h5>

</div>

</a>

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

Executive Dashboard membantu administrator memantau seluruh aktivitas
Rental Mobil RentGo secara real-time, mulai dari data kendaraan,
booking, pembayaran, hingga laporan pendapatan.

</p>

<hr class="border-secondary my-4">

<p class="mb-0 text-secondary">

&copy; <?= date('Y'); ?>

RentGo Black Gold Luxury.

All Rights Reserved.

</p>

</div>

</footer>

<script>

new Chart(document.getElementById('grafikPendapatan'),{

type:'bar',

data:{

labels:<?= json_encode($bulan); ?>,

datasets:[{

label:'Pendapatan Rental',

data:<?= json_encode($pendapatanBulanan); ?>,

backgroundColor:'#d4af37',

borderColor:'#f3cf63',

borderWidth:2,

borderRadius:8,

hoverBackgroundColor:'#f5d56d'

}]

},

options:{

responsive:true,

maintainAspectRatio:true,

plugins:{

legend:{

labels:{

color:'#d4af37',

font:{
size:14,
weight:'bold'
}

}

}

},

scales:{

x:{

ticks:{

color:'#ffffff'

},

grid:{

color:'rgba(255,255,255,.05)'

}

},

y:{

beginAtZero:true,

ticks:{

color:'#ffffff'

},

grid:{

color:'rgba(255,255,255,.05)'

}

}

}

}

});

/* ===========================
      CARD ANIMATION
=========================== */

document.querySelectorAll('.kpi-card,.dashboard-card,.menu-card').forEach(function(card){

card.addEventListener('mouseenter',function(){

this.style.transform='translateY(-8px)';

});

card.addEventListener('mouseleave',function(){

this.style.transform='translateY(0px)';

});

});

/* ===========================
      BUTTON EFFECT
=========================== */

document.querySelectorAll('.btn').forEach(function(btn){

btn.addEventListener('mouseenter',function(){

this.style.transform='translateY(-2px)';

});

btn.addEventListener('mouseleave',function(){

this.style.transform='translateY(0px)';

});

});

</script>

</body>

</html>