<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$user_id = $_SESSION['id'];

$booking_id = (int)$_POST['booking_id'];
$mobil_id = (int)$_POST['mobil_id'];
$rating = (int)$_POST['rating'];

$komentar = mysqli_real_escape_string(
    $conn,
    $_POST['komentar']
);

$cek = mysqli_query(
    $conn,
    "SELECT *
    FROM review
    WHERE booking_id='$booking_id'"
);

if (mysqli_num_rows($cek) > 0) {

    echo "
    <script>
        alert('Review sudah pernah diberikan.');
        window.location='../booking/riwayat.php';
    </script>
    ";

    exit;
}

$simpan = mysqli_query(
    $conn,
    "INSERT INTO review
    (
        booking_id,
        user_id,
        mobil_id,
        rating,
        komentar
    )
    VALUES
    (
        '$booking_id',
        '$user_id',
        '$mobil_id',
        '$rating',
        '$komentar'
    )"
);

if (!$simpan) {
    die(mysqli_error($conn));
}

echo "
<script>
    alert('Terima kasih, review berhasil dikirim.');
    window.location='../booking/riwayat.php';
</script>
";