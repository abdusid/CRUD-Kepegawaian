<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    // Koneksi ke database
    include 'koneksi.php';

    // Fungsi untuk memformat angka menjadi format rupiah
    function formatRupiah($angka)
    {
        $rupiah = number_format($angka, 0, ',', '.');
        return 'Rp. ' . $rupiah;
    }
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Penempatan</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    </head>

    <body>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h2 class="text-center mb-4">Selamat Datang di Aplikasi Kepegawaian</h2>
                    <p class="text-center">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
                    <nav class="navbar navbar-dark bg-dark">
                        <!-- Navbar content -->
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="index.php">Dasbor</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="pegawai.php">Pegawai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="jabatan.php">Jabatan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="penempatan.php">Penempatan</a>
                            </li>
                        </ul>
                        <ul class="nav nav-pills justify-content-end">
                            <li class="nav-item ms-auto">
                                <a class="nav-link bg-danger text-white" href="logout.php">Keluar</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="card mt-3">
                <div class="card-header bg-primary text-white">
                    Daftar Penempatan
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahPenempatan">
                        Tambah Penempatan
                    </button>

                    <!-- Awal Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID Penempatan</th>
                                <th scope="col">Kota</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM penempatan");
                            while ($data = mysqli_fetch_array($query)) {
                                echo "<tr>";
                                echo "<td>" . $data['id_penempatan'] . "</td>";
                                echo "<td>" . $data['kota'] . "</td>";
                                echo "<td>" . $data['alamat'] . "</td>";
                                echo "<td>
                                <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalUbahPenempatan" . $data['id_penempatan'] . "'>Ubah</button>
                                <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#modalHapusPenempatan" . $data['id_penempatan'] . "'>Hapus</button>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Akhir Table -->
                </div>
            </div>
        </div>

        <!-- Modal Tambah Penempatan -->
        <div class="modal fade" id="modalTambahPenempatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Penempatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="aksi_penempatan.php">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="inputKota" class="form-label">Kota</label>
                                <input type="text" class="form-control" id="inputKota" name="tkota">
                            </div>
                            <div class="mb-3">
                                <label for="inputAlamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="inputAlamat" name="talamat">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="bsimpan_penempatan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Akhir Modal Tambah Penempatan -->

        <!-- Modal Ubah dan Hapus Penempatan -->
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM penempatan");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <!-- Modal Ubah Penempatan -->
            <div class="modal fade" id="modalUbahPenempatan<?php echo $data['id_penempatan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah Penempatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="aksi_penempatan.php">
                            <div class="modal-body">
                                <input type="hidden" name="id_penempatan" value="<?php echo $data['id_penempatan']; ?>">
                                <div class="mb-3">
                                    <label for="inputKota" class="form-label">Kota</label>
                                    <input type="text" class="form-control" id="inputKota" name="tkota" value="<?php echo $data['kota']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inputAlamat" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="inputAlamat" name="talamat" value="<?php echo $data['alamat']; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" name="bubah_penempatan">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Ubah Penempatan -->

            <!-- Modal Hapus Penempatan -->
            <div class="modal fade" id="modalHapusPenempatan<?php echo $data['id_penempatan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Penempatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="aksi_penempatan.php">
                            <div class="modal-body">
                                <input type="hidden" name="id_penempatan" value="<?php echo $data['id_penempatan']; ?>">
                                <p>Apakah Anda yakin ingin menghapus penempatan <?php echo $data['kota']; ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger" name="bhapus_penempatan">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Hapus Penempatan -->
        <?php
        }
        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} else {
    // Jika belum login, alihkan ke laman login.php
    header("Location: login.php");
    exit(); // Pastikan tidak ada output setelah header redirect
}
?>