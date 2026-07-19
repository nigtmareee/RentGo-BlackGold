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

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>

Edit Mobil | RentGo Black Gold Luxury

</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
rel="stylesheet">

<style>

:root{

--gold:#d4af37;
--gold2:#f1c75b;
--dark:#050505;
--card:#111111;
--border:rgba(212,175,55,.18);

}

body{

background:#050505;
color:#fff;
font-family:'Segoe UI',sans-serif;

}

.wrapper{

max-width:900px;
margin:45px auto;

}

.card-premium{

background:#111;
border:1px solid var(--border);
border-radius:24px;
box-shadow:0 15px 35px rgba(0,0,0,.45);

}

.card-header{

padding:30px;
border-bottom:1px solid var(--border);

}

.card-header h2{

color:var(--gold);
font-weight:bold;
margin-bottom:5px;

}

.card-body{

padding:30px;

}

.form-label{

color:#ddd;
font-weight:600;

}

.form-control,
.form-select{

background:#181818;
color:#fff;
border:1px solid #333;
border-radius:12px;

}

.form-control:focus,
.form-select:focus{

background:#202020;
color:#fff;
border-color:var(--gold);
box-shadow:0 0 12px rgba(212,175,55,.25);

}

.btn-gold{

background:linear-gradient(135deg,#d4af37,#f1c75b);
color:#000;
border:none;
font-weight:bold;
border-radius:12px;
padding:10px 30px;

}

.btn-gold:hover{

transform:translateY(-2px);

}

.btn-dark2{

background:#222;
color:#fff;
border-radius:12px;

}

.btn-dark2:hover{

background:#333;
color:#fff;

}

.preview-img{

width:100%;
max-width:350px;
height:220px;
object-fit:cover;
border-radius:15px;
border:2px solid #d4af37;
background:#181818;
padding:4px;

}

</style>

</head>

<body>

<div class="wrapper">

<div class="card-premium">

<div class="card-header">

<h2>

<i class="fas fa-pen-to-square"></i>

Edit Mobil

</h2>

<p class="text-secondary mb-0">

Perbarui informasi kendaraan RentGo Black Gold Luxury

</p>

</div>

<div class="card-body">

<form
action="update.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $row['id']; ?>">

<input
type="hidden"
name="gambar_lama"
value="<?= htmlspecialchars($row['gambar']); ?>">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Mobil

</label>

<input
type="text"
name="nama_mobil"
value="<?= htmlspecialchars($row['nama_mobil']); ?>"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Merk

</label>

<input
type="text"
name="merk"
value="<?= htmlspecialchars($row['merk']); ?>"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Tahun

</label>

<input
type="number"
name="tahun"
value="<?= $row['tahun']; ?>"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Plat Nomor

</label>

<input
type="text"
name="plat_nomor"
value="<?= htmlspecialchars($row['plat_nomor']); ?>"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">

Warna

</label>

<input
type="text"
name="warna"
value="<?= htmlspecialchars($row['warna']); ?>"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Transmisi

</label>

<select
name="transmisi"
class="form-select">

<option
value="Manual"
<?= ($row['transmisi']=="Manual") ? 'selected' : ''; ?>>

Manual

</option>

<option
value="Matic"
<?= ($row['transmisi']=="Matic") ? 'selected' : ''; ?>>

Matic

</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Bahan Bakar

</label>

<input
type="text"
name="bahan_bakar"
value="<?= htmlspecialchars($row['bahan_bakar']); ?>"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Kapasitas Penumpang

</label>

<input
type="number"
name="kapasitas_penumpang"
value="<?= $row['kapasitas_penumpang']; ?>"
class="form-control">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Harga Per Hari

</label>

<input
type="number"
name="harga_per_hari"
value="<?= $row['harga_per_hari']; ?>"
class="form-control"
required>

</div>

<!-- ==========================
GAMBAR MOBIL
========================== -->

<div class="col-md-12 mb-4">

<label class="form-label">

<i class="fas fa-image text-warning"></i>

Gambar Mobil Saat Ini

</label>

<div class="mb-3 text-center">

<?php if(!empty($row['gambar'])): ?>

<img
src="../../assets/img/mobil/<?= htmlspecialchars($row['gambar']); ?>"
class="preview-img">

<?php else: ?>

<div class="alert alert-warning">

Belum ada gambar mobil.

</div>

<?php endif; ?>

</div>

<label class="form-label">

Upload Gambar Baru

</label>

<input
type="file"
name="gambar"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

<small class="text-secondary">

Kosongkan jika tidak ingin mengganti gambar.

</small>

</div>

</div>

<div class="d-flex justify-content-between">

<a
href="index.php"
class="btn btn-dark2">

<i class="fas fa-arrow-left"></i>

Kembali

</a>

<button
type="submit"
class="btn btn-gold">

<i class="fas fa-floppy-disk"></i>

Update Mobil

</button>

</div>

</form>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>