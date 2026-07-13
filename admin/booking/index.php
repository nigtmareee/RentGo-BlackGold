<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: ../../auth/login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$data = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        users.nama,
        mobil.nama_mobil
    FROM booking
    JOIN users
        ON booking.user_id = users.id
    JOIN mobil
        ON booking.mobil_id = mobil.id
    ORDER BY booking.id DESC"
);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Booking</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Kelola Booking</h2>
    <hr>

    <a href="../dashboard.php" class="btn btn-secondary mb-3">
        Kembali Dashboard
    </a>

    <table class="table table-bordered table-striped">

        <tr>
            <th>No</th>
            <th>User</th>
            <th>Mobil</th>
            <th>Tanggal Sewa</th>
            <th>Total Hari</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while($row = mysqli_fetch_assoc($data)):
        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td><?= $row['nama']; ?></td>

            <td><?= $row['nama_mobil']; ?></td>

            <td>
                <?= $row['tanggal_mulai']; ?>
                s/d
                <?= $row['tanggal_selesai']; ?>
            </td>

            <td><?= $row['total_hari']; ?></td>

            <td>
                Rp <?= number_format($row['total_harga']); ?>
            </td>

            <td>

                <?php if($row['status'] == 'Menunggu Pembayaran'): ?>

                    <span class="badge bg-warning text-dark">
                        Menunggu Pembayaran
                    </span>

                <?php elseif($row['status'] == 'Sedang Disewa'): ?>

                    <span class="badge bg-primary">
                        Sedang Disewa
                    </span>

                <?php elseif($row['status'] == 'Selesai'): ?>

                    <span class="badge bg-success">
                        Selesai
                    </span>

                <?php elseif($row['status'] == 'Dibatalkan'): ?>

                    <span class="badge bg-danger">
                        Dibatalkan
                    </span>

                <?php endif; ?>

            </td>

            <td>

                <?php if($row['status'] == 'Sedang Disewa'): ?>

                    <a
                        href="proses_status.php?id=<?= $row['id']; ?>"
                        class="btn btn-success btn-sm"
                        onclick="return confirm('Selesaikan penyewaan ini?')"
                    >
                        Selesaikan
                    </a>

                <?php elseif($row['status'] == 'Selesai'): ?>

                    <button
                        class="btn btn-secondary btn-sm"
                        disabled
                    >
                        Selesai
                    </button>

                <?php else: ?>

                    <button
                        class="btn btn-light btn-sm"
                        disabled
                    >
                        -
                    </button>

                <?php endif; ?>

            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>