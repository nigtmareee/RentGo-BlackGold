<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$user_id = (int) $_SESSION['id'];

$nama = mysqli_real_escape_string(
    $conn,
    trim($_POST['nama'])
);

$email = mysqli_real_escape_string(
    $conn,
    trim($_POST['email'])
);

$no_hp = mysqli_real_escape_string(
    $conn,
    trim($_POST['no_hp'])
);

$alamat = mysqli_real_escape_string(
    $conn,
    trim($_POST['alamat'])
);

$update = mysqli_query(
    $conn,
    "UPDATE users
    SET
        nama='$nama',
        email='$email',
        no_hp='$no_hp',
        alamat='$alamat'
    WHERE id='$user_id'"
);

if (!$update) {

?>
<!DOCTYPE html>
<html>
<head>
<title>RentGo</title>

<style>

body{
    background:#050505;
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
    font-family:'Segoe UI',sans-serif;
}

.card{
    background:#111;
    padding:40px;
    border-radius:20px;
    border:1px solid #dc3545;
    text-align:center;
}

.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:#dc3545;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

</style>

</head>

<body>

<div class="card">

<h2>❌ Update Gagal</h2>

<p>

<?= mysqli_error($conn); ?>

</p>

<a
href="index.php"
class="btn"
>

Kembali

</a>

</div>

</body>
</html>

<?php
exit;
}

$_SESSION['nama'] = $nama;

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>RentGo</title>

<style>

body{

    background:#050505;

    display:flex;

    justify-content:center;

    align-items:center;

    height:100vh;

    font-family:'Segoe UI',sans-serif;
}

.success-card{

    background:#111;

    border:1px solid rgba(212,175,55,.3);

    border-radius:25px;

    padding:50px;

    text-align:center;

    color:white;

    width:450px;
}

.icon{

    font-size:70px;

    color:#d4af37;

    margin-bottom:20px;
}

h2{

    margin-bottom:15px;
}

p{

    color:#bbb;
}

.btn-gold{

    display:inline-block;

    margin-top:25px;

    padding:12px 30px;

    background:#d4af37;

    color:black;

    text-decoration:none;

    font-weight:700;

    border-radius:12px;
}

</style>

</head>

<body>

<div class="success-card">

<div class="icon">

✓

</div>

<h2>

Profil Berhasil Diperbarui

</h2>

<p>

Data akun Anda telah berhasil disimpan.

</p>

<a
href="index.php"
class="btn-gold"
>

Kembali ke Profil

</a>

</div>

</body>
</html>