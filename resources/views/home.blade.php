<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automation Weapon Rack</title>
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="https://www.stas-rg.com">
                <img src="{{ asset('assets/img/landingpages/stas.png') }}" alt="STAS-RG Logo" style="width: 100px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex ms-auto">
                <select class="form-select me-1" aria-label="Pilih bahasa" onchange="window.location.href=`{{ url()->current() }}?lang=${this.value}`">
                    <option value="id" {{ app()->getLocale() == 'id' || request()->query('lang') == 'id' ? 'selected' : '' }}>Indonesia</option>
                    <option value="en" {{ app()->getLocale() == 'en' || request()->query('lang') == 'en' ? 'selected' : '' }}>English</option>
                </select>
                <!-- Tombol untuk membuka modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalLogin">Mulai</button>

<!-- Modal Login -->
<div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <!-- Bagian Kiri untuk Form Login -->
                <div class="col-md-6 p-5">
                    <div class="modal-header border-0">
                        <h2 class="modal-title w-100 text-center">LOGIN</h2>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <!-- Status Session -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <div class="modal-body">
                            <p class="text-center">Silahkan memasukan Email dan Password</p>

                            <!-- Email Address -->
                            <div class="mb-4">
                                <x-input-label for="email" :value="__('Email')" />
                                <input type="email" class="form-control rounded-pill" id="email" name="email" placeholder="Masukan email anda..." :value="old('email')" required autofocus autocomplete="username">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <x-input-label for="password" :value="__('Password')" />
                                <input type="password" class="form-control rounded-pill" id="password" name="password" placeholder="Masukan password anda" required autocomplete="current-password">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mt-3 mb-3 text-center">
                                <input id="remember_me" type="checkbox" class="form-check-input rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                                <label for="remember_me" class="form-check-label text-sm text-gray-600">{{ __('Remember me') }}</label>
                            </div>
                        </div>

                        <div class="modal-footer border-0 justify-content-center">
                            <button type="submit" class="btn btn-success w-100 rounded-pill">Login</button>
                        </div>

                        <!-- Forgot Password -->
                        <div class="text-center mt-3">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Bagian Kanan untuk Gambar -->
                <div class="col-md-6 d-none d-md-block p-0">
                    <img src="/path/to/image.png" alt="Image" class="img-fluid h-100">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Menampilkan pesan error login
        @if ($errors->any())
            $('#modalLogin').modal('show');
        @endif
    });
</script>


<!-- Tambahkan CSS -->
<style>
    .modal-content {
        border-radius: 15px;
    }
    .form-control {
        height: 50px;
        padding-left: 20px;
        font-size: 16px;
    }
    .btn-success {
        background-color: #2D3721;
        border-color: #2D3721;
    }
    .btn-success:hover {
        background-color: #4F6D39;
        border-color: #4F6D39;
    }
    .modal-body p {
        color: #6c757d;
    }
    .rounded-pill {
        border-radius: 50px !important;
    }
</style>

            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="tentangriset" class="hero py-5" style="background-color: #CED7E4;" >
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6">
                    <h1>RISET AUTOMATION WEAPON RACK</h1>
                    <p>Automated Weapon Storage Dashboard: Memudahkan memantau dan mengontrol akses ke senjata. Sistem ini memberikan Anda kontrol penuh atas siapa yang dapat mengakses senjata Anda, kapan saja.</p>
                </div>
                <div class="col-md-6">
                    <img src="placeholder.png" alt="Weapon Rack" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Dokumentasi Section -->
    <!-- Carousel untuk 3 Card Atas -->
    <section id="dokumentasi" class="carousel-section py-5">
        <div class="container">
            <h2 class="text-center mb-5">Dokumentasi Weapon Rack</h2>
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="doc1.png" class="card-img-top" alt="Dokumentasi 1">
                                    <div class="card-body">
                                        <p class="card-text">Deskripsi dokumentasi 1</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="doc2.png" class="card-img-top" alt="Dokumentasi 2">
                                    <div class="card-body">
                                        <p class="card-text">Deskripsi dokumentasi 2</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="doc3.png" class="card-img-top" alt="Dokumentasi 3">
                                    <div class="card-body">
                                        <p class="card-text">Deskripsi dokumentasi 3</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="doc4.png" class="card-img-top" alt="Dokumentasi 4">
                                    <div class="card-body">
                                        <p class="card-text">Deskripsi dokumentasi 4</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="doc5.png" class="card-img-top" alt="Dokumentasi 5">
                                    <div class="card-body">
                                        <p class="card-text">Deskripsi dokumentasi 5</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <img src="doc6.png" class="card-img-top" alt="Dokumentasi 6">
                                    <div class="card-body">
                                        <p class="card-text">Deskripsi dokumentasi 6</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- 3 Card untuk Video -->
    <section class="video-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Video Dokumentasi Weapon Rack</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/video1" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Video dokumentasi 1</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/video2" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Video dokumentasi 2</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/video3" allowfullscreen></iframe>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Video dokumentasi 3</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    <section id="about" class="about py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4">Tentang Kami</h2>
                    <p>Center of Excellence Sustainable Technology and Applied Sciences Research Group (CoE STAS-RG) berperan untuk melakukan Research, Consulting, Project Implementation, SCM Software Solution, Customization, Industrial Attachment & Certification, Training For Professional & Student, Seminar & Expo, Gathering & Book Review, Publikasi serta Tindak Lanjut Obyektif Ilmiah.</p>
                </div>
                <div class="col-md-6">
                    <img src="about.png" alt="Tentang Kami" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
