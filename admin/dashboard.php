<?php
session_start();

if (!isset($_SESSION['id'])) { header("Location: ../auth/login.php"); exit; }
if ($_SESSION['role'] != 'admin') { header("Location: ../index.php"); exit; }

require_once '../config/koneksi.php';

/** @var mysqli $conn */

$totalMobil = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM mobil"));
$totalUser = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users WHERE role='user'"));
$totalBooking = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM booking"));

$mobilDisewa = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM mobil WHERE status='Disewa'"));
$verifikasi = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pembayaran WHERE status='Menunggu Verifikasi'"));

$qPendapatan = mysqli_query($conn,"SELECT SUM(total_harga) AS total FROM booking WHERE status='Selesai'");
$pendapatan = mysqli_fetch_assoc($qPendapatan);
$totalPendapatan = $pendapatan['total'] ?? 0;

$bulan=[]; $pendapatanBulanan=[];
$grafik = mysqli_query($conn,"SELECT MONTH(tanggal_mulai) AS bulan,SUM(total_harga) AS total FROM booking WHERE status='Selesai' GROUP BY MONTH(tanggal_mulai) ORDER BY MONTH(tanggal_mulai)");
$namaBulan=[1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'];
while($row=mysqli_fetch_assoc($grafik)){ $bulan[]=$namaBulan[$row['bulan']]; $pendapatanBulanan[]=$row['total']; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RentGo Executive Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
:root{--gold:#d4af37;--dark:#050505;--card:#111;}
body{background:var(--dark);color:#fff;font-family:Segoe UI,sans-serif}
.header-box{background:linear-gradient(135deg,#111,#1b1b1b);border:1px solid rgba(212,175,55,.2);border-radius:25px;padding:35px;margin-bottom:25px}
.gold{color:var(--gold)}
.card-lux{background:var(--card);border:1px solid rgba(212,175,55,.15);border-radius:22px;color:#fff;height:100%}
.card-lux .num{font-size:38px;font-weight:800;color:var(--gold)}
.menu-card{background:var(--card);border:1px solid rgba(212,175,55,.15);border-radius:22px;transition:.3s;height:100%}
.menu-card:hover{transform:translateY(-8px);border-color:var(--gold)}
.menu-card .card-body{padding:35px;text-align:center}
.menu-card i{font-size:48px;color:var(--gold);margin-bottom:15px}
.table-darkgold{background:var(--card)}
</style>
</head>
<body>
<div class="container py-4">
<div class="header-box">
<h2 class="gold">RentGo Executive Dashboard</h2>
<p>Selamat datang, <?= htmlspecialchars($_SESSION['nama']); ?></p>
</div>

<div class="row g-4">
<div class="col-md-3"><div class="card card-lux"><div class="card-body text-center"><i class="fas fa-car text-warning"></i><div class="num"><?= $totalMobil ?></div><div>Total Mobil</div></div></div></div>
<div class="col-md-3"><div class="card card-lux"><div class="card-body text-center"><i class="fas fa-users text-warning"></i><div class="num"><?= $totalUser ?></div><div>Total User</div></div></div></div>
<div class="col-md-3"><div class="card card-lux"><div class="card-body text-center"><i class="fas fa-calendar-check text-warning"></i><div class="num"><?= $totalBooking ?></div><div>Total Booking</div></div></div></div>
<div class="col-md-3"><div class="card card-lux"><div class="card-body text-center"><i class="fas fa-money-bill-wave text-warning"></i><div class="num">Rp <?= number_format($totalPendapatan,0,',','.') ?></div><div>Pendapatan</div></div></div></div>
</div>

<div class="row g-4 mt-1">
<div class="col-md-6"><div class="card card-lux"><div class="card-body text-center"><h5>🚗 Mobil Sedang Disewa</h5><div class="num"><?= $mobilDisewa ?></div></div></div></div>
<div class="col-md-6"><div class="card card-lux"><div class="card-body text-center"><h5>💳 Menunggu Verifikasi</h5><div class="num"><?= $verifikasi ?></div></div></div></div>
</div>

<div class="card card-lux mt-4">
<div class="card-body">
<h4 class="gold mb-4">📈 Grafik Pendapatan Bulanan</h4>
<canvas id="grafikPendapatan"></canvas>
</div>
</div>

<h4 class="mt-5 mb-4">Menu Admin</h4>
<div class="row">
<div class="col-lg-3 col-md-6 mb-4"><a href="mobil/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-car"></i><h5 class="text-white">Kelola Mobil</h5></div></div></a></div>
<div class="col-lg-3 col-md-6 mb-4"><a href="booking/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-calendar-check"></i><h5 class="text-white">Kelola Booking</h5></div></div></a></div>
<div class="col-lg-3 col-md-6 mb-4"><a href="pembayaran/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-money-check-dollar"></i><h5 class="text-white">Verifikasi Pembayaran</h5></div></div></a></div>
<div class="col-lg-3 col-md-6 mb-4"><a href="pengguna/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-users"></i><h5 class="text-white">Kelola Pengguna</h5></div></div></a></div>
<div class="col-lg-3 col-md-6 mb-4"><a href="laporan/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-chart-line"></i><h5 class="text-white">Laporan Rental</h5></div></div></a></div>
<div class="col-lg-3 col-md-6 mb-4"><a href="review/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-star"></i><h5 class="text-white">Review Pelanggan</h5></div></div></a></div>
<div class="col-lg-3 col-md-6 mb-4"><a href="profile/index.php" class="text-decoration-none"><div class="menu-card"><div class="card-body"><i class="fas fa-user-shield"></i><h5 class="text-white">Profil Admin</h5></div></div></a></div>
</div>

<a href="../auth/logout.php" class="btn btn-warning btn-lg">Logout</a>
</div>

<script>
new Chart(document.getElementById('grafikPendapatan'),{
type:'bar',
data:{labels:<?= json_encode($bulan); ?>,datasets:[{label:'Pendapatan Rental',data:<?= json_encode($pendapatanBulanan); ?>,backgroundColor:'#d4af37'}]},
options:{responsive:true,plugins:{legend:{labels:{color:'#d4af37'}}},scales:{y:{ticks:{color:'#fff'}},x:{ticks:{color:'#fff'}}}}
});
</script>
</body></html>