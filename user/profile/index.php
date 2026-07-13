<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$user_id = $_SESSION['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users
    WHERE id='$user_id'"
);

$user = mysqli_fetch_assoc($query);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Profil Saya - RentGo</title>

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

.hero p{
    color:#d8d8d8;
}

/* SECTION */

.section{
    padding:80px 0;
}

/* PROFILE CARD */

.profile-card{

    background:var(--card);

    border:1px solid rgba(212,175,55,.15);

    border-radius:25px;

    padding:40px;

    box-shadow:
    0 0 30px rgba(212,175,55,.08);
}

/* AVATAR */

.avatar{

    width:120px;

    height:120px;

    border-radius:50%;

    background:linear-gradient(
        135deg,
        #d4af37,
        #c79d1c
    );

    display:flex;

    align-items:center;

    justify-content:center;

    margin:auto;

    font-size:48px;

    color:black;

    font-weight:900;
}

/* FORM */

.form-label{

    color:#d4af37;

    font-weight:600;
}

.form-control{

    background:#1a1a1a !important;

    border:1px solid #333 !important;

    color:white !important;

    border-radius:12px;

    padding:12px;
}

.form-control:focus{

    border-color:#d4af37 !important;

    box-shadow:none !important;
}

/* BUTTON */

.btn-gold{

    background:#d4af37;

    color:black;

    border:none;

    font-weight:700;

    border-radius:12px;

    padding:12px;
}

.btn-gold:hover{

    background:#c79d1c;

    color:black;
}

.btn-dark-custom{

    border:1px solid #555;

    color:white;

    border-radius:12px;

    padding:12px;
}

.btn-dark-custom:hover{

    background:#222;

    color:white;
}

/* INFO */

.profile-info{

    text-align:center;

    margin-top:20px;

    margin-bottom:35px;
}

.profile-info h3{

    font-weight:800;
}

.profile-info p{

    color:#bbb;
}

</style>

</head>

<body>

<!-- HERO -->

<section class="hero">

<div class="container">

<h1>

Profil <span>Saya</span>

</h1>

<p>

Kelola informasi akun RentGo Anda

</p>

</div>

</section>

<!-- PROFILE -->

<section class="section">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="profile-card">

<div class="avatar">

<?= strtoupper(substr($user['nama'],0,1)); ?>

</div>

<div class="profile-info">

<h3>

<?= htmlspecialchars($user['nama']); ?>

</h3>

<p>

Member RentGo Premium

</p>

</div>

<form
action="update.php"
method="POST"
>

<div class="mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= htmlspecialchars($user['nama']); ?>"
required
>

</div>

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($user['email']); ?>"
required
>

</div>

<div class="mb-3">

<label class="form-label">

Nomor HP

</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= htmlspecialchars($user['no_hp']); ?>"
>

</div>

<div class="mb-4">

<label class="form-label">

Alamat

</label>

<textarea
name="alamat"
class="form-control"
rows="4"
><?= htmlspecialchars($user['alamat']); ?></textarea>

</div>

<div class="row">

<div class="col-md-6 mb-2">

<button
type="submit"
class="btn btn-gold w-100"
>

<i class="fas fa-save me-2"></i>

Simpan Perubahan

</button>

</div>

<div class="col-md-6 mb-2">

<a
href="../dashboard.php"
class="btn btn-dark-custom w-100"
>

<i class="fas fa-arrow-left me-2"></i>

Kembali ke Dashboard

</a>

</div>

</div>

</form>

</div>

</div>

</div>

</div>

</section>

</body>
</html>