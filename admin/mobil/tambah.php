<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Tambah Mobil | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

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

.page-title{
    color:var(--gold);
    font-weight:bold;
}

.card-premium{
    background:#111;
    border:1px solid var(--border);
    border-radius:22px;
    padding:35px;
    box-shadow:0 15px 35px rgba(0,0,0,.45);
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

    box-shadow:0 0 12px rgba(212,175,55,.3);

}

.btn-gold{

    background:linear-gradient(135deg,#d4af37,#f1c75b);
    color:#000;
    font-weight:bold;
    border:none;
    border-radius:12px;
    padding:10px 30px;
    transition:.3s;

}

.btn-gold:hover{

    transform:translateY(-3px);
    box-shadow:0 8px 18px rgba(212,175,55,.4);

}

.btn-dark2{

    background:#222;
    color:white;
    border-radius:12px;

}

.btn-dark2:hover{

    background:#333;
    color:white;

}

.card-premium hr{

    border-color:rgba(212,175,55,.15);

}

</style>

</head>

<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">
<i class="fas fa-car-side"></i>
Tambah Mobil
</h2>

<p class="text-secondary mb-0">
Tambahkan armada baru ke sistem RentGo Black Gold Luxury
</p>

</div>

</div>

<hr>

<form action="simpan.php" method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">
Nama Mobil
</label>

<input type="text"
name="nama_mobil"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Merk
</label>

<input type="text"
name="merk"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Tahun
</label>

<input type="number"
name="tahun"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Plat Nomor
</label>

<input type="text"
name="plat_nomor"
class="form-control"
required>

</div>

<div class="col-md-4 mb-3">

<label class="form-label">
Warna
</label>

<input type="text"
name="warna"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Transmisi
</label>

<select name="transmisi" class="form-select">

<option>Manual</option>
<option>Matic</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Bahan Bakar
</label>

<input type="text"
name="bahan_bakar"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Kapasitas Penumpang
</label>

<input type="number"
name="kapasitas_penumpang"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">
Harga Per Hari
</label>

<input type="number"
name="harga_per_hari"
class="form-control"
required>

</div>

</div>

<div class="mt-4 d-flex justify-content-between">

<a href="index.php"
class="btn btn-dark2">

<i class="fas fa-arrow-left"></i>

Kembali

</a>

<button type="submit"
class="btn btn-gold">

<i class="fas fa-save"></i>

Simpan Mobil

</button>

</div>

</form>

</div>

</div>

</body>
</html>