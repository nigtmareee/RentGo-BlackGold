<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

$data = mysqli_query(
    $conn,
    "SELECT * FROM mobil WHERE id='$id'"
);

if (!$data) {
    die(mysqli_error($conn));
}

$row = mysqli_fetch_assoc($data);

if (!$row) {
    echo "Data mobil tidak ditemukan";
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">

    <h2>Edit Mobil</h2>

    <form action="update.php" method="POST">

        <input type="hidden"
               name="id"
               value="<?= $row['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nama Mobil</label>
            <input type="text"
                   name="nama_mobil"
                   value="<?= $row['nama_mobil']; ?>"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Merk</label>
            <input type="text"
                   name="merk"
                   value="<?= $row['merk']; ?>"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number"
                   name="tahun"
                   value="<?= $row['tahun']; ?>"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Plat Nomor</label>
            <input type="text"
                   name="plat_nomor"
                   value="<?= $row['plat_nomor']; ?>"
                   class="form-control"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Warna</label>
            <input type="text"
                   name="warna"
                   value="<?= $row['warna']; ?>"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Transmisi</label>
            <select name="transmisi" class="form-control">

                <option value="Manual"
                    <?= ($row['transmisi'] == 'Manual') ? 'selected' : ''; ?>>
                    Manual
                </option>

                <option value="Matic"
                    <?= ($row['transmisi'] == 'Matic') ? 'selected' : ''; ?>>
                    Matic
                </option>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Bahan Bakar</label>
            <input type="text"
                   name="bahan_bakar"
                   value="<?= $row['bahan_bakar']; ?>"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Kapasitas Penumpang</label>
            <input type="number"
                   name="kapasitas_penumpang"
                   value="<?= $row['kapasitas_penumpang']; ?>"
                   class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Per Hari</label>
            <input type="number"
                   name="harga_per_hari"
                   value="<?= $row['harga_per_hari']; ?>"
                   class="form-control"
                   required>
        </div>

        <button type="submit" class="btn btn-success">
            Update
        </button>

        <a href="index.php" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

</body>
</html>