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
    WHERE booking.id = '$booking_id'"
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
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Upload Pembayaran - RentGo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

:root{
    --gold:#d4af37;
    --dark:#050505;
    --card:#111111;
}

body{
    background:var(--dark);
    color:white;
    font-family:'Segoe UI',sans-serif;
}

.hero{

    min-height:35vh;

    display:flex;
    align-items:center;
    justify-content:center;

    text-align:center;

    background:
    linear-gradient(
        rgba(0,0,0,.80),
        rgba(0,0,0,.80)
    ),
    url('../../assets/img/hero.jpg');

    background-size:cover;
    background-position:center;
}

.hero h1{

    font-size:60px;

    font-weight:900;
}

.hero span{
    color:var(--gold);
}

.section{
    padding:80px 0;
}

.payment-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:25px;

    padding:35px;
}

.info-box{

    background:#1a1a1a;

    border-left:4px solid var(--gold);

    padding:20px;

    border-radius:12px;

    margin-bottom:25px;
}

.form-control,
.form-select{

    background:#1a1a1a !important;

    border:1px solid #333 !important;

    color:white !important;
}

.form-control:focus,
.form-select:focus{

    border-color:var(--gold) !important;

    box-shadow:none !important;
}

.btn-gold{

    background:var(--gold);

    color:#000;

    border:none;

    font-weight:700;

    padding:12px;

    border-radius:12px;
}

.btn-gold:hover{

    background:#c79d1c;

    color:#000;
}

.rekening-box{

    background:#1a1a1a;

    border:1px solid rgba(212,175,55,.20);

    border-radius:15px;

    padding:20px;
}

.price{

    color:var(--gold);

    font-size:32px;

    font-weight:900;
}

</style>

</head>

<body>

<section class="hero">

<div class="container">

<h1>

Upload <span>Pembayaran</span>

</h1>

<p class="text-light">

Selesaikan pembayaran untuk mengaktifkan booking Anda

</p>

</div>

</section>

<section class="section">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="payment-card">

<h3 class="mb-4">

Detail Booking

</h3>

<div class="info-box">

<p>
<strong>Mobil :</strong>
<?= htmlspecialchars($booking['nama_mobil']); ?>
</p>

<p>
<strong>Lama Sewa :</strong>
<?= $booking['total_hari']; ?> Hari
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
enctype="multipart/form-data"
>

<input
type="hidden"
name="booking_id"
value="<?= $booking['id']; ?>"
>

<div class="mb-4">

<label class="form-label">

Metode Pembayaran

</label>

<select
name="metode"
id="metode"
class="form-select"
required
>

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
class="rekening-box mb-4"
>

</div>

<input
type="hidden"
name="jumlah"
value="<?= $booking['total_harga']; ?>"
>

<div class="mb-4">

<label class="form-label">

Upload Bukti Transfer

</label>

<input
type="file"
name="bukti"
class="form-control"
accept=".jpg,.jpeg,.png"
required
>

</div>

<button
type="submit"
class="btn btn-gold w-100"
>

Upload Bukti Pembayaran

</button>

<a
href="../booking/riwayat.php"
class="btn btn-outline-light w-100 mt-3"
>

Kembali

</a>

</form>

</div>

</div>

</div>

</div>

</section>

<script>

const metode =
document.getElementById('metode');

const rekeningInfo =
document.getElementById('rekeningInfo');

function tampilkanRekening(){

if(metode.value==='Transfer BRI'){

rekeningInfo.innerHTML=`
<h5>Bank BRI</h5>
No Rekening :
<strong>040401052602501</strong>
<br><br>
A/N :
<strong>Dedito Tobing</strong>
`;
}

else if(metode.value==='Transfer BCA'){

rekeningInfo.innerHTML=`
<h5>Bank BCA</h5>
No Rekening :
<strong>Sedang Dalam Perbaikan</strong>
<br><br>
A/N :
<strong>Dedito Tobing</strong>
`;
}

else{

rekeningInfo.innerHTML=`
<h5>Bank Mandiri</h5>
No Rekening :
<strong>Sedang Dalam Perbaikan</strong>
<br><br>
A/N :
<strong>Dedito Tobing</strong>
`;
}

}

metode.addEventListener(
'change',
tampilkanRekening
);

tampilkanRekening();

</script>

</body>
</html>
