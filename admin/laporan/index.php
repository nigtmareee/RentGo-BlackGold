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

$tanggal_awal = $_GET['tanggal_awal'] ?? '';
$tanggal_akhir = $_GET['tanggal_akhir'] ?? '';

$where = "";

if (
    !empty($tanggal_awal) &&
    !empty($tanggal_akhir)
) {

    $where =
        "WHERE booking.tanggal_mulai
        BETWEEN '$tanggal_awal'
        AND '$tanggal_akhir'";
}

$query = "
SELECT
    booking.*,
    users.nama,
    mobil.nama_mobil
FROM booking
JOIN users
    ON booking.user_id = users.id
JOIN mobil
    ON booking.mobil_id = mobil.id
$where
ORDER BY booking.id DESC
";

$data = mysqli_query($conn, $query);

$queryTotal = "
SELECT SUM(total_harga) AS total
FROM booking
$where
";

$totalData =
    mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            $queryTotal
        )
    );

$totalPendapatan =
    $totalData['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Laporan Rental | RentGo Black Gold Luxury</title>

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

.form-label{

    color:#ddd;
    font-weight:600;

}

.form-control{

    background:#181818;
    color:#fff;
    border:1px solid #333;

}

.form-control:focus{

    background:#202020;
    color:#fff;
    border-color:var(--gold);
    box-shadow:0 0 12px rgba(212,175,55,.25);

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

.info-card{

    background:#1b1b1b;
    border-left:5px solid var(--gold);
    border-radius:15px;
    padding:18px;
    margin:25px 0;

}

.badge-status{

    border-radius:20px;
    padding:8px 14px;
    font-size:13px;

}

.status-menunggu{

    background:#ffc107;
    color:black;

}

.status-disewa{

    background:#0d6efd;

}

.status-selesai{

    background:#198754;

}

.status-batal{

    background:#dc3545;

}

@media print{

    .btn,
    form{

        display:none;

    }

    body{

        background:white;
        color:black;

    }

    .card-premium{

        box-shadow:none;
        border:none;

    }

}

</style>

</head>
<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">

<i class="fas fa-chart-line"></i>

Laporan Rental

</h2>

<p class="text-secondary mb-0">

Laporan transaksi penyewaan kendaraan RentGo Black Gold Luxury

</p>

</div>

<a href="../dashboard.php" class="btn btn-gold">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<form method="GET">

<div class="row g-3 align-items-end">

<div class="col-md-4">

<label class="form-label">

Tanggal Awal

</label>

<input
type="date"
name="tanggal_awal"
class="form-control"
value="<?= $tanggal_awal ?>">

</div>

<div class="col-md-4">

<label class="form-label">

Tanggal Akhir

</label>

<input
type="date"
name="tanggal_akhir"
class="form-control"
value="<?= $tanggal_akhir ?>">

</div>

<div class="col-md-4">

<button
type="submit"
class="btn btn-gold w-100">

<i class="fas fa-filter"></i>

Filter Data

</button>

</div>

</div>

</form>

<div class="info-card">

<i class="fas fa-wallet text-warning"></i>

<strong>

Total Pendapatan

</strong>

<h3 class="text-warning mt-2">

Rp <?= number_format($totalPendapatan,0,',','.'); ?>

</h3>

</div>

<div class="mb-4">

<button
onclick="window.print()"
class="btn btn-danger">

<i class="fas fa-print"></i>

Cetak Laporan

</button>

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>
<th>Penyewa</th>
<th>Mobil</th>
<th>Periode</th>
<th>Hari</th>
<th>Total</th>
<th>Status</th>

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

<?php

if($row['status']=="Menunggu Pembayaran"){

echo '<span class="badge badge-status status-menunggu">Menunggu</span>';

}elseif($row['status']=="Sedang Disewa"){

echo '<span class="badge badge-status status-disewa">Sedang Disewa</span>';

}elseif($row['status']=="Selesai"){

echo '<span class="badge badge-status status-selesai">Selesai</span>';

}else{

echo '<span class="badge badge-status status-batal">Dibatalkan</span>';

}

?>

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