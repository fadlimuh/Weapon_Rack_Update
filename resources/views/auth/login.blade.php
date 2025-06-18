<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAS-RG</title>
    <link rel="icon" href="{{ asset('assets/img/stas-logo.png') }}" type="image/png" sizes="16x16">
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .row {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .col-md-6 {
            background-color: #fff;
        }

        .col-md-6 img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .text-gray-600:hover {
            color: #000;
        }
    </style>
</head>

<div class="container">
    <div class="row g-0 w-100">
        <!-- Bagian Kiri untuk Form Login -->
        <div class="col-md-6 p-5">
            <div class="text-center mb-4">
                <h2 class="modal-title w-100">LOGIN</h2>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Status Session -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="mb-4">
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

                <div class="text-center mb-3">
                    <button type="submit" class="btn btn-success w-100 rounded-pill">Login</button>
                </div>

                <!-- Forgot Password -->
                <div class="text-center">
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
            <img src="{{ asset('assets/img/landingpages/rack v3 landing page.jpg') }}" alt="Image" class="img-fluid">
        </div>
    </div>
</div>
