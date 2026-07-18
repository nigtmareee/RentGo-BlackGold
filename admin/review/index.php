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
    "SELECT
        review.*,
        users.nama,
        mobil.nama_mobil
    FROM review
    JOIN users
        ON review.user_id = users.id
    JOIN mobil
        ON review.mobil_id = mobil.id
    ORDER BY review.id DESC"
);

$totalReview = mysqli_num_rows($data);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola Review | RentGo Black Gold Luxury</title>

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

.btn-delete{

    background:#dc3545;
    color:white;
    border:none;

}

.btn-delete:hover{

    background:#bb2d3b;

}

.rating{

    color:#FFD700;
    font-size:18px;
    letter-spacing:2px;

}

.comment{

    max-width:350px;
    white-space:normal;

}

</style>

</head>
<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">

<i class="fas fa-star"></i>

Kelola Review Pelanggan

</h2>

<p class="text-secondary mb-0">

Kelola seluruh ulasan pelanggan RentGo Black Gold Luxury

</p>

</div>

<a href="../dashboard.php" class="btn btn-gold">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<div class="info-card">

<i class="fas fa-comments text-warning"></i>

Total Review

<strong class="text-warning fs-5">

<?= $totalReview ?>

</strong>

Review

</div>

<div class="table-responsive">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>No</th>
<th>User</th>
<th>Mobil</th>
<th>Rating</th>
<th>Komentar</th>
<th>Tanggal</th>
<th width="120">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

mysqli_data_seek($data,0);

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

<?= htmlspecialchars($row['nama_mobil']); ?>

</td>

<td class="rating">

<?php

for($i=1;$i<=$row['rating'];$i++){

echo '<i class="fas fa-star"></i>';

}

?>

</td>

<td class="comment">

<?= nl2br(htmlspecialchars($row['komentar'])); ?>

</td>

<td>

<?= $row['created_at']; ?>

</td>

<td class="text-center">

<a
href="hapus.php?id=<?= $row['id']; ?>"
class="btn btn-delete btn-sm"
onclick="return confirm('Hapus review ini?')">

<i class="fas fa-trash"></i>

Hapus

</a>

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