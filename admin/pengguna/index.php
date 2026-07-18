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
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Pengguna | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

    --gold:#d4af37;
    --gold2:#f1c75b;
    --dark:#050505;
    --card:#111111;
    --border:rgba(212,175,55,.18);

}

body{

    background:#050505;
    color:white;
    font-family:'Segoe UI',sans-serif;

}

.card-premium{

    background:#111;
    border:1px solid var(--border);
    border-radius:22px;
    box-shadow:0 15px 35px rgba(0,0,0,.45);
    padding:30px;

}

.page-title{

    color:var(--gold);
    font-weight:bold;

}

.table{

    color:white;
    margin-bottom:0;

}

.table thead{

    background:#1d1d1d;

}

.table thead th{

    color:#d4af37;
    border-color:#333;
    text-align:center;
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

.btn-gold{

    background:linear-gradient(135deg,#d4af37,#f1c75b);
    color:#000;
    font-weight:bold;
    border:none;

}

.btn-gold:hover{

    transform:translateY(-2px);

}

.info-card{

    background:#1b1b1b;
    border-left:5px solid var(--gold);
    border-radius:15px;
    padding:18px;
    margin-bottom:25px;

}

.badge-admin{

    background:#dc3545;
    padding:8px 15px;
    border-radius:20px;

}

.badge-user{

    background:#0d6efd;
    padding:8px 15px;
    border-radius:20px;

}

.btn-delete{

    background:#dc3545;
    color:white;
    border:none;

}

.btn-delete:hover{

    background:#bb2d3b;

}

.btn-my{

    background:#6c757d;
    color:white;

}

</style>

</head>
<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">

<i class="fas fa-users-cog"></i>

Kelola Pengguna

</h2>

<p class="text-secondary mb-0">

Manajemen seluruh akun pengguna RentGo Black Gold Luxury

</p>

</div>

<a href="../dashboard.php" class="btn btn-gold">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<div class="info-card">

<i class="fas fa-user-friends text-warning"></i>

Total Pengguna

<strong class="text-warning fs-5">

<?= $totalPengguna ?>

</strong>

Akun

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

<th width="160">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=mysqli_fetch_assoc($data)):

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

<i class="fas fa-user-shield"></i>

Admin

</span>

<?php }else{ ?>

<span class="badge badge-user">

<i class="fas fa-user"></i>

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

<i class="fas fa-trash"></i>

Hapus

</a>

<?php }else{ ?>

<button

class="btn btn-my btn-sm"

disabled>

<i class="fas fa-user-check"></i>

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

</body>
</html>