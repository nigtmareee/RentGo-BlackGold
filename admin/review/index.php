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

$data = mysqli_query(
    $conn,
    "SELECT
        review.*,
        users.nama,
        mobil.nama_mobil
    FROM review
    JOIN users
        ON review.user_id = users.id
    JOIN mobil
        ON review.mobil_id = mobil.id
    ORDER BY review.id DESC"
);

$totalReview = mysqli_num_rows($data);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Kelola Review</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

.rating{
    color:orange;
    font-size:18px;
}

</style>

</head>
<body>

<div class="container mt-4">

    <h2>Kelola Review Pelanggan</h2>

    <hr>

    <a
        href="../dashboard.php"
        class="btn btn-secondary mb-3"
    >
        Kembali Dashboard
    </a>

    <div class="alert alert-info">

        Total Review :

        <strong>
            <?= $totalReview ?>
        </strong>

    </div>

    <table class="table table-bordered table-striped">

        <thead class="table-dark">

        <tr>

            <th width="60">No</th>
            <th>User</th>
            <th>Mobil</th>
            <th width="120">Rating</th>
            <th>Komentar</th>
            <th width="180">Tanggal</th>
            <th width="100">Aksi</th>

        </tr>

        </thead>

        <tbody>

        <?php

        $no = 1;

        mysqli_data_seek($data, 0);

        while($row = mysqli_fetch_assoc($data)):

        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td>
                <?= htmlspecialchars($row['nama']); ?>
            </td>

            <td>
                <?= htmlspecialchars($row['nama_mobil']); ?>
            </td>

            <td class="rating">

                <?php

                for(
                    $i=1;
                    $i<=$row['rating'];
                    $i++
                ){
                    echo "⭐";
                }

                ?>

            </td>

            <td>

                <?= nl2br(
                    htmlspecialchars(
                        $row['komentar']
                    )
                ); ?>

            </td>

            <td>

                <?= $row['created_at']; ?>

            </td>

            <td>

                <a
                    href="hapus.php?id=<?= $row['id']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Hapus review ini?')"
                >
                    Hapus
                </a>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>