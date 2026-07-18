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

$id = (int) $_SESSION['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM users WHERE id='$id'"
);

$user = mysqli_fetch_assoc($query);

if (!$user) {
    die("Data admin tidak ditemukan.");
}

if (isset($_POST['simpan'])) {

    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $passwordBaru = trim($_POST['password']);

    if (!empty($passwordBaru)) {

        $passwordHash = md5($passwordBaru);

        $update = mysqli_query(
            $conn,
            "UPDATE users SET
                nama='$nama',
                email='$email',
                no_hp='$no_hp',
                alamat='$alamat',
                password='$passwordHash'
            WHERE id='$id'"
        );

    } else {

        $update = mysqli_query(
            $conn,
            "UPDATE users SET
                nama='$nama',
                email='$email',
                no_hp='$no_hp',
                alamat='$alamat'
            WHERE id='$id'"
        );

    }

    if ($update) {

        $_SESSION['nama'] = $nama;

        echo "
        <script>
            alert('Profil berhasil diperbarui');
            window.location='index.php';
        </script>
        ";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Profil Admin | RentGo Black Gold Luxury</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

:root{

    --gold:#d4af37;
    --dark:#050505;
    --card:#111111;
    --border:rgba(212,175,55,.18);

}

body{

    background:#050505;
    color:white;
    font-family:'Segoe UI',sans-serif;

}

.card-premium{

    background:#111;
    border:1px solid var(--border);
    border-radius:22px;
    box-shadow:0 15px 35px rgba(0,0,0,.45);
    padding:35px;

}

.page-title{

    color:var(--gold);
    font-weight:bold;

}

.form-label{

    color:#ddd;
    font-weight:600;

}

.form-control{

    background:#181818;
    border:1px solid #333;
    color:white;

}

.form-control:focus{

    background:#202020;
    color:white;
    border-color:var(--gold);
    box-shadow:0 0 12px rgba(212,175,55,.25);

}

textarea.form-control{

    resize:none;

}

.btn-gold{

    background:linear-gradient(135deg,#d4af37,#f1c75b);
    color:black;
    font-weight:bold;
    border:none;
    padding:10px 28px;

}

.btn-gold:hover{

    transform:translateY(-2px);

}

.profile-icon{

    width:100px;
    height:100px;
    border-radius:50%;
    background:#222;
    display:flex;
    align-items:center;
    justify-content:center;
    margin:auto;
    border:3px solid var(--gold);

}

.profile-icon i{

    font-size:45px;
    color:var(--gold);

}

small{

    color:#aaa !important;

}

</style>

</head>
<body>

<div class="container py-5">

<div class="card-premium">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2 class="page-title">

<i class="fas fa-user-shield"></i>

Profil Admin

</h2>

<p class="text-secondary mb-0">

Kelola informasi akun administrator RentGo Black Gold Luxury

</p>

</div>

<a href="../dashboard.php" class="btn btn-gold">

<i class="fas fa-arrow-left"></i>

Dashboard

</a>

</div>

<div class="text-center mb-4">

<div class="profile-icon">

<i class="fas fa-user-shield"></i>

</div>

<h4 class="mt-3 text-warning">

<?= htmlspecialchars($user['nama']); ?>

</h4>

<p class="text-secondary">

Administrator RentGo

</p>

</div>

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">

Nama Lengkap

</label>

<input
type="text"
name="nama"
class="form-control"
value="<?= htmlspecialchars($user['nama']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
value="<?= htmlspecialchars($user['email']); ?>"
required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Nomor HP

</label>

<input
type="text"
name="no_hp"
class="form-control"
value="<?= htmlspecialchars($user['no_hp'] ?? ''); ?>">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">

Password Baru

</label>

<input
type="password"
name="password"
class="form-control">

<small>

Kosongkan apabila tidak ingin mengganti password.

</small>

</div>

<div class="col-12 mb-4">

<label class="form-label">

Alamat

</label>

<textarea
name="alamat"
class="form-control"
rows="5"><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>

</div>

</div>

<div class="text-end">

<button
type="submit"
name="simpan"
class="btn btn-gold">

<i class="fas fa-save"></i>

Simpan Perubahan

</button>

</div>

</form>

</div>

</div>

</body>
</html>