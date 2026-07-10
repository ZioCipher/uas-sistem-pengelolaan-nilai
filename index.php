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

                            <form action="dashboard.html" method="get">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" placeholder="Contoh: admin" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Masukkan password" required>
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