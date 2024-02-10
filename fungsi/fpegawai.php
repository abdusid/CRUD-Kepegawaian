<?php
// fungsi.php

// Fungsi untuk membersihkan input dari potensi serangan SQL Injection
function cleanInput($koneksi, $input)
{
    return mysqli_real_escape_string($koneksi, $input);
}

// Fungsi untuk menambahkan data pegawai
function tambahPegawai($koneksi, $nip, $nama, $jk, $alamat, $telepon, $id_jabatan, $id_penempatan)
{
    $nip = cleanInput($koneksi, $nip);
    $nama = cleanInput($koneksi, $nama);
    $jk = cleanInput($koneksi, $jk);
    $alamat = cleanInput($koneksi, $alamat);
    $telepon = cleanInput($koneksi, $telepon);
    $id_jabatan = cleanInput($koneksi, $id_jabatan);
    $id_penempatan = cleanInput($koneksi, $id_penempatan);

    $sql = "CALL tambah_pegawai('$nip', '$nama', '$jk', '$alamat', '$telepon', '$id_jabatan', '$id_penempatan')";

    return mysqli_query($koneksi, $sql);
}

// Fungsi untuk mengubah data pegawai
function ubahPegawai($koneksi, $id_pegawai, $nip, $nama, $jk, $alamat, $telepon, $id_jabatan, $id_penempatan)
{
    $id_pegawai = cleanInput($koneksi, $id_pegawai);
    $nip = cleanInput($koneksi, $nip);
    $nama = cleanInput($koneksi, $nama);
    $jk = cleanInput($koneksi, $jk);
    $alamat = cleanInput($koneksi, $alamat);
    $telepon = cleanInput($koneksi, $telepon);
    $id_jabatan = cleanInput($koneksi, $id_jabatan);
    $id_penempatan = cleanInput($koneksi, $id_penempatan);

    $sql = "CALL ubah_pegawai('$id_pegawai', '$nip', '$nama', '$jk', '$alamat', '$telepon', '$id_jabatan', '$id_penempatan')";

    return mysqli_query($koneksi, $sql);
}

// Fungsi untuk menghapus data pegawai
function hapusPegawai($koneksi, $id_pegawai)
{
    $id_pegawai = cleanInput($koneksi, $id_pegawai);

    $sql = "CALL hapus_pegawai('$id_pegawai')";

    return mysqli_query($koneksi, $sql);
}
