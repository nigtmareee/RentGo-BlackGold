<?php

session_start();

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../booking/riwayat.php");
    exit;
}

$user_id = (int)$_SESSION['id'];

$booking_id = isset($_POST['booking_id']) ? (int)$_POST['booking_id'] : 0;
$metode    = trim($_POST['metode'] ?? '');
$jumlah    = (float)($_POST['jumlah'] ?? 0);

if (
    $booking_id <= 0 ||
    empty($metode) ||
    $jumlah <= 0
) {
    die("Data pembayaran tidak lengkap.");
}

/*
|--------------------------------------------------------------------------
| Cek Booking
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,
    "SELECT id,status
    FROM booking
    WHERE id=?
    AND user_id=?"
);

mysqli_stmt_bind_param(
    $stmt,
    "ii",
    $booking_id,
    $user_id
);

mysqli_stmt_execute($stmt);

$booking = mysqli_fetch_assoc(
    mysqli_stmt_get_result($stmt)
);

if (!$booking) {
    die("Booking tidak ditemukan.");
}

/*
|--------------------------------------------------------------------------
| Booking sudah dibayar?
|--------------------------------------------------------------------------
*/

if (
    $booking['status'] != 'Menunggu Pembayaran'
) {

    echo "
    <script>
    alert('Booking ini sudah diproses.');
    history.back();
    </script>
    ";

    exit;
}

/*
|--------------------------------------------------------------------------
| Validasi Upload
|--------------------------------------------------------------------------
*/

if (
    !isset($_FILES['bukti']) ||
    $_FILES['bukti']['error'] != UPLOAD_ERR_OK
) {
    die("Bukti pembayaran belum dipilih.");
}

$file = $_FILES['bukti'];

$maxSize = 2 * 1024 * 1024;

if ($file['size'] > $maxSize) {

    die("Ukuran file maksimal 2 MB.");
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);

$mime = finfo_file(
    $finfo,
    $file['tmp_name']
);

finfo_close($finfo);

$allowedMime = [

    'image/jpeg' => 'jpg',

    'image/png' => 'png',

    'application/pdf' => 'pdf'

];

if (!array_key_exists($mime, $allowedMime)) {

    die("Format file tidak didukung.");
}

$folder = "../../assets/uploads/pembayaran/";

if (!is_dir($folder)) {

    mkdir($folder, 0777, true);
}

$namaFile = sprintf(
    "PAY-%d-%s.%s",
    $booking_id,
    uniqid(),
    $allowedMime[$mime]
);

$lokasiFile = $folder . $namaFile;

if (!move_uploaded_file(
    $file['tmp_name'],
    $lokasiFile
)) {

    die("Upload gagal.");
}

/*
|--------------------------------------------------------------------------
| Transaction
|--------------------------------------------------------------------------
*/

mysqli_begin_transaction($conn);

try {

    /*
    |--------------------------------------------------------------------------
    | Simpan Pembayaran
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO pembayaran
        (
            booking_id,
            metode_pembayaran,
            bukti_transfer,
            jumlah_bayar,
            status
        )
        VALUES
        (
            ?,?,?,?,
            'Menunggu Verifikasi'
        )"
    );

    mysqli_stmt_bind_param(

        $stmt,

        "issd",

        $booking_id,

        $metode,

        $namaFile,

        $jumlah

    );

    if (!mysqli_stmt_execute($stmt)) {

        throw new Exception(
            mysqli_error($conn)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update Booking
    |--------------------------------------------------------------------------
    */

    $stmt = mysqli_prepare(

        $conn,

        "UPDATE booking
        SET status='Menunggu Verifikasi'
        WHERE id=?"

    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $booking_id
    );

    if (!mysqli_stmt_execute($stmt)) {

        throw new Exception(
            mysqli_error($conn)
        );
    }

    mysqli_commit($conn);

    echo "
    <script>

    alert('Bukti pembayaran berhasil diupload.');

    window.location='../booking/riwayat.php';

    </script>
    ";

} catch (Exception $e) {

    mysqli_rollback($conn);

    if (file_exists($lokasiFile)) {

        unlink($lokasiFile);
    }

    echo "
    <script>

    alert('".$e->getMessage()."');

    history.back();

    </script>
    ";
}

exit;