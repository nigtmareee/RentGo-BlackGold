<?php

session_start();

require_once "../../config/koneksi.php";

/** @var mysqli $conn */

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    die("Silakan login terlebih dahulu.");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../mobil/index.php");
    exit;
}

$user_id = (int) $_SESSION['id'];

$mobil_id = isset($_POST['mobil_id']) ? (int) $_POST['mobil_id'] : 0;

$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');

$tanggal_mulai = $_POST['tanggal_mulai'] ?? '';
$tanggal_selesai = $_POST['tanggal_selesai'] ?? '';

/*
|--------------------------------------------------------------------------
| VALIDASI INPUT
|--------------------------------------------------------------------------
*/

if (
    $mobil_id <= 0 ||
    empty($no_hp) ||
    empty($alamat) ||
    empty($tanggal_mulai) ||
    empty($tanggal_selesai)
) {

    echo "<script>
        alert('Semua data booking wajib diisi.');
        history.back();
    </script>";
    exit;
}

/*
|--------------------------------------------------------------------------
| VALIDASI TANGGAL
|--------------------------------------------------------------------------
*/

$hari_ini = date('Y-m-d');

if ($tanggal_mulai < $hari_ini) {

    echo "<script>
        alert('Tanggal mulai tidak boleh sebelum hari ini.');
        history.back();
    </script>";
    exit;
}

$mulai = new DateTime($tanggal_mulai);
$selesai = new DateTime($tanggal_selesai);

$total_hari = $mulai->diff($selesai)->days;

if ($mulai >= $selesai) {

    echo "<script>
        alert('Tanggal selesai harus lebih besar dari tanggal mulai.');
        history.back();
    </script>";
    exit;
}

mysqli_begin_transaction($conn);

try {

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFIL USER
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE users
        SET no_hp=?, alamat=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $no_hp,
        $alamat,
        $user_id
    );

    mysqli_stmt_execute($stmt);

    /*
    |--------------------------------------------------------------------------
    | AMBIL DATA MOBIL
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT *
        FROM mobil
        WHERE id=?"
    );

    mysqli_stmt_bind_param($stmt, "i", $mobil_id);

    mysqli_stmt_execute($stmt);

    $mobil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$mobil) {
        throw new Exception("Mobil tidak ditemukan.");
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS MOBIL
    |--------------------------------------------------------------------------
    */

    if (trim($mobil['status']) != "Tersedia") {

        echo "<script>
            alert('Mobil sedang tidak tersedia.');
            window.location='../mobil/index.php';
        </script>";

        mysqli_rollback($conn);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | CEK DOUBLE BOOKING
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "SELECT id
        FROM booking
        WHERE mobil_id=?
        AND status IN ('Menunggu Pembayaran','Sedang Disewa')
        AND (
            tanggal_mulai <= ?
            AND tanggal_selesai >= ?
        )"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "iss",
        $mobil_id,
        $tanggal_selesai,
        $tanggal_mulai
    );

    mysqli_stmt_execute($stmt);

    $cekBooking = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($cekBooking) > 0) {

        echo "<script>
            alert('Mobil sudah dibooking pada rentang tanggal tersebut.');
            history.back();
        </script>";

        mysqli_rollback($conn);
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG BIAYA
    |--------------------------------------------------------------------------
    */

    $total_harga = $total_hari * $mobil['harga_per_hari'];

    $diskon = 0;

    if ($total_hari >= 3) {
        $diskon = $total_harga * 0.10;
    }

    $total_bayar = $total_harga - $diskon;

    /*
    |--------------------------------------------------------------------------
    | SIMPAN BOOKING
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO booking
        (
            user_id,
            mobil_id,
            tanggal_mulai,
            tanggal_selesai,
            total_hari,
            total_harga,
            diskon,
            status
        )
        VALUES
        (
            ?,?,?,?,?,?,?,?
        )"
    );

    $status = "Menunggu Pembayaran";

    mysqli_stmt_bind_param(
        $stmt,
        "iissidds",
        $user_id,
        $mobil_id,
        $tanggal_mulai,
        $tanggal_selesai,
        $total_hari,
        $total_bayar,
        $diskon,
        $status
    );

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($conn));
    }

    /*
    |--------------------------------------------------------------------------
    | PENTING
    |--------------------------------------------------------------------------
    | Status mobil TIDAK berubah di sini.
    | Mobil tetap "Tersedia" sampai pembayaran
    | diverifikasi oleh Admin.
    |--------------------------------------------------------------------------
    */

    mysqli_commit($conn);

    echo "<script>

        alert(
            'Booking berhasil dibuat!\\n\\n' +
            'Status : Menunggu Pembayaran\\n' +
            'Silakan upload bukti pembayaran.'
        );

        window.location='riwayat.php';

    </script>";

} catch (Exception $e) {

    mysqli_rollback($conn);

    echo "<script>
        alert('Terjadi kesalahan : " . addslashes($e->getMessage()) . "');
        history.back();
    </script>";
}

exit;