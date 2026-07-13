<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['id'];

$user = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT no_hp, alamat
        FROM users
        WHERE id='$user_id'"
    )
);

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_query(
    $conn,
    "SELECT * FROM mobil WHERE id = $id"
);

if (!$query) {
    die("Query Error : " . mysqli_error($conn));
}

$mobil = mysqli_fetch_assoc($query);

if (!$mobil) {
    die("Mobil tidak ditemukan.");
}

if ($mobil['status'] != 'Tersedia') {

    echo "
    <script>
        alert('Mobil sedang disewa dan tidak dapat dibooking.');
        window.location='../mobil/index.php';
    </script>
    ";

    exit;
}

if ($mobil['nama_mobil'] == 'Alphard') {
    $gambar = '../../assets/img/alphard.jpg';
}
elseif ($mobil['nama_mobil'] == 'Innova Reborn') {
    $gambar = '../../assets/img/innova.jpg';
}
elseif ($mobil['nama_mobil'] == 'Avanza') {
    $gambar = '../../assets/img/avanza.jpg';
}
else {
    $gambar = '../../assets/img/hero.jpg';
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Booking Mobil - RentGo</title>

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

/* HERO */

.hero{

    min-height:40vh;

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

    font-size:60px;

    font-weight:900;
}

.hero span{
    color:var(--gold);
}

/* CARD */

.luxury-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:25px;

    padding:25px;
}

.car-image{

    width:100%;

    height:320px;

    object-fit:cover;

    border-radius:20px;
}

.price{

    color:var(--gold);

    font-size:32px;

    font-weight:900;
}

.form-control,
textarea{

    background:#1a1a1a !important;

    border:1px solid #333 !important;

    color:white !important;
}

.form-control:focus,
textarea:focus{

    border-color:var(--gold) !important;

    box-shadow:none !important;
}

/* BUTTON */

.btn-gold{

    background:var(--gold);

    color:#000;

    font-weight:700;

    border:none;

    border-radius:12px;

    padding:12px;
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

<p class="text-light">

Lengkapi data rental dan nikmati perjalanan premium bersama RentGo

</p>

</div>

</section>

<section class="section">

<div class="container">

<div class="row g-4">

<!-- MOBIL -->

<div class="col-lg-4">

<div class="luxury-card">

<img
src="<?= $gambar ?>"
class="car-image"
>

<h3 class="mt-4">

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h3>

<hr class="text-secondary">

<p>
<strong>Merk :</strong>
<?= htmlspecialchars($mobil['merk']) ?>
</p>

<p>
<strong>Tahun :</strong>
<?= htmlspecialchars($mobil['tahun']) ?>
</p>

<p>
<strong>Transmisi :</strong>
<?= htmlspecialchars($mobil['transmisi']) ?>
</p>

<p>

Status :

<span class="badge bg-success">

Tersedia

</span>

</p>

<div class="price">

Rp <?= number_format(
$mobil['harga_per_hari'],
0,
',',
'.'
); ?>

<span style="font-size:16px;color:#ccc;">
/ Hari
</span>

</div>

</div>

</div>

<!-- FORM -->

<div class="col-lg-8">

<form action="proses_booking.php" method="POST">

<input
type="hidden"
name="mobil_id"
value="<?= $mobil['id'] ?>"
>

<div class="luxury-card mb-4">

<h4 class="mb-4">

Data Penyewa

</h4>

<div class="mb-3">

<label>Nomor HP</label>

<input
type="text"
name="no_hp"
class="form-control"
required
value="<?= $user['no_hp'] ?? '' ?>"
>

</div>

<div class="mb-3">

<label>Alamat Lengkap</label>

<textarea
name="alamat"
class="form-control"
rows="4"
required
><?= $user['alamat'] ?? '' ?></textarea>

</div>

</div>

<div class="luxury-card">

<h4 class="mb-4">

Data Rental

</h4>

<div class="row">

<div class="col-md-6 mb-3">

<label>Tanggal Mulai</label>

<input
type="date"
name="tanggal_mulai"
class="form-control"
required
>

</div>

<div class="col-md-6 mb-3">

<label>Tanggal Selesai</label>

<input
type="date"
name="tanggal_selesai"
class="form-control"
required
>

</div>

</div>

<button
type="submit"
class="btn btn-gold w-100"
>

Booking Sekarang

</button>

<a
href="../mobil/index.php"
class="btn btn-outline-light w-100 mt-3"
>

Kembali ke Fleet

</a>

</div>

</form>

</div>

</div>

</div>

</section>

</body>
</html>
