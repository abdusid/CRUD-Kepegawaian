<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
  session_start();
}

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasbor Aplikasi Kepegawaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>

  <body>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <h2 class="text-center mb-4">Selamat Datang di Aplikasi Kepegawaian</h2>
          <p class="text-center">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
          <nav class="navbar navbar-dark bg-dark">
            <!-- Navbar content -->
            <ul class="nav nav-pills justify-content-end">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Dasbor</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="pegawai.php">Pegawai</a>
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

          <?php
          // Koneksi ke database (pastikan Anda telah memasukkan kode koneksi yang sesuai)
          include 'koneksi.php';

          // Query untuk mengambil jumlah pegawai di berbagai kota
          $query = "SELECT p.kota, COUNT(*) as jumlah_pegawai 
          FROM penempatan p 
          JOIN pegawai pg ON p.id_penempatan = pg.id_penempatan 
          GROUP BY p.kota";
          $result = mysqli_query($koneksi, $query);

          // Mengecek apakah terdapat data pegawai di database
          if (mysqli_num_rows($result) > 0) {
          ?>
            <!-- Tabel untuk menampilkan jumlah pegawai di berbagai kota -->
            <div class="card mt-4">
              <div class="card-header bg-primary text-white">
                Jumlah Pegawai di Berbagai Kota
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Kota</th>
                      <th>Jumlah Pegawai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Menampilkan data pegawai di berbagai kota
                    while ($row = mysqli_fetch_assoc($result)) {
                      echo "<tr>";
                      echo "<td>" . $row['kota'] . "</td>";
                      echo "<td>" . $row['jumlah_pegawai'] . "</td>";
                      echo "</tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- Akhir Tabel -->
          <?php
          } else {
            echo "<p>Tidak ada data pegawai yang tersedia.</p>";
          }

          // Menutup koneksi ke database
          mysqli_close($koneksi);
          ?>



        <?php } else {
        // Jika belum login, alihkan ke laman login.php
        header("Location: login.php");
        exit(); // Pastikan tidak ada output setelah header redirect
      } ?>
        </div>
      </div>
    </div>
  </body>

  </html>