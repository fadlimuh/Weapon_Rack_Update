<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/package/dist/sweetalert2.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>
        body {
            font-family: 'PlusJakartaSans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            z-index: 1000;
            width: 250px;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .sidebar a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        .content {
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .content.full {
            margin-left: 0;
        }

        .navbar {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #e9ecef;
            z-index: 100;
            position: sticky;
            top: 0;
        }

        .navbar .navbar-brand {
            font-weight: bold;
            color: #28a745;
        }

        .navbar .navbar-nav .nav-item .nav-link {
            color: #333;
        }

        .navbar .navbar-nav .nav-item .nav-link:hover {
            color: #28a745;
        }

        .table th,
        .table td {
            padding: 0.5rem;
            vertical-align: middle;
            border: 1px solid #dee2e6;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 0;
            }

            .sidebar a {
                padding: 10px;
            }

            .navbar .navbar-brand {
                font-size: 16px;
            }

            .table td, .table th {
                padding: 8px;
                font-size: 14px;
            }
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
        }

        .card-body {
            font-size: 16px;
        }
    </style>
</head>
<body>
    @include('components.navbar')
    <div class="d-flex">
        <!-- Sidebar -->
        @include('components.aside')

        <!-- Main Content -->
        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')

            <nav aria-label="breadcrumb" class="mt-2 ms-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color: black;">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" style="color: black;">Admin</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.create') }}" style="color: black;"><strong>Create Admin</strong></a></li>
                </ol>
            </nav>

            <div class="container-fluid p-1">
                <div class="container mt-2">
                    <h2>{{ __('messages.create_admin_title') }}</h2>
                    <p>{{ __('messages.create_admin_description') }}</p>

                    <!-- Menampilkan pesan sukses atau error -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.store') }}" method="POST" id="form-create-admin">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('messages.form_name') }}</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('messages.form_email') }}</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('messages.form_password') }}</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('messages.form_password_confirmation') }}</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('messages.form_submit') }}</button>
                    </form>

                    <script src="{{ asset('assets/sweetalert/package/dist/sweetalert2.min.js') }}"></script>

                    <script>
                        const form = document.getElementById('form-create-admin');
                        form.addEventListener('submit', function(event) {
                            event.preventDefault(); // Mencegah pengiriman form default

                            const formData = new FormData(form); // Ambil data form
                            fetch(form.action, {
                                method: form.method, // Method POST
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF Token Laravel
                                    'Accept': 'application/json'
                                },
                                body: formData
                            })
                            .then(response => response.json()) // Parsing respons ke JSON
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        title: '<strong>Berhasil!</strong>',
                                        html: `Admin <b>${data.admin_name || 'baru'}</b> berhasil ditambahkan.`,
                                        icon: 'success',
                                        confirmButtonText: '<i class="fas fa-check"></i> OK',
                                        buttonsStyling: true,
                                        customClass: {
                                            confirmButton: 'btn btn-success' // Gunakan Bootstrap styling untuk tombol
                                        }
                                    }).then(() => {
                                        window.location.href = "{{ route('admin.index') }}"; // Redirect ke halaman index admin
                                    });
                                } else {
                                    Swal.fire({
                                        title: '<strong>Gagal!</strong>',
                                        html: data.message || 'Terjadi kesalahan saat menyimpan data.',
                                        icon: 'error',
                                        confirmButtonText: '<i class="fas fa-times"></i> OK',
                                        buttonsStyling: true,
                                        customClass: {
                                            confirmButton: 'btn btn-danger' // Gunakan Bootstrap styling untuk tombol
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error(error);
                                Swal.fire({
                                    title: '<strong>Error!</strong>',
                                    html: 'Terjadi kesalahan jaringan atau server.',
                                    icon: 'error',
                                    confirmButtonText: '<i class="fas fa-exclamation-circle"></i> OK',
                                    buttonsStyling: true,
                                    customClass: {
                                        confirmButton: 'btn btn-warning' // Gunakan Bootstrap styling untuk tombol
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-csOnv+IjgYjKbj4w3j/KTFlkEgo8flXMi/jYYFT/hqly9TCtrRf+vKcmybn9BjQ2" crossorigin="anonymous"></script>
</body>
</html>
