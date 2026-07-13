<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$booking_id = isset($_GET['booking_id'])
    ? (int)$_GET['booking_id']
    : 0;

$data = mysqli_query(
    $conn,
    "SELECT
        booking.*,
        mobil.nama_mobil
    FROM booking
    JOIN mobil
        ON booking.mobil_id = mobil.id
    WHERE booking.id='$booking_id'"
);

$booking = mysqli_fetch_assoc($data);

if (!$booking) {
    die("Booking tidak ditemukan.");
}

if ($booking['status'] != 'Selesai') {
    die("Review hanya dapat diberikan setelah rental selesai.");
}

$cekReview = mysqli_query(
    $conn,
    "SELECT *
    FROM review
    WHERE booking_id='$booking_id'"
);

if (mysqli_num_rows($cekReview) > 0) {
    die("Review untuk booking ini sudah pernah diberikan.");
}

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<title>Beri Review</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container mt-4">

    <h2>Beri Review Mobil</h2>

    <hr>

    <div class="card shadow">

        <div class="card-body">

            <h4>
                <?= htmlspecialchars($booking['nama_mobil']); ?>
            </h4>

            <p>
                Booking ID :
                <?= $booking['id']; ?>
            </p>

            <form action="simpan.php" method="POST">

                <input
                    type="hidden"
                    name="booking_id"
                    value="<?= $booking['id']; ?>"
                >

                <input
                    type="hidden"
                    name="mobil_id"
                    value="<?= $booking['mobil_id']; ?>"
                >

                <div class="mb-3">

                    <label class="form-label">
                        Rating
                    </label>

                    <select
                        name="rating"
                        class="form-control"
                        required
                    >

                        <option value="">
                            Pilih Rating
                        </option>

                        <option value="5">
                            ⭐⭐⭐⭐⭐ (5)
                        </option>

                        <option value="4">
                            ⭐⭐⭐⭐ (4)
                        </option>

                        <option value="3">
                            ⭐⭐⭐ (3)
                        </option>

                        <option value="2">
                            ⭐⭐ (2)
                        </option>

                        <option value="1">
                            ⭐ (1)
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Komentar
                    </label>

                    <textarea
                        name="komentar"
                        class="form-control"
                        rows="5"
                        required
                    ></textarea>

                </div>

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Kirim Review
                </button>

                <a
                    href="../booking/riwayat.php"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>