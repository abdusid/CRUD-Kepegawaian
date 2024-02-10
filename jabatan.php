<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}
// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    // Koneksi ke database
    include 'koneksi.php';
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Data Jabatan</title>
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
                                <a class="nav-link active" href="jabatan.php">Jabatan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="penempatan.php">Penempatan</a>
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
                    Daftar Jabatan
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambahJabatan">
                        Tambah Jabatan
                    </button>

                    <!-- Awal Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID Jabatan</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Gaji</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($koneksi, "SELECT * FROM jabatan");
                            while ($data = mysqli_fetch_array($query)) {
                                echo "<tr>";
                                echo "<td>" . $data['id_jabatan'] . "</td>";
                                echo "<td>" . $data['jabatan'] . "</td>";
                                echo "<td>" . 'Rp. ' . number_format($data['gaji'], 0, ',', '.') . "</td>";
                                echo "<td>
                                <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#modalUbahJabatan" . $data['id_jabatan'] . "'>Ubah</button>
                                <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#modalHapusJabatan" . $data['id_jabatan'] . "'>Hapus</button>
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

        <!-- Modal Tambah Jabatan -->
        <div class="modal fade" id="modalTambahJabatan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Jabatan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="aksi_jabatan.php">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="inputJabatan" class="form-label">Nama Jabatan</label>
                                <input type="text" class="form-control" id="inputJabatan" name="tjabatan">
                            </div>
                            <div class="mb-3">
                                <label for="inputGaji" class="form-label">Gaji</label>
                                <input type="text" class="form-control" id="inputGaji" name="tgaji">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="bsimpan_jabatan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Akhir Modal Tambah Jabatan -->

        <!-- Modal Ubah dan Hapus Jabatan -->
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM jabatan");
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <!-- Modal Ubah Jabatan -->
            <div class="modal fade" id="modalUbahJabatan<?php echo $data['id_jabatan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah Jabatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="aksi_jabatan.php">
                            <div class="modal-body">
                                <input type="hidden" name="id_jabatan" value="<?php echo $data['id_jabatan']; ?>">
                                <div class="mb-3">
                                    <label for="inputJabatan" class="form-label">Nama Jabatan</label>
                                    <input type="text" class="form-control" id="inputJabatan" name="tjabatan" value="<?php echo $data['jabatan']; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inputGaji" class="form-label">Gaji</label>
                                    <input type="text" class="form-control" id="inputGaji<?php echo $data['id_jabatan']; ?>" name="tgaji" value="<?php echo 'Rp. ' . number_format($data['gaji'], 0, ',', '.'); ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary" name="bubah_jabatan">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Ubah Jabatan -->

            <script>
                // Mendapatkan elemen input gaji pada modal ubah
                var inputGajiUbah<?php echo $data['id_jabatan']; ?> = document.getElementById('inputGaji<?php echo $data['id_jabatan']; ?>');

                // Mendengarkan event input pada input gaji pada modal ubah
                inputGajiUbah<?php echo $data['id_jabatan']; ?>.addEventListener('input', function() {
                    // Mengambil nilai input gaji tanpa format
                    var gaji = removeFormat(this.value);
                    // Memformat nilai gaji menjadi format rupiah
                    this.value = formatRupiah(gaji);
                });
            </script>


            <!-- Modal Hapus Jabatan -->
            <div class="modal fade" id="modalHapusJabatan<?php echo $data['id_jabatan']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus Jabatan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="aksi_jabatan.php">
                            <div class="modal-body">
                                <input type="hidden" name="id_jabatan" value="<?php echo $data['id_jabatan']; ?>">
                                <p>Apakah Anda yakin ingin menghapus jabatan <?php echo $data['jabatan']; ?>?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-danger" name="bhapus_jabatan">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Akhir Modal Hapus Jabatan -->
        <?php
        }
        ?>

        <script>
            // Fungsi untuk memformat angka menjadi format rupiah
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return 'Rp. ' + rupiah;
            }

            // Fungsi untuk menghapus tanda titik dan koma pada angka
            function removeFormat(angka) {
                return angka.toString().replace(/[^\d]/g, '');
            }

            // Mendapatkan elemen input gaji
            var inputGaji = document.getElementById('inputGaji');

            // Mendengarkan event input pada input gaji
            inputGaji.addEventListener('input', function() {
                // Mengambil nilai input gaji tanpa format
                var gaji = removeFormat(this.value);
                // Memformat nilai gaji menjadi format rupiah
                this.value = formatRupiah(gaji);
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

    </html>
<?php
} else {
    // Jika belum login, alihkan ke laman login.php
    header("Location: login.php");
    exit(); // Pastikan tidak ada output setelah header redirect
}
