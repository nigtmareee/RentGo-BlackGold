<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../../auth/login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        users.nama,
        mobil.nama_mobil
    FROM booking
    JOIN users
        ON booking.user_id = users.id
    JOIN mobil
        ON booking.mobil_id = mobil.id
    ORDER BY booking.id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Booking | RentGo Black Gold Luxury</title>

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
    border:none;
    font-weight:bold;

}

.btn-gold:hover{

    transform:translateY(-2px);

}

.btn-finish{

    background:#198754;
    color:white;
    border:none;

}

.btn-finish:hover{

    background:#157347;

}

.badge-premium{

    border-radius:30px;
    padding:8px 14px;
    font-size:13px;

}

.status-wait{

    background:#ffc107;
    color:black;

}

.status-rent{

    background:#0d6efd;

}

.status-done{

    background:#198754;

}

.status-cancel{

    background:#dc3545;

}

</style>

</head>
<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">

<i class="fas fa-calendar-check"></i>

Kelola Booking

</h2>

<p class="text-secondary mb-0">

Manajemen seluruh transaksi penyewaan kendaraan RentGo

</p>

</div>

<a href="../dashboard.php" class="btn btn-gold">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>
<th>User</th>
<th>Mobil</th>
<th>Periode Sewa</th>
<th>Hari</th>
<th>Total Harga</th>
<th>Status</th>
<th width="170">Aksi</th>

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

<strong><?= $row['nama']; ?></strong>

</td>

<td>

<?= $row['nama_mobil']; ?>

</td>

<td>

<?= $row['tanggal_mulai']; ?>

<br>

<small class="text-secondary">

s/d

<?= $row['tanggal_selesai']; ?>

</small>

</td>

<td class="text-center">

<?= $row['total_hari']; ?>

Hari

</td>

<td>

<strong>

Rp <?= number_format($row['total_harga'],0,',','.'); ?>

</strong>

</td>

<td>

<?php if($row['status']=="Menunggu Pembayaran"){ ?>

<span class="badge badge-premium status-wait">

Menunggu Pembayaran

</span>

<?php }elseif($row['status']=="Sedang Disewa"){ ?>

<span class="badge badge-premium status-rent">

Sedang Disewa

</span>

<?php }elseif($row['status']=="Selesai"){ ?>

<span class="badge badge-premium status-done">

Selesai

</span>

<?php }elseif($row['status']=="Dibatalkan"){ ?>

<span class="badge badge-premium status-cancel">

Dibatalkan

</span>

<?php } ?>

</td>

<td class="text-center">

<?php if($row['status']=="Sedang Disewa"){ ?>

<a href="proses_status.php?id=<?= $row['id']; ?>"

class="btn btn-finish btn-sm"

onclick="return confirm('Selesaikan penyewaan ini?')">

<i class="fas fa-check-circle"></i>

Selesaikan

</a>

<?php }elseif($row['status']=="Selesai"){ ?>

<button class="btn btn-secondary btn-sm" disabled>

<i class="fas fa-check"></i>

Selesai

</button>

<?php }else{ ?>

<button class="btn btn-dark btn-sm" disabled>

-

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