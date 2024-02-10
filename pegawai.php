<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}
// Koneksi ke database
include 'koneksi.php';
// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
?>
    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kepegawaian</title>
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
                                <a class="nav-link active" href="pegawai.php">Pegawai</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="jabatan.php">Jabatan</a>
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
                    Data Pegawai
                </div>
                <div class="card-body">
                    <!-- Button trigger modal Tambah-->
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Data
                    </button>

                    <!-- Awal Table -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">NIP</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Telepon</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">Penempatan</th>
                                <th scope="col">Gaji</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>

                        <?php
                        // Menampilkan data pegawai
                        $no = 1;
                        $tampil = mysqli_query($koneksi, "SELECT pegawai.`id_pegawai`,pegawai.`nip`,pegawai.`nama`,pegawai.`jenis_kelamin`,pegawai.`alamat`,pegawai.`telepon`,jabatan.`jabatan`,penempatan.`kota`,jabatan.`gaji` FROM pegawai,jabatan,penempatan WHERE pegawai.`id_jabatan` = jabatan.`id_jabatan` AND pegawai.id_penempatan = penempatan.`id_penempatan` ORDER BY pegawai.`id_pegawai` DESC");
                        // $tampil = mysqli_query($koneksi, "CALL tampilkan_pegawai()");
                        if (!$tampil) {
                            echo "Error: " . mysqli_error($koneksi);
                            // atau die(mysqli_error($koneksi)); untuk menghentikan eksekusi jika terjadi kesalahan
                        }
                        while ($data = mysqli_fetch_array($tampil)) :
                        ?>
                            <tbody>
                                <tr>
                                    <th scope="row"><?= $no++; ?></th>
                                    <td><?= $data['nip']; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td><?= $data['jenis_kelamin']; ?></td>
                                    <td><?= $data['alamat']; ?></td>
                                    <td><?= $data['telepon']; ?></td>
                                    <td><?= $data['jabatan']; ?></td>
                                    <td><?= $data['kota']; ?></td>
                                    <td>Rp. <?= number_format($data['gaji'], 0, ',', '.'); ?></td>
                                    <td>
                                        <a href="" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $no ?>">Ubah</a>
                                        <a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $no ?>">Hapus</a>
                                    </td>
                                </tr>
                                <!-- Awal Modal Ubah-->
                                <!-- Bisa dibesarkan tambah modal lg di class -->
                                <div class="modal fade" id="modalUbah<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Data Pegawai</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="aksi_pegawai.php">
                                                <input type="hidden" name="id_pegawai" value="<?= $data['id_pegawai'] ?>">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">NIP</label>
                                                        <input type="text" class="form-control" name="tnip" value="<?= $data['nip'] ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Lengkap</label>
                                                        <input type="text" class="form-control" name="tnama" value="<?= $data['nama'] ?>">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Jenis Kelamin</label>
                                                        <select class="form-select" name="tjk">
                                                            <option selected disabled>Pilih Jenis Kelamin</option>
                                                            <?php if ($data['jenis_kelamin'] == "Laki-laki") : ?>
                                                                <option value="Laki-laki" selected>Laki-laki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            <?php else : ?>
                                                                <option value="Laki-laki">Laki-laki</option>
                                                                <option value="Perempuan" selected>Perempuan</option>
                                                            <?php endif; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea class="form-control" name="talamat" rows="3"><?= $data['alamat'] ?></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Telepon</label>
                                                        <input type="text" class="form-control" name="ttelepon" value="<?= $data['telepon'] ?>">
                                                    </div>


                                                    <div class="mb-3">
                                                        <label class="form-label">Jabatan</label>
                                                        <?php
                                                        $tampilJabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");
                                                        ?>
                                                        <select class="form-select" name="tjabatan" id="selectJabatan">
                                                            <option selected disabled>Pilih Jabatan</option>
                                                            <?php
                                                            while ($dataJabatan = mysqli_fetch_array($tampilJabatan)) {
                                                                if ($data['jabatan'] == $dataJabatan['jabatan']) {
                                                                    echo "<option value='" . $dataJabatan['id_jabatan'] . "' data-gaji='" . $dataJabatan['gaji'] . "' selected>" . $dataJabatan['jabatan'] . "</option>";
                                                                } else {
                                                                    echo "<option value='" . $dataJabatan['id_jabatan'] . "' data-gaji='" . $dataJabatan['gaji'] . "'>" . $dataJabatan['jabatan'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Penempatan</label>
                                                        <?php
                                                        $tampilPenempatan = mysqli_query($koneksi, "SELECT * FROM penempatan");
                                                        ?>
                                                        <select class="form-select" name="tpenempatan">
                                                            <option value="">Pilih Penempatan</option>
                                                            <?php
                                                            while ($dataPenempatan = mysqli_fetch_array($tampilPenempatan)) {
                                                                if ($data['kota'] == $dataPenempatan['kota']) {
                                                                    echo "<option value='" . $dataPenempatan['id_penempatan'] . "' selected>" . $dataPenempatan['kota'] . "</option>";
                                                                } else {
                                                                    echo "<option value='" . $dataPenempatan['id_penempatan'] . "'>" . $dataPenempatan['kota'] . "</option>";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Gaji</label>
                                                        <input type="text" class="form-control" name="tgaji" id="inputGaji" placeholder="Gaji">
                                                    </div>

                                                    <script>
                                                        // Ambil elemen select jabatan dan input gaji
                                                        var selectJabatan = document.getElementById('selectJabatan');
                                                        var inputGaji = document.getElementById('inputGaji');

                                                        // Tambahkan event listener untuk perubahan pada select jabatan
                                                        selectJabatan.addEventListener('change', function() {
                                                            // Ambil data-gaji yang sesuai dari opsi yang dipilih
                                                            var selectedOption = selectJabatan.options[selectJabatan.selectedIndex];
                                                            var gaji = selectedOption.getAttribute('data-gaji');

                                                            // Tetapkan nilai gaji ke dalam input gaji, atau 0 jika tidak ada data-gaji yang tersedia
                                                            inputGaji.value = gaji !== null ? gaji : '0';
                                                        });

                                                        // Jalankan event change secara manual untuk memastikan nilai gaji default diatur saat halaman dimuat
                                                        selectJabatan.dispatchEvent(new Event('change'));
                                                    </script>



                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="bubah">Simpan</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Ubah -->


                                <!-- Awal Modal Hapus-->
                                <!-- Bisa dibesarkan tambah modal lg di class -->
                                <div class="modal fade" id="modalHapus<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Data</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="aksi_pegawai.php">
                                                <input type="hidden" name="id_pegawai" value="<?= $data['id_pegawai'] ?>">
                                                <div class="modal-body">
                                                    <h3 class="text-center">Apakah Anda yakin ingin menghapus data ini?<br>
                                                        <span class="text-danger"><?= $data['nip'] . " - " . $data['nama']; ?></span>
                                                    </h3>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary" name="bhapus">Hapus</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Hapus -->
                            </tbody>
                        <?php endwhile; ?>
                    </table>
                    <!-- Akhir Table -->


                    <!-- Awal Modal Tambah-->
                    <!-- Bisa dibesarkan tambah modal lg di class -->
                    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Form Data Pegawai</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="aksi_pegawai.php">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">NIP</label>
                                            <input type="text" class="form-control" name="tnip" placeholder="Nomor Induk Pegawai">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="tnama" placeholder="Nama Lengkap">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label
                                        ">Jenis Kelamin</label>
                                            <select class="form-select" name="tjk">
                                                <option selected>Pilih Jenis Kelamin</option>
                                                <option value="Laki-laki">Laki-laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alamat</label>
                                            <textarea class="form-control" name="talamat" rows="3"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Telepon</label>
                                            <input type="text" class="form-control" name="ttelepon" placeholder="Nomor Telepon">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Jabatan</label>
                                            <?php
                                            $tampilJabatan = mysqli_query($koneksi, "SELECT * FROM jabatan");
                                            ?>
                                            <select class="form-select" name="tjabatan" id="selectJabatanTambah">
                                                <option selected disabled>Pilih Jabatan</option>
                                                <?php while ($data = mysqli_fetch_array($tampilJabatan)) : ?>
                                                    <option value="<?= $data['id_jabatan']; ?>" data-gaji-tambah="<?= $data['gaji']; ?>"><?= $data['jabatan']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Penempatan</label>
                                            <?php
                                            $tampilPenempatan = mysqli_query($koneksi, "SELECT * FROM penempatan");
                                            ?>
                                            <select class="form-select" name="tpenempatan">
                                                <option selected disabled>Pilih Penempatan</option>
                                                <?php while ($data = mysqli_fetch_array($tampilPenempatan)) : ?>
                                                    <option value="<?= $data['id_penempatan']; ?>"><?= $data['kota']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Gaji</label>
                                            <input type="text" class="form-control" name="tgaji" id="inputGajiTambah" placeholder="Gaji">
                                        </div>

                                        <script>
                                            var selectJabatanTambah = document.getElementById('selectJabatanTambah');
                                            var inputGajiTambah = document.getElementById('inputGajiTambah');

                                            selectJabatanTambah.addEventListener('change', function() {
                                                var selectedOptionTambah = selectJabatanTambah.options[selectJabatanTambah.selectedIndex];
                                                var gaji = selectedOptionTambah.getAttribute('data-gaji-tambah');

                                                inputGajiTambah.value = gaji !== null ? formatRupiah(gaji, 'Rp. ') : 'Rp. 0';
                                            });

                                            // Pemanggilan Fungsi saat Halaman Dimuat
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Mendapatkan nilai gaji awal dari opsi jabatan yang dipilih saat halaman dimuat
                                                var selectedOptionTambah = selectJabatanTambah.options[selectJabatanTambah.selectedIndex];
                                                var gaji = selectedOptionTambah.getAttribute('data-gaji-tambah');

                                                // Menetapkan nilai gaji ke input gaji saat halaman dimuat
                                                inputGajiTambah.value = gaji !== null ? formatRupiah(gaji, 'Rp. ') : 'Rp. 0';
                                            });

                                            // Format Rupiah
                                            function formatRupiah(angka, prefix) {
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
                                                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                                            }
                                        </script>



                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" name="bsimpan">Simpan</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Keluar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Akhir Modal Tambah -->
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>

    </html>
<?php } else {
    // Jika belum login, alihkan ke laman login.php
    header("Location: login.php");
    exit(); // Pastikan tidak ada output setelah header redirect
} ?>