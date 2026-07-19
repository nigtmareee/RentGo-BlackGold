<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

// Helper untuk menghindari error jika ada pemanggilan e()
if (!function_exists('e')) {
    function e($text)
    {
        return htmlspecialchars($text ?? '', ENT_QUOTES, 'UTF-8');
    }
}

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;

$query = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        users.nama,
        users.email,
        users.no_hp,
        users.alamat,
        mobil.nama_mobil,
        mobil.harga_per_hari
    FROM booking
    JOIN users
        ON booking.user_id = users.id
    JOIN mobil
        ON booking.mobil_id = mobil.id
    WHERE booking.id='$id'"
);

$invoice = mysqli_fetch_assoc($query);

if (!$invoice) {
    die("Invoice tidak ditemukan.");
}

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

Invoice Rental

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">

<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
rel="stylesheet">

<style>

*{

margin:0;
padding:0;
box-sizing:border-box;

}

body{

font-family:'Poppins',sans-serif;
background:#050505;
color:#fff;

}

/*==============================
INVOICE CONTAINER
==============================*/

.invoice-box{

max-width:1100px;

margin:50px auto;

background:#111;

border-radius:25px;

overflow:hidden;

border:1px solid rgba(255, 255, 255, 0.15);

box-shadow:0 20px 50px rgba(0,0,0,.45);

}

/*==============================
HEADER
==============================*/

