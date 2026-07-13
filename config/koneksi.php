<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "rentgo"
);

if(!$conn){
    die("Koneksi gagal : " . mysqli_connect_error());
}