<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query($conn, "SELECT * FROM mobil");
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Mobil | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{
    --gold:#d4af37;
    --dark:#050505;
    --card:#111111;
    --border:rgba(212,175,55,.18);
}

body{
    background:#050505;
    color:#fff;
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

    background:#1c1c1c;

}

.table thead th{

    color:#d4af37;
    border-color:#333;
    text-align:center;

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
    color:black;
    font-weight:bold;
    border:none;

}

.btn-gold:hover{

    transform:translateY(-2px);

}

.btn-edit{

    background:#ffc107;
    color:black;
    border:none;

}

.btn-delete{

    background:#dc3545;
    color:white;
    border:none;

}

.badge-premium{

    background:#d4af37;
    color:black;
    padding:7px 12px;
    border-radius:20px;

}

</style>

</head>

<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">

<i class="fas fa-car-side"></i>

Kelola Mobil

</h2>

<p class="text-secondary mb-0">

Manajemen armada RentGo Black Gold Luxury

</p>

</div>

<a href="tambah.php" class="btn btn-gold">

<i class="fas fa-plus-circle"></i>

Tambah Mobil

</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>
<th>Nama Mobil</th>
<th>Merk</th>
<th>Tahun</th>
<th>Plat Nomor</th>
<th>Transmisi</th>
<th>Harga / Hari</th>
<th width="170">Aksi</th>

</tr>

</thead>

<tbody>

<?php
$no=1;

while($row=mysqli_fetch_assoc($data)){
?>

<tr>

<td class="text-center">
<?= $no++ ?>
</td>

<td>

<strong>
<?= $row['nama_mobil'] ?>
</strong>

</td>

<td>

<?= $row['merk'] ?>

</td>

<td class="text-center">

<?= $row['tahun'] ?>

</td>

<td>

<span class="badge-premium">

<?= $row['plat_nomor'] ?>

</span>

</td>

<td class="text-center">

<?= $row['transmisi'] ?>

</td>

<td>

Rp <?= number_format($row['harga_per_hari'],0,',','.') ?>

</td>

<td class="text-center">

<a href="edit.php?id=<?= $row['id'] ?>"
class="btn btn-edit btn-sm">

<i class="fas fa-pen"></i>

Edit

</a>

<a href="hapus.php?id=<?= $row['id'] ?>"
class="btn btn-delete btn-sm"
onclick="return confirm('Yakin ingin menghapus data?')">

<i class="fas fa-trash"></i>

Hapus

</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>