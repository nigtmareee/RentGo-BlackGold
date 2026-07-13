<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Mobil</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-4">

<h2>Tambah Mobil</h2>

<form action="simpan.php" method="POST">

<div class="mb-3">
<label>Nama Mobil</label>
<input type="text" name="nama_mobil" class="form-control" required>
</div>

<div class="mb-3">
<label>Merk</label>
<input type="text" name="merk" class="form-control" required>
</div>

<div class="mb-3">
<label>Tahun</label>
<input type="number" name="tahun" class="form-control" required>
</div>

<div class="mb-3">
<label>Plat Nomor</label>
<input type="text" name="plat_nomor" class="form-control" required>
</div>

<div class="mb-3">
<label>Warna</label>
<input type="text" name="warna" class="form-control">
</div>

<div class="mb-3">
<label>Transmisi</label>
<select name="transmisi" class="form-control">
    <option>Manual</option>
    <option>Matic</option>
</select>
</div>

<div class="mb-3">
<label>Bahan Bakar</label>
<input type="text" name="bahan_bakar" class="form-control">
</div>

<div class="mb-3">
<label>Kapasitas Penumpang</label>
<input type="number" name="kapasitas_penumpang" class="form-control">
</div>

<div class="mb-3">
<label>Harga Per Hari</label>
<input type="number" name="harga_per_hari" class="form-control" required>
</div>

<button type="submit" class="btn btn-success">
Simpan
</button>

</form>

</div>

</body>
</html>