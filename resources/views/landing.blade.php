<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Penggajian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); min-height: 100vh; }
        .feature-icon { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- Navbar --}}
    <nav class="navbar navbar-dark">
        <div class="container">
            <span class="navbar-brand fw-bold">
                <i class="bi bi-cash-coin me-2"></i>Generate Penggajian
            </span>
            <div class="d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-light btn-sm text-primary fw-semibold">Register</a>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <main class="flex-grow-1 d-flex align-items-center">
        <div class="container py-5">
            <div class="row align-items-center">

                <div class="col-lg-6 text-white mb-5 mb-lg-0">
                    <h1 class="display-5 fw-bold mb-3">
                        Sistem Manajemen<br>Penggajian Karyawan
                    </h1>
                    <p class="lead opacity-75 mb-4">
                        Kelola data karyawan, jabatan, dan departemen dengan mudah.
                        Hitung gaji secara otomatis termasuk kehadiran, lembur, cuti, dan perjalanan dinas.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg text-primary fw-semibold px-4">
                            <i class="bi bi-person-plus me-2"></i>Mulai Sekarang
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login
                        </a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card border-0 rounded-4 shadow h-100 p-3">
                                <div class="feature-icon bg-primary bg-opacity-10 text-primary mb-3">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <h6 class="fw-bold">Data Karyawan</h6>
                                <small class="text-muted">Kelola seluruh data karyawan perusahaan dengan lengkap.</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 rounded-4 shadow h-100 p-3">
                                <div class="feature-icon bg-success bg-opacity-10 text-success mb-3">
                                    <i class="bi bi-briefcase-fill"></i>
                                </div>
                                <h6 class="fw-bold">Jabatan & Departemen</h6>
                                <small class="text-muted">Atur struktur organisasi dan jabatan secara terstruktur.</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 rounded-4 shadow h-100 p-3">
                                <div class="feature-icon bg-warning bg-opacity-10 text-warning mb-3">
                                    <i class="bi bi-calculator-fill"></i>
                                </div>
                                <h6 class="fw-bold">Hitung Gaji Otomatis</h6>
                                <small class="text-muted">Kalkulasi gaji kehadiran, lembur, dinas, dan potongan cuti.</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 rounded-4 shadow h-100 p-3">
                                <div class="feature-icon bg-danger bg-opacity-10 text-danger mb-3">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </div>
                                <h6 class="fw-bold">Akses Terproteksi</h6>
                                <small class="text-muted">Sistem role admin & user untuk keamanan data.</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="text-center text-white opacity-50 py-3 small">
        &copy; {{ date('Y') }} Generate Penggajian
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
