<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query($conn, "SELECT * FROM mobil");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Mobil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h2>Kelola Mobil</h2>

<a href="tambah.php" class="btn btn-primary mb-3">
    Tambah Mobil
</a>

<table class="table table-bordered table-striped">

<thead>
<tr>
    <th>No</th>
    <th>Nama Mobil</th>
    <th>Merk</th>
    <th>Tahun</th>
    <th>Plat Nomor</th>
    <th>Transmisi</th>
    <th>Harga/Hari</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;

while($row = mysqli_fetch_assoc($data)){
?>

<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['nama_mobil'] ?></td>
    <td><?= $row['merk'] ?></td>
    <td><?= $row['tahun'] ?></td>
    <td><?= $row['plat_nomor'] ?></td>
    <td><?= $row['transmisi'] ?></td>
    <td>Rp <?= number_format($row['harga_per_hari']) ?></td>

    <td>
        <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
            Edit
        </a>

        <a href="hapus.php?id=<?= $row['id'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Yakin ingin menghapus data?')">
            Hapus
        </a>
    </td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>
</html>