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

$id = (int)$_GET['id'];

mysqli_query(
    $conn,
    "DELETE FROM review
    WHERE id='$id'"
);

header("Location: index.php");
exit;