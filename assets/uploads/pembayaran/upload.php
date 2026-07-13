<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id_booking = $_GET['id'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Bukti Pembayaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

<h2>Upload Bukti Pembayaran</h2>

<form action="proses_upload.php" method="POST" enctype="multipart/form-data">

    <input type="hidden"
           name="booking_id"
           value="<?= $id_booking ?>">

    <div class="mb-3">
        <label>Bukti Transfer</label>

        <input type="file"
               name="bukti"
               class="form-control"
               required>
    </div>

    <button class="btn btn-success">
        Upload
    </button>

</form>

</div>

</body>
</html>