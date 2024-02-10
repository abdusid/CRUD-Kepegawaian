<?php
// Koneksi ke database
$server = "localhost";
$user = "root";
$pass = "";
$database = "kepegawaian";

// Koneksi dan memilih database di server
$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));
