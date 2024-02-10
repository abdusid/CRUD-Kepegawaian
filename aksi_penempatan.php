<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    // Koneksi ke database
    include 'koneksi.php';

    // Ambil Fungsi dari fpenempatan.php
    include 'fungsi/fpenempatan.php';

    // Cek apakah tombol simpan penempatan ditekan
    if (isset($_POST['bsimpan_penempatan'])) {
        // Ambil data dari form
        $kota = $_POST['tkota'];
        $alamat = $_POST['talamat'];

        // Query untuk menyimpan data ke database menggunakan stored procedure
        $result = tambahPenempatan($koneksi, $kota, $alamat);

        if ($result) {
            // Jika berhasil disimpan, arahkan kembali ke halaman utama
            header("Location: penempatan.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'penempatan.php';
            </script>";
        }
    }

    // Cek apakah tombol ubah penempatan ditekan
    if (isset($_POST['bubah_penempatan'])) {
        // Ambil data dari form
        $id_penempatan = $_POST['id_penempatan'];
        $kota = $_POST['tkota'];
        $alamat = $_POST['talamat'];

        // Query untuk mengubah data di database menggunakan stored procedure
        $result = ubahPenempatan($koneksi, $id_penempatan, $kota, $alamat);

        if ($result) {
            // Jika berhasil diubah, arahkan kembali ke halaman utama
            header("Location: penempatan.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'penempatan.php';
            </script>";
        }
    }

    // Cek apakah tombol hapus penempatan ditekan
    if (isset($_POST['bhapus_penempatan'])) {
        // Ambil ID penempatan yang akan dihapus
        $id_penempatan = $_POST['id_penempatan'];

        // Query untuk menghapus data dari database menggunakan stored procedure
        $result = hapusPenempatan($koneksi, $id_penempatan);

        if ($result) {
            // Jika berhasil dihapus, arahkan kembali ke halaman utama
            header("Location: penempatan.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'penempatan.php';
            </script>";
        }
    }
} else {
    // Jika belum login, redirect ke laman login
    header("Location: login.php");
    exit();
}