.invoice-header{

background:linear-gradient(135deg,#111,#1c1c1c);

padding:45px;

text-align:center;

border-bottom:1px solid rgba(212,175,55,.18);

}

.invoice-header h1{

font-size:42px;

font-weight:800;

color:#d4af37;

margin-bottom:10px;

letter-spacing:2px;

}

.invoice-header p{

color:#bbb;

font-size:18px;

}

/*==============================
TITLE
==============================*/

.invoice-title{

padding:35px 40px 15px;

display:flex;

justify-content:space-between;

align-items:center;

flex-wrap:wrap;

}

.invoice-title h2{

font-weight:700;

font-size:34px;

color:#fff;

}

.invoice-number{

background:#d4af37;

color:#000;

padding:12px 25px;

border-radius:40px;

font-weight:700;

}

/*==============================
TABLE
==============================*/

.table{

margin-bottom:0;

color:#fff;

}

.table th{

background:#1b1b1b;

width:280px;

color:#d4af37;

font-weight:600;

padding:16px;

border-color:#2a2a2a;

}

.table td{

background:#151515;

color:#ffffff;

padding:16px;

border-color:#2a2a2a;

}

/*==============================
BADGE
==============================*/

.badge{

padding:10px 18px;

font-size:14px;

border-radius:30px;

}

/*==============================
TOTAL CARD
==============================*/

.total-box{

margin:35px;

background:#191919;

border:1px solid rgba(212,175,55,.15);

border-radius:18px;

padding:30px;

}

.total-box h3{

color:#d4af37;

font-weight:700;

margin-bottom:10px;

}

.total-box h1{

font-size:42px;

font-weight:800;

}

/*==============================
BUTTON
==============================*/

.btn-gold{

background:#d4af37;

color:#000;

border:none;

font-weight:700;

padding:14px 28px;

border-radius:40px;

transition:.3s;

}

.btn-gold:hover{

background:#f0c64f;

transform:translateY(-2px);

}

.btn-darkx{

background:#2d2d2d;

color:#fff;

border:none;

padding:14px 28px;

border-radius:40px;

}

.btn-darkx:hover{

background:#3b3b3b;

color:#fff;

}

/*==============================
FOOTER
==============================*/

.invoice-footer{

padding:30px;

text-align:center;

border-top:1px solid rgba(212,175,55,.15);

color:#999;

font-size:15px;

}

/*==============================
PRINT
==============================*/

@media print{

body{

background:#fff;

}

.btn-area{

display:none;

}

.invoice-box{

box-shadow:none;

border:none;

}

}

/*==============================
RESPONSIVE
==============================*/

@media(max-width:768px){

.invoice-title{

flex-direction:column;

gap:20px;

}

.invoice-header h1{

font-size:30px;

}

.table th{

width:180px;

}

}

</style>

</head>
<body>

<div class="container py-5">

<div class="invoice-box">

<!-- =========================
HEADER
========================= -->

<div class="invoice-header">

<i class="fas fa-car-side fa-4x text-warning mb-3"></i>

<h1>

RentGo Rental Mobil

</h1>

<p>

Luxury Car Rental Invoice

</p>

</div>

<!-- =========================
TITLE
========================= -->

<div class="invoice-title">

<div>

<h2>

Invoice Rental

</h2>

<p class="text-secondary">

Bukti Transaksi Penyewaan Mobil

</p>

</div>

<div class="invoice-number">

INV-<?= str_pad($invoice['id'],5,"0",STR_PAD_LEFT); ?>

</div>

</div>

<!-- =========================
TABLE
========================= -->

<div class="table-responsive">

<table class="table table-bordered align-middle">

<tr>

<th>

<i class="fas fa-user me-2"></i>

Nama Penyewa

</th>

<td>

<?= htmlspecialchars($invoice['nama']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-envelope me-2"></i>

Email

</th>

<td>

<?= htmlspecialchars($invoice['email']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-phone me-2"></i>

No Handphone

</th>

<td>

<?= htmlspecialchars($invoice['no_hp']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-location-dot me-2"></i>

Alamat

</th>

<td>

<?= htmlspecialchars($invoice['alamat']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-car me-2"></i>

Mobil

</th>

<td>

<?= htmlspecialchars($invoice['nama_mobil']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-calendar-day me-2"></i>

Tanggal Mulai

</th>

<td>

<?= htmlspecialchars($invoice['tanggal_mulai']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-calendar-check me-2"></i>

Tanggal Selesai

</th>

<td>

<?= htmlspecialchars($invoice['tanggal_selesai']) ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-clock me-2"></i>

Total Hari

</th>

<td>

<strong>

<?= $invoice['total_hari']; ?>

Hari

</strong>

</td>

</tr>

<tr>

<th>

<i class="fas fa-money-bill-wave me-2"></i>

Harga / Hari

</th>

<td>

Rp

<?= number_format(

$invoice['harga_per_hari'],

0,

',',

'.'

); ?>

</td>

</tr>

<tr>

<th>

<i class="fas fa-wallet me-2"></i>

Status Rental

</th>

<td>

<?php

$status=$invoice['status'];

if($status=="Selesai"){

echo '<span class="badge bg-success">Selesai</span>';

}elseif($status=="Sedang Disewa"){

echo '<span class="badge bg-primary">Sedang Berlangsung</span>';

}elseif($status=="Dibayar"){

echo '<span class="badge bg-info text-dark">Dibayar</span>';

}elseif($status=="Menunggu Pembayaran"){

echo '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>';

}else{

echo '<span class="badge bg-secondary">'.$status.'</span>';

}

?>

</td>

</tr>

</table>

</div>

<!-- =========================
TOTAL PEMBAYARAN
========================= -->

<div class="total-box">

<div class="row align-items-center">

<div class="col-lg-8">

<h3>

<i class="fas fa-receipt me-2"></i>

Total Pembayaran

</h3>

<p class="text-secondary mb-0">

Total biaya rental yang harus dibayarkan.

</p>

</div>

<div class="col-lg-4 text-lg-end mt-4 mt-lg-0">

<h1>

Rp <?= number_format(

$invoice['total_harga'],

0,

',',

'.'

); ?>

</h1>

</div>

</div>

</div>

<!-- =========================
BUTTON AREA
========================= -->

<div class="btn-area text-center pb-5">

<button
onclick="window.print()"
class="btn btn-gold me-3">

<i class="fas fa-print me-2"></i>

Cetak Invoice

</button>

<a
href="../booking/riwayat.php"
class="btn btn-darkx">

<i class="fas fa-arrow-left me-2"></i>

Kembali

</a>

</div>

<!-- =========================
FOOTER
========================= -->

<div class="invoice-footer">

<div class="row align-items-center">

<div class="col-md-6 text-md-start text-center">

<h5
style="
color:#d4af37;
font-weight:700;
">

RentGo Rental Mobil

</h5>

<p class="mb-0">

Luxury Car Rental Service

</p>

</div>

<div class="col-md-6 text-md-end text-center mt-4 mt-md-0">

<p class="mb-1">

Invoice dibuat pada

</p>

<strong>

<?= date('d F Y H:i'); ?>

</strong>

</div>

</div>

<hr
style="
border-color:rgba(212,175,55,.15);
margin:30px 0;
">

<div class="row">

<div class="col-md-6">

<p>

<strong>

Alamat

</strong>

</p>

<p>

Jl. RentGo Luxury No. 88

<br>

Medan, Sumatera Utara

</p>

</div>

<div class="col-md-6 text-md-end">

<p>

<strong>

Kontak

</strong>

</p>

<p>

Email :
info@rentgo.com

<br>

Telp :
+62 812-3456-7890

</p>

</div>

</div>

<hr
style="
border-color:rgba(212,175,55,.15);
">

<p
class="mb-0"
style="
color:#888;
">

© <?= date('Y'); ?>

RentGo Black Gold Luxury

<br>

Terima kasih telah mempercayakan perjalanan Anda kepada RentGo.

</p>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

/*==============================
Fade Animation
==============================*/

document.addEventListener("DOMContentLoaded",function(){

const invoice=document.querySelector(".invoice-box");

invoice.style.opacity="0";

invoice.style.transform="translateY(40px)";

invoice.style.transition="all .8s ease";

setTimeout(function(){

invoice.style.opacity="1";

invoice.style.transform="translateY(0)";

},200);

});

</script>

</body>

</html>