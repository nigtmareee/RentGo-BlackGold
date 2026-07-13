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
    "SELECT * FROM users ORDER BY id DESC"
);

if (!$data) {
    die(mysqli_error($conn));
}

$totalPengguna = mysqli_num_rows($data);

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Kelola Pengguna</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <h2>Kelola Pengguna</h2>

    <hr>

    <a href="../dashboard.php" class="btn btn-secondary mb-3">
        Kembali Dashboard
    </a>

    <div class="alert alert-info">
        Total Pengguna :
        <strong><?= $totalPengguna ?></strong>
    </div>

    <table class="table table-bordered table-striped table-hover">

        <thead class="table-dark">
            <tr>
                <th width="60">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th width="120">Role</th>
                <th width="140">Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php

        $no = 1;

        while($row = mysqli_fetch_assoc($data)):

        ?>

        <tr>

            <td><?= $no++; ?></td>

            <td>
                <?= htmlspecialchars($row['nama']); ?>
            </td>

            <td>
                <?= htmlspecialchars($row['email']); ?>
            </td>

            <td>
                <?= !empty($row['no_hp'])
                    ? htmlspecialchars($row['no_hp'])
                    : '-'; ?>
            </td>

            <td>
                <?= !empty($row['alamat'])
                    ? htmlspecialchars($row['alamat'])
                    : '-'; ?>
            </td>

            <td>

                <?php if($row['role'] == 'admin'): ?>

                    <span class="badge bg-danger">
                        Admin
                    </span>

                <?php else: ?>

                    <span class="badge bg-primary">
                        User
                    </span>

                <?php endif; ?>

            </td>

            <td>

                <?php if($row['id'] != $_SESSION['id']): ?>

                    <a
                        href="hapus.php?id=<?= $row['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin ingin menghapus pengguna ini?')"
                    >
                        Hapus
                    </a>

                <?php else: ?>

                    <button
                        class="btn btn-secondary btn-sm"
                        disabled
                    >
                        Akun Saya
                    </button>

                <?php endif; ?>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</body>
</html>