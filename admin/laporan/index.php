<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

$where = "";

if (
    !empty($tanggal_awal) &&
    !empty($tanggal_akhir)
) {

    $where =
        "WHERE booking.tanggal_mulai
        BETWEEN '$tanggal_awal'
        AND '$tanggal_akhir'";
}

$query = "
SELECT
    booking.*,
    users.nama,
    mobil.nama_mobil
FROM booking
JOIN users
    ON booking.user_id = users.id
JOIN mobil
    ON booking.mobil_id = mobil.id
$where
ORDER BY booking.id DESC
";

$data = mysqli_query($conn, $query);

$queryTotal = "
SELECT SUM(total_harga) AS total
FROM booking
$where
";

$totalData =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            $queryTotal
        )
    );

$totalPendapatan =
    $totalData['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>

Laporan Rental | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

--gold:#d4af37;
--gold-light:#f5d56d;
--dark:#050505;
--card:#111111;
--card2:#1a1a1a;
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

/*==========================
        NAVBAR
==========================*/

.navbar{

background:rgba(5,5,5,.96);

backdrop-filter:blur(15px);

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

/*==========================
          HERO
==========================*/

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

top:-170px;
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

/*==========================
          SECTION
==========================*/

.section{

padding:80px 0;

}

/*==========================
      PREMIUM CARD
==========================*/

.card-premium{

background:linear-gradient(
145deg,
var(--card),
var(--card2)
);

border:1px solid var(--border);

border-radius:24px;

padding:35px;

box-shadow:0 20px 45px rgba(0,0,0,.45);

}

/*==========================
      STATISTIC CARD
==========================*/

.stat-card{

background:#181818;

border-left:5px solid var(--gold);

border-radius:18px;

padding:22px;

height:100%;

transition:.3s;

}

.stat-card:hover{

transform:translateY(-6px);

box-shadow:0 15px 35px rgba(212,175,55,.15);

}

.stat-card i{

font-size:32px;

color:var(--gold);

margin-bottom:15px;

}

.stat-card h3{

font-size:32px;

font-weight:700;

margin-bottom:8px;

}

.stat-card p{

margin:0;

color:#bbb;

}

/*==========================
        FORM
==========================*/

.form-label{

font-weight:600;

color:#ddd;

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

box-shadow:0 0 0 .15rem rgba(212,175,55,.15);

}

/*==========================
          TABLE
==========================*/

.table{

color:#fff;

margin-bottom:0;

}

.table thead{

background:#1d1d1d;

}

.table thead th{

color:var(--gold);

border-color:#333;

text-align:center;

vertical-align:middle;

white-space:nowrap;

}

.table tbody tr{

background:#111;

transition:.3s;

}

.table tbody tr:hover{

background:#1b1b1b;

}

.table td{

border-color:#2d2d2d;

vertical-align:middle;

}

/*==========================
      STATUS BADGE
==========================*/

.badge-status{

padding:8px 16px;

border-radius:30px;

font-size:13px;

font-weight:600;

}

.status-menunggu{

background:#ffc107;

color:#000;

}

.status-disewa{

background:#0d6efd;

color:#fff;

}

.status-selesai{

background:#198754;

color:#fff;

}

.status-batal{

background:#dc3545;

color:#fff;

}

/*==========================
          BUTTON
==========================*/

.btn-gold{

background:linear-gradient(
135deg,
var(--gold),
#b98d12
);

border:none;

color:#000;

font-weight:700;

padding:12px 22px;

border-radius:12px;

transition:.3s;

}

.btn-gold:hover{

color:#000;

transform:translateY(-3px);

box-shadow:0 10px 25px rgba(212,175,55,.25);

}

/*==========================
          FOOTER
==========================*/

.footer{

margin-top:80px;

padding:35px;

text-align:center;

border-top:1px solid rgba(212,175,55,.15);

color:#999;

}

/*==========================
      PRINT MODE
==========================*/

@media print{

.navbar,
.hero,
.footer,
.btn,
form{

display:none !important;

}

body{

background:#fff;

color:#000;

}

.card-premium{

border:none;

box-shadow:none;

padding:0;

}

.table{

color:#000;

}

.table thead th{

color:#000;

background:#eee;

}

}

/*==========================
      RESPONSIVE
==========================*/

@media(max-width:768px){

.hero h1{

font-size:42px;

}

.card-premium{

padding:22px;

}

.stat-card{

margin-bottom:20px;

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

RentGo Admin

</a>

<div class="ms-auto">

<a
href="../dashboard.php"
class="btn btn-gold">

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

<div class="container text-center">

<h1>

Laporan

<span>

Rental

</span>

</h1>

<p>

Pantau seluruh transaksi penyewaan dan pendapatan RentGo Black Gold Luxury
dalam satu halaman yang informatif.

</p>

</div>

</section>

<!-- ===========================
        CONTENT
=========================== -->

<section class="section">

<div class="container">

<!-- ===========================
      STATISTIK
=========================== -->

<div class="row g-4 mb-5">

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-wallet"></i>

<h3>

Rp <?= number_format($totalPendapatan,0,',','.'); ?>

</h3>

<p>

Total Pendapatan

</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-file-invoice"></i>

<h3>

<?= mysqli_num_rows($data); ?>

</h3>

<p>

Total Booking

</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-chart-line"></i>

<h3>

Aktif

</h3>

<p>

Monitoring Rental

</p>

</div>

</div>

<div class="col-lg-3 col-md-6">

<div class="stat-card text-center">

<i class="fas fa-car-side"></i>

<h3>

Premium

</h3>

<p>

Layanan RentGo

</p>

</div>

</div>

</div>

<!-- ===========================
        CARD
=========================== -->

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center flex-wrap mb-4">

<div>

<h2 class="text-warning fw-bold">

<i class="fas fa-chart-line me-2"></i>

Data Laporan Rental

</h2>

<p class="text-secondary mb-0">

Filter transaksi berdasarkan periode penyewaan.

</p>

</div>

</div>

<!-- ===========================
        FILTER
=========================== -->

<form method="GET">

<div class="row g-3 align-items-end">

<div class="col-lg-4">

<label class="form-label">

Tanggal Awal

</label>

<input
type="date"
name="tanggal_awal"
class="form-control"
value="<?= $tanggal_awal ?>">

</div>

<div class="col-lg-4">

<label class="form-label">

Tanggal Akhir

</label>

<input
type="date"
name="tanggal_akhir"
class="form-control"
value="<?= $tanggal_akhir ?>">

</div>

<div class="col-lg-4">

<button
type="submit"
class="btn btn-gold w-100">

<i class="fas fa-filter me-2"></i>

Filter Data

</button>

</div>

</div>

</form>

<!-- ===========================
    TOTAL PENDAPATAN
=========================== -->

<div class="mt-5 mb-4">

<div class="stat-card">

<i class="fas fa-money-bill-wave"></i>

<h3>

Rp <?= number_format($totalPendapatan,0,',','.'); ?>

</h3>

<p>

Total Pendapatan Rental

</p>

</div>

</div>

<!-- ===========================
        ACTION
=========================== -->

<div class="mb-4">

<button
onclick="window.print()"
class="btn btn-danger">

<i class="fas fa-print me-2"></i>

Cetak Laporan

</button>

</div>

<!-- ===========================
        TABLE
=========================== -->

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>
<th>Penyewa</th>
<th>Mobil</th>
<th>Periode</th>
<th>Hari</th>
<th>Total</th>
<th>Status</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

mysqli_data_seek($data,0);

while($row = mysqli_fetch_assoc($data)):

?>

<tr>

<td class="text-center">

<?= $no++; ?>

</td>

<td>

<strong>

<?= htmlspecialchars($row['nama']); ?>

</strong>

</td>

<td>

<?= htmlspecialchars($row['nama_mobil']); ?>

</td>

<td>

<?= $row['tanggal_mulai']; ?>

<br>

<small class="text-secondary">

s/d

<?= $row['tanggal_selesai']; ?>

</small>

</td>

<td class="text-center">

<?= $row['total_hari']; ?>

Hari

</td>

<td>

<strong>

Rp <?= number_format($row['total_harga'],0,',','.'); ?>

</strong>

</td>

<td class="text-center">

<?php

if($row['status']=="Menunggu Pembayaran"){

echo '<span class="badge badge-status status-menunggu">Menunggu</span>';

}elseif($row['status']=="Sedang Disewa"){

echo '<span class="badge badge-status status-disewa">Sedang Disewa</span>';

}elseif($row['status']=="Selesai"){

echo '<span class="badge badge-status status-selesai">Selesai</span>';

}else{

echo '<span class="badge badge-status status-batal">Dibatalkan</span>';

}

?>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

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

Halaman laporan ini digunakan untuk memantau seluruh transaksi
penyewaan kendaraan, pendapatan rental, serta status booking.
Informasi ini membantu administrator dalam melakukan evaluasi
dan pengambilan keputusan bisnis.

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
      TABLE ANIMATION
=========================== */

document.querySelectorAll("tbody tr").forEach((row,index)=>{

    row.style.opacity="0";
    row.style.transform="translateY(20px)";

    setTimeout(()=>{

        row.style.transition=".45s ease";

        row.style.opacity="1";

        row.style.transform="translateY(0)";

    },index*70);

});

/* ===========================
      BUTTON EFFECT
=========================== */

document.querySelectorAll(".btn").forEach(btn=>{

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