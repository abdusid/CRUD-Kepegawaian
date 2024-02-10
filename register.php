<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

include 'koneksi.php';

// Cek apakah form register telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simpan data yang diinputkan pengguna
    $username = $_POST['usernamereg'];
    $password = $_POST['passwordreg'];

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert data ke database
    $sql = "INSERT INTO pengguna (username, password) VALUES ('$username', '$hashed_password')";

    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke laman login setelah berhasil register
        echo "<script>
        alert('Registrasi sukses!');
        document.location = 'login.php';
        </script>";
        // header("Location: login.php");
        exit();
    } else {
        echo "<script>
        alert('Registrasi gagal! " . mysqli_error($koneksi) . "');
        document.location = 'login.php';
        </script>";
    }
}

mysqli_close($koneksi);
