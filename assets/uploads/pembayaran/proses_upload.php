<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$booking_id = $_POST['booking_id'];

$nama_file = time() . "_" . $_FILES['bukti']['name'];

$tmp = $_FILES['bukti']['tmp_name'];

move_uploaded_file(
    $tmp,
    "../../assets/uploads/pembayaran/" . $nama_file
);

mysqli_query($conn, "
INSERT INTO pembayaran
(
    booking_id,
    bukti_transfer,
    status
)
VALUES
(
    '$booking_id',
    '$nama_file',
    'Menunggu Verifikasi'
)
");

header("Location: status.php");
exit;