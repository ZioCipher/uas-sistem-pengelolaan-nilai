<?php 
// Memulai session PHP untuk menyimpan tanda login
session_start();

// Memanggil file koneksi database
include "koneksi.php"; 

// Variabel untuk menyimpan pesan error jika login gagal
$error_message = "";

// Memeriksa apakah tombol submit login sudah ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form input dan mengamankannya dari injeksi SQL
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Query untuk mencari user di database (Asumsi nama tabel adalah 'users' atau 'user')
    // Silakan ganti nama tabel 'users' di bawah jika nama tabel di database dosen berbeda
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    // Memeriksa apakah data ditemukan
    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        
        // Menyimpan tanda login ke dalam session
        $_SESSION['login'] = true;
        $_SESSION['username'] = $user_data['username'];
        
        // Login sukses, langsung lempar ke halaman dashboard.php
        header("Location: dashboard.php");
        exit;
    } else {
        // Jika tidak ditemukan, simpan pesan error
        $error_message = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Sistem Pengelolaan Nilai Mata Kuliah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">

    <div class="container">
        <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-lg-9">
                <div class="card login-card">
                    <div class="row g-0">
                        <div class="col-lg-6 login-brand d-flex flex-column justify-content-center">
                            <h1>Sistem Nilai Mata Kuliah</h1>
                        </div>

                        <div class="col-lg-6 bg-white p-5">
                            <div class="mb-4">
                                <h3 class="fw-bold">Login Pengguna</h3>
                                <p class="text-muted mb-0">Masukkan username dan password untuk masuk.</p>
                            </div>

                            <!-- Menampilkan pesan error jika login gagal -->
                            <?php if (!empty($error_message)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error_message; ?>
                                </div>
                            <?php endif; ?>

                            <!-- Method diganti ke POST, Action diarahkan ke file ini sendiri -->
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <!-- Menambahkan atribut name="username" -->
                                    <input type="text" name="username" class="form-control" placeholder="Contoh: admin" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <!-- Menambahkan atribut name="password" -->
                                    <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Ingat saya
                                        </label>
                                    </div>
                                    <a href="#" class="text-decoration-none">Lupa password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    Masuk Dashboard
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <p class="text-center text-white mt-4">
                    &copy; 2026 Sistem Pengelolaan Nilai Mata Kuliah
                </p>
            </div>
        </div>
    </div>

</body>
</html>