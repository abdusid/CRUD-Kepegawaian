<?php
// Mulai sesi jika belum dimulai
if (!isset($_SESSION)) {
    session_start();
}

// Sambungkan ke database (kode ini dapat digunakan secara terpusat dengan register.php)
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (isset($_SESSION['username'])) {
    // Jika sudah login, redirect ke laman home
    header("Location: index.php");
    exit();
}

// Cek apakah form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simpan data yang diinputkan pengguna
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data pengguna dari database
    $sql = "SELECT * FROM pengguna WHERE username='$username'";
    $result = mysqli_query($koneksi, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Jika username dan password benar, set session dan redirect ke laman home
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit();
        } else {
            // Jika password salah, tampilkan pesan error
            $error_message = "Password salah.";
        }
    } else {
        // Jika username tidak ditemukan, tampilkan pesan error
        $error_message = "Username tidak ditemukan.";
    }
}



mysqli_close($koneksi);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Kepegawaian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <style>
        /* Gaya untuk form login dan pendaftaran */
        .form-container {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-login,
        .btn-register {
            width: 100%;
        }

        /* Gaya untuk judul */
        .page-title {
            text-align: center;
            margin-bottom: 30px;
        }

        /* Gaya untuk tombol registrasi */
        .btn-register {
            margin-top: 15px;
        }

        /* Gaya untuk alert error */
        .alert-danger {
            margin-bottom: 20px;
        }

        /* Gaya untuk tautan "Belum punya akun?" */
        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        /* Gaya untuk footer */
        .footer {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center mb-4">Login - Aplikasi Kepegawaian</h2>
                <?php if (isset($error_message)) echo '<div class="alert alert-danger">' . $error_message . '</div>'; ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary mb-3" name="login">Login</button>
                </form>
                <p class="mt-3">Belum punya akun?</p>
                <!-- Button trigger modal Tambah-->
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#registerModal">
                    Register
                </button>

                <!-- Awal Modal Hapus-->
                <!-- Bisa dibesarkan tambah modal lg di class -->
                <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Register</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="register.php" method="post">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" class="form-control" id="usernamereg" name="usernamereg" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="passwordreg" name="passwordreg" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="register">Register</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Akhir Modal Hapus -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>