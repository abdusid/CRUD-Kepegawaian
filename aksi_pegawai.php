<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
include 'fungsi/fpegawai.php';

if (isset($_POST['bsimpan'])) {
    if (tambahPegawai($koneksi, $_POST['tnip'], $_POST['tnama'], $_POST['tjk'], $_POST['talamat'], $_POST['ttelepon'], $_POST['tjabatan'], $_POST['tpenempatan'])) {
        header('Location: pegawai.php');
    } else {
        echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'pegawai.php';
            </script>";
    }
}

if (isset($_POST['bubah'])) {
    if (ubahPegawai($koneksi, $_POST['id_pegawai'], $_POST['tnip'], $_POST['tnama'], $_POST['tjk'], $_POST['talamat'], $_POST['ttelepon'], $_POST['tjabatan'], $_POST['tpenempatan'])) {
        header('Location: pegawai.php');
    } else {
        echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'pegawai.php';
            </script>";
    }
}

if (isset($_POST['bhapus'])) {
    if (hapusPegawai($koneksi, $_POST['id_pegawai'])) {
        header('Location: pegawai.php');
    } else {
        echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'pegawai.php';
            </script>";
    }
}

mysqli_close($koneksi);
