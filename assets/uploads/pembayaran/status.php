<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query($conn,"
SELECT *
FROM pembayaran
ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html>
<head>
<title>Status Pembayaran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Status Pembayaran</h2>

<table class="table table-bordered">

<tr>
    <th>ID</th>
    <th>Bukti</th>
    <th>Status</th>
</tr>

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<tr>

<td><?= $row['id'] ?></td>

<td>
<a target="_blank"
href="../../assets/uploads/pembayaran/<?= $row['bukti_transfer'] ?>">
Lihat Bukti
</a>
</td>

<td><?= $row['status'] ?></td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>