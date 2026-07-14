<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: ../../index.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    die("ID booking tidak valid.");
}

mysqli_begin_transaction($conn);

try {

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

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $booking = mysqli_fetch_assoc(
        mysqli_stmt_get_result($stmt)
    );

    if (!$booking) {
        throw new Exception("Booking tidak ditemukan.");
    }

    /*
    |--------------------------------------------------------------------------
    | Validasi Status
    |--------------------------------------------------------------------------
    */

    if ($booking['status'] != 'Sedang Disewa') {
        throw new Exception(
            "Booking tidak dapat diselesaikan karena status saat ini adalah '" .
            $booking['status'] .
            "'."
        );
    }

    $mobil_id = (int)$booking['mobil_id'];

    /*
    |--------------------------------------------------------------------------
    | Update Booking
    |--------------------------------------------------------------------------
    */

    $statusBooking = "Selesai";

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
        $id
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(
            mysqli_error($conn)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Mobil
    |--------------------------------------------------------------------------
    */

    $statusMobil = "Tersedia";

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
        throw new Exception(
            mysqli_error($conn)
        );
    }

    mysqli_commit($conn);

    header("Location: index.php?success=selesai");
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);

    echo "<script>

    alert('" . addslashes($e->getMessage()) . "');

    window.location='index.php';

    </script>";

    exit;
}