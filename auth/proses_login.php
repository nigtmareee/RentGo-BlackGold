<?php

session_start();
include '../config/koneksi.php';
require_once '../config/koneksi.php';

/** @var mysqli $conn */

$email    = $_POST['email'];
$password = md5($_POST['password']);

$query = mysqli_query($conn,
"SELECT * FROM users WHERE email='$email'");

$data = mysqli_fetch_assoc($query);

if($data){

if($password == $data['password']){

        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        if($data['role'] == 'admin'){

            header("Location: ../admin/dashboard.php");

        }else{

            header("Location: ../user/dashboard.php");

        }

    }else{

        echo "<script>
        alert('Password salah');
        window.location='login.php';
        </script>";

    }

}else{

    echo "<script>
    alert('Email tidak ditemukan');
    window.location='login.php';
    </script>";

}
?>

