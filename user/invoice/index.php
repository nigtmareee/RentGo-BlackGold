<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = isset($_GET['id'])
    ? (int) $_GET['id']
    : 0;

$query = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        users.nama,
        users.email,
        users.no_hp,
        users.alamat,
        mobil.nama_mobil,
        mobil.harga_per_hari
    FROM booking
    JOIN users
        ON booking.user_id = users.id
    JOIN mobil
        ON booking.mobil_id = mobil.id
    WHERE booking.id='$id'"
);

$invoice = mysqli_fetch_assoc($query);

if (!$invoice) {
    die("Invoice tidak ditemukan.");
}

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>Invoice Rental</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

.invoice-box{
    max-width:900px;
    margin:auto;
}

</style>

</head>
<body>

<div class="container mt-5">

    <div class="invoice-box card shadow">

        <div class="card-body">

            <div class="text-center">

                <h2>RENTGO RENTAL MOBIL</h2>

                <p>
                    Bukti Transaksi Penyewaan Mobil
                </p>

            </div>

            <hr>

            <h4>

                Invoice #

                INV-<?= str_pad(
                    $invoice['id'],
                    5,
                    "0",
                    STR_PAD_LEFT
                ); ?>

            </h4>

            <table class="table table-bordered">

                <tr>
                    <th width="250">
                        Nama Penyewa
                    </th>

                    <td>
                        <?= e($invoice['nama']); ?>
                    </td>
                </tr>

                <tr>
                    <th>Email</th>

                    <td>
                        <?= e($invoice['email']); ?>
                    </td>
                </tr>

                <tr>
                    <th>No HP</th>

                    <td>
                        <?= e($invoice['no_hp']); ?>
                    </td>
                </tr>

                <tr>
                    <th>Alamat</th>

                    <td>
                        <?= nl2br(e($invoice['alamat'])); ?>
                    </td>
                </tr>

                <tr>
                    <th>Mobil</th>

                    <td>
                        <?= e($invoice['nama_mobil']); ?>
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Mulai</th>

                    <td>
                        <?= e($invoice['tanggal_mulai']); ?>
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Selesai</th>

                    <td>
                        <?= e($invoice['tanggal_selesai']); ?>
                    </td>
                </tr>

                <tr>
                    <th>Total Hari</th>

                    <td>
                        <?= $invoice['total_hari']; ?>
                        Hari
                    </td>
                </tr>

                <tr>
                    <th>Harga Per Hari</th>

                    <td>
                        Rp <?= number_format(
                            $invoice['harga_per_hari'],
                            0,
                            ',',
                            '.'
                        ); ?>
                    </td>
                </tr>

                <tr>
                    <th>Total Pembayaran</th>

                    <td>

                        <strong>

                        Rp <?= number_format(
                            $invoice['total_harga'],
                            0,
                            ',',
                            '.'
                        ); ?>

                        </strong>

                    </td>
                </tr>

                <tr>
                    <th>Status Rental</th>

                    <td>

                        <?php if(
                            $invoice['status']
                            == 'Selesai'
                        ): ?>

                            <span class="badge bg-success">
                                Selesai
                            </span>

                        <?php elseif(
                            $invoice['status']
                            == 'Sedang Disewa'
                        ): ?>

                            <span class="badge bg-primary">
                                Sedang Berlangsung
                            </span>

                        <?php else: ?>

                            <span class="badge bg-warning text-dark">
                                <?= e($invoice['status']); ?>
                            </span>

                        <?php endif; ?>

                    </td>
                </tr>

            </table>

            <div class="mt-4">

                <button
                    onclick="window.print()"
                    class="btn btn-success"
                >
                    Cetak Invoice
                </button>

                <a
                    href="../booking/riwayat.php"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </div>

            <hr>

            <div class="text-center">

                <small>

                    Terima kasih telah menggunakan
                    RentGo Rental Mobil

                </small>

            </div>

        </div>

    </div>

</div>

</body>
</html>