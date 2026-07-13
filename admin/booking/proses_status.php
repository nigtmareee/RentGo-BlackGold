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

$id = (int)$_GET['id'];

/*
|--------------------------------------------------------------------------
| Ambil data booking
|--------------------------------------------------------------------------
*/

$query = mysqli_query(
    $conn,
    "SELECT * FROM booking WHERE id='$id'"
);

$booking = mysqli_fetch_assoc($query);

if (!$booking) {
    die("Booking tidak ditemukan");
}

/*
|--------------------------------------------------------------------------
| Jika status sedang disewa
|--------------------------------------------------------------------------
*/

if ($booking['status'] == 'Sedang Disewa') {

    $mobil_id = $booking['mobil_id'];

    /*
    |--------------------------------------------------------------------------
    | Update booking menjadi selesai
    |--------------------------------------------------------------------------
    */

    mysqli_query(
        $conn,
        "UPDATE booking
        SET status='Selesai'
        WHERE id='$id'"
    );

    /*
    |--------------------------------------------------------------------------
    | Update mobil menjadi tersedia
    |--------------------------------------------------------------------------
    */

    mysqli_query(
        $conn,
        "UPDATE mobil
        SET status='Tersedia'
        WHERE id='$mobil_id'"
    );
}

header("Location: index.php");
exit;