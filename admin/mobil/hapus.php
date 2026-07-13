<?php

require_once '../../config/koneksi.php';

/** @var mysqli $conn */

$id = (int)$_GET['id'];

$query = mysqli_query(
    $conn,
    "DELETE FROM mobil WHERE id='$id'"
);

if($query){
    header("Location: index.php");
    exit;
}else{
    echo mysqli_error($conn);
}
?>