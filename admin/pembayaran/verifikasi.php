<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$aksi = $_GET['aksi'] ?? '';

if ($id <= 0 || !in_array($aksi, ['terima', 'tolak'])) {
    die("Permintaan tidak valid.");
}

mysqli_begin_transaction($conn);

try {

    /*
    |--------------------------------------------------------------------------
    | Ambil Data Pembayaran
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT *
        FROM pembayaran
        WHERE id=?"
    );

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $pembayaran = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$pembayaran) {
        throw new Exception("Data pembayaran tidak ditemukan.");
    }

    /*
    |--------------------------------------------------------------------------
    | Cegah Verifikasi Berulang
    |--------------------------------------------------------------------------
    */

    if (
        $pembayaran['status'] == 'Diterima' ||
        $pembayaran['status'] == 'Ditolak'
    ) {
        throw new Exception("Pembayaran sudah diverifikasi.");
    }

    $booking_id = (int)$pembayaran['booking_id'];

    /*
    |--------------------------------------------------------------------------
    | Ambil Data Booking
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT *
        FROM booking
        WHERE id=?"
    );

    mysqli_stmt_bind_param($stmt, "i", $booking_id);

    mysqli_stmt_execute($stmt);

    $booking = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$booking) {
        throw new Exception("Booking tidak ditemukan.");
    }

    $mobil_id = (int)$booking['mobil_id'];

    /*
    |--------------------------------------------------------------------------
    | TERIMA PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    if ($aksi == "terima") {

        $statusPembayaran = "Diterima";
        $statusBooking = "Sedang Disewa";
        $statusMobil = "Disewa";

    } else {

        /*
        |--------------------------------------------------------------------------
        | TOLAK PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $statusPembayaran = "Ditolak";
        $statusBooking = "Ditolak";
        $statusMobil = "Tersedia";
    }

    /*
    |--------------------------------------------------------------------------
    | Update Pembayaran
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE pembayaran
        SET status=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $statusPembayaran,
        $id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Booking
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE booking
        SET status=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $statusBooking,
        $booking_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    /*
    |--------------------------------------------------------------------------
    | Update Mobil
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE mobil
        SET status=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $statusMobil,
        $mobil_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    mysqli_commit($conn);

    header("Location: index.php?success=1");
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);

    echo "<script>

    alert('".$e->getMessage()."');

    window.location='index.php';

    </script>";

    exit;
}