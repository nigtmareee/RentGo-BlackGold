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

$id = (int) $_SESSION['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$id'"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    die("Data admin tidak ditemukan.");
}

if (isset($_POST['simpan'])) {

    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $passwordBaru = trim($_POST['password']);

    if (!empty($passwordBaru)) {

        $passwordHash = md5($passwordBaru);

        $update = mysqli_query(
            $conn,
            "UPDATE users SET
                nama='$nama',
                email='$email',
                no_hp='$no_hp',
                alamat='$alamat',
                password='$passwordHash'
            WHERE id='$id'"
        );

    } else {

        $update = mysqli_query(
            $conn,
            "UPDATE users SET
                nama='$nama',
                email='$email',
                no_hp='$no_hp',
                alamat='$alamat'
            WHERE id='$id'"
        );

    }

    if ($update) {

        $_SESSION['nama'] = $nama;

        echo "
        <script>
            alert('Profil berhasil diperbarui');
            window.location='index.php';
        </script>
        ";
        exit;
    }

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>

Profil Admin | RentGo Black Gold Luxury

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
rgba(0,0,0,.75),
rgba(0,0,0,.85)
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
        PROFILE CARD
==========================*/

.profile-card{

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
        AVATAR
==========================*/

.profile-avatar{

width:120px;
height:120px;

margin:auto;

border-radius:50%;

display:flex;

align-items:center;

justify-content:center;

background:#181818;

border:4px solid var(--gold);

box-shadow:0 0 30px rgba(212,175,55,.20);

}

.profile-avatar i{

font-size:52px;

color:var(--gold);

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

textarea.form-control{

resize:none;

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

.btn-outline-gold{

border:1px solid var(--gold);

color:var(--gold);

border-radius:12px;

padding:12px 22px;

transition:.3s;

}

.btn-outline-gold:hover{

background:var(--gold);

color:#000;

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
      RESPONSIVE
==========================*/

@media(max-width:768px){

.hero h1{

font-size:42px;

}

.profile-card{

padding:22px;

}

.profile-avatar{

width:95px;
height:95px;

}

.profile-avatar i{

font-size:42px;

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
class="btn btn-outline-gold">

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

Profil

<span>

Admin

</span>

</h1>

<p>

Kelola informasi akun administrator RentGo Black Gold Luxury
dengan aman dan profesional.

</p>

</div>

</section>

<!-- ===========================
        CONTENT
=========================== -->

<section class="section">

<div class="container">

<div class="row justify-content-center">

<div class="col-lg-9">

<div class="profile-card">

<div class="text-center mb-5">

<div class="profile-avatar">

<i class="fas fa-user-shield"></i>

</div>

<h3 class="mt-4 text-warning fw-bold">

<?= htmlspecialchars($user['nama']); ?>

</h3>

<p class="text-secondary mb-0">

Administrator RentGo Black Gold Luxury

</p>

</div>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-user text-warning me-2"></i>

Nama Lengkap

</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= htmlspecialchars($user['nama']); ?>"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-envelope text-warning me-2"></i>

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($user['email']); ?>"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-phone text-warning me-2"></i>

Nomor HP

</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= htmlspecialchars($user['no_hp'] ?? ''); ?>">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

<i class="fas fa-lock text-warning me-2"></i>

Password Baru

</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Kosongkan jika tidak ingin mengganti">

<small class="text-secondary">

Kosongkan apabila password tidak ingin diubah.

</small>

</div>

<div class="col-12 mb-4">

<label class="form-label">

<i class="fas fa-location-dot text-warning me-2"></i>

Alamat

</label>

<textarea
name="alamat"
class="form-control"
rows="5"
placeholder="Masukkan alamat lengkap..."><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>

</div>

<div class="col-12">

<div class="d-flex justify-content-end gap-3 flex-wrap">

<a
href="../dashboard.php"
class="btn btn-outline-gold">

<i class="fas fa-arrow-left me-2"></i>

Kembali

</a>

<button
type="submit"
name="simpan"
class="btn btn-gold">

<i class="fas fa-save me-2"></i>

Simpan Perubahan

</button>

</div>

</div>

</div>

</form>

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

Kelola informasi akun administrator dengan aman untuk menjaga
integritas sistem RentGo Black Gold Luxury. Pastikan data profil
selalu diperbarui agar komunikasi dan pengelolaan sistem berjalan
dengan optimal.

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
      FORM ANIMATION
=========================== */

document.querySelectorAll(".form-control").forEach((input)=>{

    input.addEventListener("focus",function(){

        this.style.transform="translateY(-2px)";
        this.style.transition=".3s";

    });

    input.addEventListener("blur",function(){

        this.style.transform="translateY(0)";

    });

});

/* ===========================
      BUTTON EFFECT
=========================== */

document.querySelectorAll(".btn").forEach((btn)=>{

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