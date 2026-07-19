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

$query = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        mobil.nama_mobil
    FROM booking
    JOIN mobil
        ON booking.mobil_id = mobil.id
    WHERE booking.id='$booking_id'"
);

$booking = mysqli_fetch_assoc($query);

if (!$booking) {
    die("Data booking tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>

Upload Pembayaran | RentGo Black Gold Luxury

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
      PAYMENT CARD
=========================== */

.payment-card{

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

padding:22px;

margin-bottom:30px;

}

/* ===========================
      REKENING BOX
=========================== */

.rekening-box{

background:#181818;

border:1px solid rgba(212,175,55,.18);

border-radius:18px;

padding:25px;

transition:.3s;

}

.rekening-box:hover{

border-color:var(--gold);

}

/* ===========================
      PRICE
=========================== */

.price{

font-size:38px;

font-weight:900;

color:var(--gold);

margin-top:10px;

}

/* ===========================
      FORM
=========================== */

label{

font-weight:600;

margin-bottom:8px;

display:block;

}

.form-control,
.form-select{

background:#181818 !important;

border:1px solid #333 !important;

color:#fff !important;

border-radius:12px;

padding:12px 15px;

}

.form-control:focus,
.form-select:focus{

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
      PREVIEW
=========================== */

.preview-image{

display:none;

width:100%;

max-height:350px;

object-fit:contain;

border-radius:18px;

border:1px solid rgba(212,175,55,.18);

margin-top:20px;

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

.payment-card{

padding:22px;

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

Upload

<span>

Pembayaran

</span>

</h1>

<p>

Selesaikan pembayaran Anda agar proses verifikasi dapat segera dilakukan oleh Admin RentGo.

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

<div class="payment-card">

<h3 class="mb-4 text-warning">

<i class="fas fa-file-invoice-dollar me-2"></i>

Detail Booking

</h3>

<div class="info-box">

<div class="row">

<div class="col-md-6 mb-3">

<p class="mb-2">

<i class="fas fa-car-side text-warning me-2"></i>

<strong>Mobil</strong>

</p>

<h5>

<?= htmlspecialchars($booking['nama_mobil']); ?>

</h5>

</div>

<div class="col-md-6 mb-3">

<p class="mb-2">

<i class="fas fa-calendar-days text-warning me-2"></i>

<strong>Lama Sewa</strong>

</p>

<h5>

<?= $booking['total_hari']; ?>

Hari

</h5>

</div>

</div>

<hr class="border-secondary">

<p class="text-secondary mb-2">

Total Pembayaran

</p>

<div class="price">

Rp <?= number_format(
$booking['total_harga'],
0,
',',
'.'
); ?>

</div>

</div>

<form
action="proses_upload.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="booking_id"
value="<?= $booking['id']; ?>">

<input
type="hidden"
name="jumlah"
value="<?= $booking['total_harga']; ?>">

<div class="mb-4">

<label>

<i class="fas fa-building-columns text-warning me-2"></i>

Metode Pembayaran

</label>

<select
name="metode"
id="metode"
class="form-select"
required>

<option value="Transfer BRI">

Transfer BRI

</option>

<option value="Transfer BCA">

Transfer BCA

</option>

<option value="Transfer Mandiri">

Transfer Mandiri

</option>

</select>

</div>

<div
id="rekeningInfo"
class="rekening-box mb-4">

</div>

<div class="mb-4">

<label>

<i class="fas fa-image text-warning me-2"></i>

Upload Bukti Transfer

</label>

<input
type="file"
name="bukti"
id="bukti"
class="form-control"
accept=".jpg,.jpeg,.png"
required>

<img
id="preview"
class="preview-image"
alt="Preview Bukti Transfer">

</div>

<div class="d-grid gap-3 mt-4">

<button
type="submit"
class="btn btn-gold btn-lg">

<i class="fas fa-cloud-upload-alt me-2"></i>

Upload Bukti Pembayaran

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

Pastikan bukti transfer yang Anda unggah jelas dan sesuai
dengan nominal pembayaran agar proses verifikasi dapat
dilakukan lebih cepat oleh admin.

</p>

<hr class="border-secondary my-4">

<p class="text-secondary mb-0">

&copy; <?= date('Y'); ?>

RentGo Black Gold Luxury.

All Rights Reserved.

</p>

</div>

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

const metode =
document.getElementById('metode');

const rekeningInfo =
document.getElementById('rekeningInfo');

function tampilkanRekening(){

if(metode.value==='Transfer BRI'){

rekeningInfo.innerHTML=`
<h5 class="text-warning">
<i class="fas fa-building-columns me-2"></i>
Bank BRI
</h5>

<p class="mb-2">
Nomor Rekening
</p>

<h4>040401052602501</h4>

<p class="mb-0">
A/N :
<strong>Dedito Tobing</strong>
</p>
`;

}

else if(metode.value==='Transfer BCA'){

rekeningInfo.innerHTML=`
<h5 class="text-warning">
<i class="fas fa-building-columns me-2"></i>
Bank BCA
</h5>

<p class="mb-2">
Nomor Rekening
</p>

<h4>Sedang Dalam Perbaikan</h4>

<p class="mb-0">
A/N :
<strong>Dedito Tobing</strong>
</p>
`;

}

else{

rekeningInfo.innerHTML=`
<h5 class="text-warning">
<i class="fas fa-building-columns me-2"></i>
Bank Mandiri
</h5>

<p class="mb-2">
Nomor Rekening
</p>

<h4>Sedang Dalam Perbaikan</h4>

<p class="mb-0">
A/N :
<strong>Dedito Tobing</strong>
</p>
`;

}

}

metode.addEventListener(
'change',
tampilkanRekening
);

tampilkanRekening();

/* ===========================
      PREVIEW GAMBAR
=========================== */

const bukti =
document.getElementById('bukti');

const preview =
document.getElementById('preview');

bukti.addEventListener('change',function(){

const file=this.files[0];

if(file){

preview.src=URL.createObjectURL(file);

preview.style.display='block';

}else{

preview.src='';

preview.style.display='none';

}

});

</script>

</body>

</html>