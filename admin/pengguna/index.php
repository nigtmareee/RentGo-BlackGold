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

$data = mysqli_query(
    $conn,
    "SELECT * FROM users ORDER BY id DESC"
);

if (!$data) {
    die(mysqli_error($conn));
}

$totalPengguna = mysqli_num_rows($data);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>

Kelola Pengguna | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

    --gold:#d4af37;
    --gold-light:#f5d56d;
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

    background:rgba(5,5,5,.96);

    backdrop-filter:blur(14px);

    border-bottom:1px solid rgba(212,175,55,.15);

    padding:15px 0;

    position:sticky;

    top:0;

    z-index:999;

}

.logo{

    color:var(--gold);

    font-size:30px;

    font-weight:800;

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
    rgba(0,0,0,.80),
    rgba(0,0,0,.88)
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

    color:#dddddd;

}

/* ===========================
        SECTION
=========================== */

.section{

    padding:80px 0;

}

/* ===========================
      STATISTIC CARD
=========================== */

.stat-card{

    background:linear-gradient(
    145deg,
    var(--card),
    var(--card2)
    );

    border:1px solid var(--border);

    border-radius:24px;

    padding:28px;

    box-shadow:0 20px 45px rgba(0,0,0,.45);

    transition:.35s;

}

.stat-card:hover{

    transform:translateY(-6px);

    border-color:var(--gold);

}

.stat-icon{

    width:70px;

    height:70px;

    border-radius:18px;

    display:flex;

    align-items:center;

    justify-content:center;

    background:rgba(212,175,55,.12);

    margin-bottom:18px;

}

.stat-icon i{

    font-size:30px;

    color:var(--gold);

}

.stat-title{

    color:#bbbbbb;

    font-size:15px;

}

.stat-number{

    font-size:36px;

    font-weight:800;

    color:var(--gold);

}

/* ===========================
        TABLE CARD
=========================== */

.table-card{

    background:linear-gradient(
    145deg,
    var(--card),
    var(--card2)
    );

    border:1px solid var(--border);

    border-radius:22px;

    padding:25px;

    box-shadow:0 20px 45px rgba(0,0,0,.45);

}

/* ===========================
        TABLE
=========================== */

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

    white-space:nowrap;

    padding:15px;

}

.table tbody tr{

    transition:.3s;

}

.table tbody tr:hover{

    background:#1b1b1b;

}

.table td{

    border-color:#2b2b2b;

    vertical-align:middle;

    padding:14px;

}

/* ===========================
        BADGES
=========================== */

.badge-admin{

    background:#dc3545;

    color:#fff;

    padding:8px 16px;

    border-radius:50px;

    font-size:13px;

}

.badge-user{

    background:linear-gradient(
    135deg,
    var(--gold),
    #b98d12
    );

    color:#000;

    padding:8px 16px;

    border-radius:50px;

    font-size:13px;

    font-weight:700;

}

/* ===========================
        BUTTONS
=========================== */

.btn-gold{

    background:linear-gradient(
    135deg,
    var(--gold),
    #b98d12
    );

    color:#000;

    border:none;

    font-weight:700;

    border-radius:12px;

    padding:11px 22px;

    transition:.3s;

}

.btn-gold:hover{

    color:#000;

    transform:translateY(-2px);

    box-shadow:0 10px 25px rgba(212,175,55,.25);

}

.btn-delete{

    background:#dc3545;

    color:#fff;

    border:none;

    border-radius:10px;

}

.btn-delete:hover{

    background:#bb2d3b;

    color:#fff;

}

.btn-my{

    background:#444;

    color:#fff;

    border:none;

    border-radius:10px;

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

.stat-number{

    font-size:28px;

}

.table-card{

    padding:18px;

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

<div class="container">

<h1>

Kelola <span>Pengguna</span>

</h1>

<p>

Manajemen seluruh akun pengguna RentGo Black Gold Luxury
secara aman, cepat, dan profesional.

</p>

</div>

</section>

<!-- ===========================
            CONTENT
=========================== -->

<section class="section">

<div class="container">

<!-- Statistik -->

<div class="row mb-4">

<div class="col-lg-4">

<div class="stat-card">

<div class="stat-icon">

<i class="fas fa-users"></i>

</div>

<div class="stat-title">

Total Pengguna

</div>

<div class="stat-number">

<?= $totalPengguna ?>

</div>

</div>

</div>

</div>

<!-- Table -->

<div class="table-card">

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">

<div>

<h3 class="text-warning fw-bold mb-1">

<i class="fas fa-users-cog me-2"></i>

Daftar Pengguna

</h3>

<p class="text-secondary mb-0">

Seluruh akun yang terdaftar pada sistem RentGo.

</p>

</div>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>

<th>Nama</th>

<th>Email</th>

<th>No HP</th>

<th>Alamat</th>

<th>Role</th>

<th width="170">

Aksi

</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

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

<?= htmlspecialchars($row['email']); ?>

</td>

<td>

<?= !empty($row['no_hp']) ? htmlspecialchars($row['no_hp']) : '-'; ?>

</td>

<td>

<?= !empty($row['alamat']) ? htmlspecialchars($row['alamat']) : '-'; ?>

</td>

<td class="text-center">

<?php if($row['role']=="admin"){ ?>

<span class="badge badge-admin">

<i class="fas fa-user-shield me-1"></i>

Admin

</span>

<?php }else{ ?>

<span class="badge badge-user">

<i class="fas fa-user me-1"></i>

User

</span>

<?php } ?>

</td>

<td class="text-center">

<?php if($row['id'] != $_SESSION['id']){ ?>

<a

href="hapus.php?id=<?= $row['id']; ?>"

class="btn btn-delete btn-sm"

onclick="return confirm('Yakin ingin menghapus pengguna ini?')">

<i class="fas fa-trash me-1"></i>

Hapus

</a>

<?php }else{ ?>

<button

class="btn btn-my btn-sm"

disabled>

<i class="fas fa-user-check me-1"></i>

Akun Saya

</button>

<?php } ?>

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

Kelola seluruh akun administrator dan pelanggan dengan mudah melalui
halaman manajemen pengguna. Dashboard ini dirancang untuk membantu
administrator menjaga keamanan dan integritas data pengguna RentGo
Black Gold Luxury.

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

document.querySelectorAll("tbody tr").forEach(function(row){

    row.addEventListener("mouseenter",function(){

        this.style.transform="scale(1.01)";
        this.style.transition=".25s";

    });

    row.addEventListener("mouseleave",function(){

        this.style.transform="scale(1)";

    });

});

/* ===========================
      CARD ANIMATION
=========================== */

document.querySelectorAll(".stat-card,.table-card").forEach(function(card){

    card.addEventListener("mouseenter",function(){

        this.style.transform="translateY(-6px)";
        this.style.transition=".3s";

    });

    card.addEventListener("mouseleave",function(){

        this.style.transform="translateY(0)";

    });

});

/* ===========================
      BUTTON EFFECT
=========================== */

document.querySelectorAll(".btn").forEach(function(btn){

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