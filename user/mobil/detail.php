<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = mysqli_query(
    $conn,
    "SELECT * FROM mobil WHERE id='$id'"
);

$mobil = mysqli_fetch_assoc($query);

if(!$mobil){
    die("Mobil tidak ditemukan.");
}

/* =========================
   RATING
========================= */

$qRating = mysqli_query(
    $conn,
    "SELECT
        AVG(rating) AS rata_rating,
        COUNT(id) AS total_review
    FROM review
    WHERE mobil_id='$id'"
);

$ratingData = mysqli_fetch_assoc($qRating);

$rataRating =
    round(
        $ratingData['rata_rating'] ?? 0,
        1
    );

$totalReview =
    $ratingData['total_review'] ?? 0;

/* =========================
   REVIEW
========================= */

$review = mysqli_query(
    $conn,
    "SELECT
        review.*,
        users.nama
    FROM review
    JOIN users
        ON review.user_id = users.id
    WHERE review.mobil_id='$id'
    ORDER BY review.id DESC"
);

/* =========================
   GAMBAR
========================= */

$namaMobil =
    strtolower(
        trim($mobil['nama_mobil'])
    );

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

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
<?= htmlspecialchars($mobil['nama_mobil']) ?>
- RentGo
</title>

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

    min-height:50vh;

    display:flex;
    align-items:center;

    background:
    linear-gradient(
        rgba(0,0,0,.78),
        rgba(0,0,0,.78)
    ),
    url('../../assets/img/hero.jpg');

    background-size:cover;
    background-position:center;

    text-align:center;
}

.hero h1{

    font-size:65px;

    font-weight:900;
}

.hero p{

    color:#ddd;
}

/* IMAGE */

.car-image{

    width:100%;

    height:550px;

    object-fit:cover;

    border-radius:25px;

    border:1px solid rgba(212,175,55,.15);

    box-shadow:
    0 0 40px rgba(212,175,55,.10);
}

/* CARD */

.info-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:25px;

    padding:35px;

    height:100%;
}

.info-card h2{

    font-size:42px;

    font-weight:900;
}

.rating{

    color:var(--gold);

    font-size:24px;
}

.price{

    color:var(--gold);

    font-size:42px;

    font-weight:900;
}

.detail-text{

    color:#ddd;
}

/* REVIEW */

.review-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.12);

    border-radius:20px;

    padding:25px;

    margin-bottom:20px;
}

/* BUTTON */

.btn-gold{

    background:var(--gold);

    color:#000;

    border:none;

    font-weight:700;

    border-radius:12px;

    padding:14px;
}

.btn-gold:hover{

    background:#c69d22;

    color:#000;
}

.section{
    padding:90px 0;
}

</style>

</head>

<body>

<!-- HERO -->

<section class="hero">

<div class="container">

<h1>

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h1>

<p>

Luxury Vehicle Details

</p>

<a
href="index.php"
class="btn btn-warning mt-3"
>

← Kembali ke Fleet

</a>

</div>

</section>

<!-- DETAIL -->

<section class="section">

<div class="container">

<div class="row g-4">

<div class="col-lg-6">

<img
src="<?= $gambar ?>"
class="car-image"
alt="<?= htmlspecialchars($mobil['nama_mobil']) ?>"
>

</div>

<div class="col-lg-6">

<div class="info-card">

<h2>

<?= htmlspecialchars($mobil['nama_mobil']) ?>

</h2>

<hr class="text-secondary">

<div class="rating mb-2">

<?php

$bintang = round($rataRating);

for($i=1;$i<=$bintang;$i++){
    echo "⭐";
}

?>

<?= $rataRating ?>/5

</div>

<small class="text-light">

<?= $totalReview ?> Review

</small>

<hr class="text-secondary">

<p class="detail-text">
<strong>Merk :</strong>
<?= htmlspecialchars($mobil['merk']) ?>
</p>

<p class="detail-text">
<strong>Tahun :</strong>
<?= htmlspecialchars($mobil['tahun']) ?>
</p>

<p class="detail-text">
<strong>Plat :</strong>
<?= htmlspecialchars($mobil['plat_nomor']) ?>
</p>

<p class="detail-text">
<strong>Warna :</strong>
<?= htmlspecialchars($mobil['warna']) ?>
</p>

<p class="detail-text">
<strong>Transmisi :</strong>
<?= htmlspecialchars($mobil['transmisi']) ?>
</p>

<p class="detail-text">
<strong>Bahan Bakar :</strong>
<?= htmlspecialchars($mobil['bahan_bakar']) ?>
</p>

<p class="detail-text">
<strong>Kapasitas :</strong>
<?= htmlspecialchars($mobil['kapasitas_penumpang']) ?>
 Orang
</p>

<p>

<strong>Status :</strong>

<?php if($mobil['status']=='Tersedia'): ?>

<span class="badge bg-success">
Tersedia
</span>

<?php else: ?>

<span class="badge bg-danger">
<?= htmlspecialchars($mobil['status']) ?>
</span>

<?php endif; ?>

</p>

<hr class="text-secondary">

<p class="detail-text">

<strong>Deskripsi :</strong>

<br><br>

<?= nl2br(
htmlspecialchars(
$mobil['deskripsi']
)
); ?>

</p>

<div class="price mt-4">

Rp <?= number_format(
$mobil['harga_per_hari'],
0,
',',
'.'
); ?>

<span style="font-size:18px;color:#bbb;">
/ Hari
</span>

</div>

<hr class="text-secondary">

<?php if($mobil['status']=='Tersedia'): ?>

<a
href="../booking/sewa.php?id=<?= $mobil['id'] ?>"
class="btn btn-gold btn-lg w-100"
>

<i class="fas fa-calendar-check me-2"></i>

Booking Sekarang

</a>

<?php else: ?>

<button
class="btn btn-danger btn-lg w-100"
disabled>

Sedang Disewa

</button>

<?php endif; ?>

</div>

</div>

</div>

</div>

</section>

<!-- REVIEW -->

<section class="section">

<div class="container">

<h2 class="mb-5">

⭐ Customer Reviews

</h2>

<?php if(mysqli_num_rows($review)>0): ?>

<?php while($r=mysqli_fetch_assoc($review)): ?>

<div class="review-card">

<h5>

<?= htmlspecialchars($r['nama']) ?>

</h5>

<div class="rating">

<?php

for(
$i=1;
$i<=$r['rating'];
$i++
){
echo "⭐";
}

?>

</div>

<p class="mt-3 text-light">

<?= nl2br(
htmlspecialchars(
$r['komentar']
)
); ?>

</p>

<small class="text-secondary">

<?= $r['created_at'] ?>

</small>

</div>

<?php endwhile; ?>

<?php else: ?>

<div class="alert alert-dark">

Belum ada review untuk mobil ini.

</div>

<?php endif; ?>

</div>

</section>

</body>
</html>
