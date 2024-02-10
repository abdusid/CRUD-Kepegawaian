<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Fungsi untuk membersihkan input dari potensi serangan SQL Injection
function cleanInput($koneksi, $input)
{
    return mysqli_real_escape_string($koneksi, $input);
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    include 'koneksi.php';

    // Fungsi untuk menghapus format rupiah dari nilai gaji
    function removeFormatRupiah($str)
    {
        return preg_replace('/\D/', '', $str);
    }

    // Fungsi untuk menambahkan data jabatan
    function tambahJabatan($koneksi, $jabatan, $gaji)
    {
        $jabatan = cleanInput($koneksi, $jabatan);
        $gaji = cleanInput($koneksi, $gaji);

        $sql = "CALL tambah_jabatan('$jabatan', '$gaji')";
        return mysqli_query($koneksi, $sql);
    }

    // Fungsi untuk mengubah data jabatan
    function ubahJabatan($koneksi, $id_jabatan, $jabatan, $gaji)
    {
        $id_jabatan = cleanInput($koneksi, $id_jabatan);
        $jabatan = cleanInput($koneksi, $jabatan);
        $gaji = cleanInput($koneksi, $gaji);

        $sql = "CALL ubah_jabatan('$id_jabatan', '$jabatan', '$gaji')";
        return mysqli_query($koneksi, $sql);
    }

    // Fungsi untuk menghapus data jabatan
    function hapusJabatan($koneksi, $id_jabatan)
    {
        $id_jabatan = cleanInput($koneksi, $id_jabatan);

        $sql = "CALL hapus_jabatan('$id_jabatan')";
        return mysqli_query($koneksi, $sql);
    }
} else {
    // Jika belum login, arahkan ke laman login.php
    header("Location: login.php");
    exit();
}
