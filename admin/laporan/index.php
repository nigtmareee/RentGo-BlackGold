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

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Laporan Rental</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>
<body>

<div class="container mt-4">

<h2>Laporan Rental Mobil</h2>

<hr>

<a
href="../dashboard.php"
class="btn btn-secondary mb-3"
>
Kembali Dashboard
</a>

<form method="GET">

<div class="row">

<div class="col-md-4">

<label>Tanggal Awal</label>

<input
type="date"
name="tanggal_awal"
class="form-control"
value="<?= $tanggal_awal ?>"
>

</div>

<div class="col-md-4">

<label>Tanggal Akhir</label>

<input
type="date"
name="tanggal_akhir"
class="form-control"
value="<?= $tanggal_akhir ?>"
>

</div>

<div class="col-md-4">

<label>&nbsp;</label>

<button
type="submit"
class="btn btn-primary w-100"
>
Filter Data
</button>

</div>

</div>

</form>

<div class="alert alert-success mt-4">

Total Pendapatan :

<strong>

Rp <?= number_format(
$totalPendapatan,
0,
',',
'.'
); ?>

</strong>

</div>

<div class="mb-3">

<button
onclick="window.print()"
class="btn btn-danger"
>
Cetak Laporan
</button>

</div>

<table
class="table table-bordered table-striped"
>

<tr>

<th>No</th>
<th>Penyewa</th>
<th>Mobil</th>
<th>Tanggal</th>
<th>Hari</th>
<th>Total</th>
<th>Status</th>

</tr>

<?php

$no = 1;

while(
$row = mysqli_fetch_assoc($data)
):

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama']; ?></td>

<td><?= $row['nama_mobil']; ?></td>

<td>

<?= $row['tanggal_mulai']; ?>

s/d

<?= $row['tanggal_selesai']; ?>

</td>

<td>

<?= $row['total_hari']; ?>

Hari

</td>

<td>

Rp <?= number_format(
$row['total_harga'],
0,
',',
'.'
); ?>

</td>

<td>

<?= $row['status']; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>