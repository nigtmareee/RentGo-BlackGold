<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT
        pembayaran.*,
        mobil.nama_mobil,
        users.nama
    FROM pembayaran
    JOIN booking
        ON pembayaran.booking_id = booking.id
    JOIN mobil
        ON booking.mobil_id = mobil.id
    JOIN users
        ON booking.user_id = users.id
    ORDER BY pembayaran.id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Verifikasi Pembayaran | RentGo Black Gold Luxury</title>

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
    padding:30px;
    box-shadow:0 15px 35px rgba(0,0,0,.45);

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
    font-weight:bold;
    border:none;

}

.btn-gold:hover{

    transform:translateY(-2px);

}

.btn-proof{

    background:#0d6efd;
    color:white;
    border:none;

}

.btn-proof:hover{

    background:#0b5ed7;
    color:white;

}

.btn-success{

    font-weight:bold;

}

.btn-danger{

    font-weight:bold;

}

.badge-premium{

    padding:8px 14px;
    border-radius:25px;

}

.status-wait{

    background:#ffc107;
    color:black;

}

.status-success{

    background:#198754;

}

.status-danger{

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

<i class="fas fa-money-check-dollar"></i>

Verifikasi Pembayaran

</h2>

<p class="text-secondary mb-0">

Kelola seluruh pembayaran pelanggan RentGo Black Gold Luxury

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
<th>Metode</th>
<th>Jumlah</th>
<th>Bukti Transfer</th>
<th>Status</th>
<th width="180">Aksi</th>

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

<?= $row['nama']; ?>

</strong>

</td>

<td>

<?= $row['nama_mobil']; ?>

</td>

<td>

<?= $row['metode_pembayaran']; ?>

</td>

<td>

<strong>

Rp <?= number_format($row['jumlah_bayar'],0,',','.'); ?>

</strong>

</td>

<td>

<a
href="/rentgo/assets/uploads/pembayaran/<?= $row['bukti_transfer']; ?>"
target="_blank"
class="btn btn-proof btn-sm">

<i class="fas fa-eye"></i>

Lihat Bukti

</a>

</td>

<td>

<?php if($row['status']=="Menunggu Verifikasi"){ ?>

<span class="badge badge-premium status-wait">

Menunggu

</span>

<?php }elseif($row['status']=="Diterima"){ ?>

<span class="badge badge-premium status-success">

Diterima

</span>

<?php }else{ ?>

<span class="badge badge-premium status-danger">

Ditolak

</span>

<?php } ?>

</td>

<td class="text-center">

<?php if($row['status']=="Menunggu Verifikasi"){ ?>

<a
href="verifikasi.php?id=<?= $row['id']; ?>&aksi=terima"
class="btn btn-success btn-sm">

<i class="fas fa-check"></i>

Terima

</a>

<a
href="verifikasi.php?id=<?= $row['id']; ?>&aksi=tolak"
class="btn btn-danger btn-sm">

<i class="fas fa-times"></i>

Tolak

</a>

<?php }else{ ?>

<button
class="btn btn-secondary btn-sm"
disabled>

Selesai

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