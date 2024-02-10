<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {

    // Koneksi ke database
    include 'koneksi.php';

    // Ambil Fungsi dari fjabatan.php
    include 'fungsi/fjabatan.php';

    // Cek apakah tombol simpan jabatan ditekan
    if (isset($_POST['bsimpan_jabatan'])) {
        // Ambil data dari form
        $jabatan = $_POST['tjabatan'];
        // Hapus format rupiah dari nilai gaji
        $gaji = removeFormatRupiah($_POST['tgaji']);

        // Query untuk menyimpan data ke database menggunakan stored procedure
        $result = tambahJabatan($koneksi, $jabatan, $gaji);

        if ($result) {
            // Jika berhasil disimpan, arahkan kembali ke halaman utama
            header("Location: jabatan.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'jabatan.php';
            </script>";
        }
    }

    // Cek apakah tombol ubah jabatan ditekan
    if (isset($_POST['bubah_jabatan'])) {
        // Ambil data dari form
        $id_jabatan = $_POST['id_jabatan'];
        $jabatan = $_POST['tjabatan'];
        // Hapus format rupiah dari nilai gaji
        $gaji = removeFormatRupiah($_POST['tgaji']);

        // Query untuk mengubah data di database menggunakan stored procedure
        $result = ubahJabatan($koneksi, $id_jabatan, $jabatan, $gaji);

        if ($result) {
            // Jika berhasil diubah, arahkan kembali ke halaman utama
            header("Location: jabatan.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'jabatan.php';
            </script>";
        }
    }

    // Cek apakah tombol hapus jabatan ditekan
    if (isset($_POST['bhapus_jabatan'])) {
        // Ambil ID jabatan yang akan dihapus
        $id_jabatan = $_POST['id_jabatan'];

        // Query untuk menghapus data dari database menggunakan stored procedure
        $result = hapusJabatan($koneksi, $id_jabatan);

        if ($result) {
            // Jika berhasil dihapus, arahkan kembali ke halaman utama
            header("Location: jabatan.php");
            exit();
        } else {
            // Jika gagal, tampilkan pesan kesalahan
            echo "<script>
            alert('Error: " . mysqli_error($koneksi) . "');
            document.location = 'jabatan.php';
            </script>";
        }
    }
} else {
    // Jika belum login, redirect ke laman login
    header("Location: login.php");
    exit();
}
