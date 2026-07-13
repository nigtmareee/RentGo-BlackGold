<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../config/koneksi.php';
require_once '../config/koneksi.php';

/** @var mysqli $conn */

$nama     = trim($_POST['nama']);
$email    = trim($_POST['email']);
$password = md5($_POST['password']);

$cek = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($cek) > 0){

    echo "<script>
    alert('Email sudah digunakan!');
    window.location='register.php';
    </script>";

}else{

    $query = mysqli_query($conn,"
        INSERT INTO users
        (nama,email,password,role)
        VALUES
        ('$nama','$email','$password','user')
    ");

    if($query){

        echo "<script>
        alert('Registrasi berhasil!');
        window.location='login.php';
        </script>";

    }else{

        die(mysqli_error($conn));

    }
}
?>