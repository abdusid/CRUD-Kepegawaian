<?php
// Fungsi untuk membersihkan input dari potensi serangan SQL Injection
function cleanInput($koneksi, $input)
{
    return mysqli_real_escape_string($koneksi, $input);
}

// Fungsi untuk menambahkan data penempatan
function tambahPenempatan($koneksi, $kota, $alamat)
{
    $kota = cleanInput($koneksi, $kota);
    $alamat = cleanInput($koneksi, $alamat);

    $sql = "INSERT INTO penempatan (kota, alamat) VALUES ('$kota', '$alamat')";
    return mysqli_query($koneksi, $sql);
}

// Fungsi untuk mengubah data penempatan
function ubahPenempatan($koneksi, $id_penempatan, $kota, $alamat)
{
    $id_penempatan = cleanInput($koneksi, $id_penempatan);
    $kota = cleanInput($koneksi, $kota);
    $alamat = cleanInput($koneksi, $alamat);

    $sql = "UPDATE penempatan SET kota='$kota', alamat='$alamat' WHERE id_penempatan='$id_penempatan'";
    return mysqli_query($koneksi, $sql);
}

// Fungsi untuk menghapus data penempatan
function hapusPenempatan($koneksi, $id_penempatan)
{
    $id_penempatan = cleanInput($koneksi, $id_penempatan);

    $sql = "DELETE FROM penempatan WHERE id_penempatan='$id_penempatan'";
    return mysqli_query($koneksi, $sql);
}
