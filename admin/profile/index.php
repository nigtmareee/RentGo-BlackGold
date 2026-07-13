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
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Profil Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <h2>Profil Admin</h2>

    <hr>

    <a
        href="../dashboard.php"
        class="btn btn-secondary mb-3"
    >
        Kembali Dashboard
    </a>

    <div class="card shadow">

        <div class="card-body">

            <form method="POST">

                <div class="mb-3">

                    <label>Nama</label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="<?= htmlspecialchars($user['nama']); ?>"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($user['email']); ?>"
                        required
                    >

                </div>

                <div class="mb-3">

                    <label>No HP</label>

                    <input
                        type="text"
                        name="no_hp"
                        class="form-control"
                        value="<?= htmlspecialchars($user['no_hp'] ?? ''); ?>"
                    >

                </div>

                <div class="mb-3">

                    <label>Alamat</label>

                    <textarea
                        name="alamat"
                        class="form-control"
                        rows="4"
                    ><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>

                </div>

                <div class="mb-3">

                    <label>Password Baru</label>

                    <input
                        type="password"
                        name="password"
                        class="form-control"
                    >

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti password.
                    </small>

                </div>

                <button
                    type="submit"
                    name="simpan"
                    class="btn btn-success"
                >
                    Simpan Perubahan
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>