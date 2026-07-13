<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = (int) $_GET['id'];

$aksi = $_GET['aksi'];

$data = mysqli_query(
    $conn,
    "SELECT * FROM pembayaran WHERE id='$id'"
);

$pembayaran = mysqli_fetch_assoc($data);

if(!$pembayaran){
    die("Data pembayaran tidak ditemukan.");
}

$booking_id = $pembayaran['booking_id'];

if($aksi == 'terima'){

    mysqli_query(
        $conn,
        "UPDATE pembayaran
        SET status='Diterima'
        WHERE id='$id'"
    );

    mysqli_query(
        $conn,
        "UPDATE booking
        SET status='Sedang Disewa'
        WHERE id='$booking_id'"
    );

    $booking = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT mobil_id
             FROM booking
             WHERE id='$booking_id'"
        )
    );

    mysqli_query(
        $conn,
        "UPDATE mobil
         SET status='Disewa'
         WHERE id='".$booking['mobil_id']."'"
    );

}

if($aksi == 'tolak'){

    mysqli_query(
        $conn,
        "UPDATE pembayaran
        SET status='Ditolak'
        WHERE id='$id'"
    );

    mysqli_query(
        $conn,
        "UPDATE booking
        SET status='Ditolak'
        WHERE id='$booking_id'"
    );

    $booking = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "SELECT mobil_id
             FROM booking
             WHERE id='$booking_id'"
        )
    );

    mysqli_query(
        $conn,
        "UPDATE mobil
         SET status='Tersedia'
         WHERE id='".$booking['mobil_id']."'"
    );

}

header("Location: index.php");
exit;