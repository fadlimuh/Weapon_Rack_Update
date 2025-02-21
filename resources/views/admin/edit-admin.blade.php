<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/sweetalert/package/dist/sweetalert2.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>
        body {
            font-family: 'PlusJakartaSans';
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: width 0.3s;
        }
        .sidebar.closed {
            width: 0;
            overflow: hidden;
        }
        .sidebar a {
            color: #333;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
        }
        .sidebar .active {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .content {
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            transition: margin-left 0.3s;
        }
        .content.full {
            margin-left: 0;
        }
        .navbar {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #e9ecef;
        }
        .navbar .navbar-brand {
            font-weight: bold;
            color: #28a745;
        }
        .navbar .navbar-brand span {
            color: #333;
        }
        .navbar .navbar-nav .nav-item .nav-link {
            color: #333;
        }
        .navbar .navbar-nav .nav-item .nav-link:hover {
            color: #28a745;
        }
        .navbar .navbar-nav .nav-item .nav-link .fa-bell {
            margin-right: 5px;
        }
        .navbar .navbar-nav .nav-item .nav-link .fa-caret-down {
            margin-left: 5px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <header style="background-color: #fff;">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/logo.png" alt="STAS-RG Logo" width="100" class="rounded-circle">
                </a>
                <!-- Spacing between logo and profile -->
                <div class="ms-auto d-flex align-items-center">
                    <div class="dropdown me-4">
                        <a class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2" style="font-size: 32px;"></i>
                            <strong>{{ Auth::user()->name }}</strong>
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser1">
                            <li><a class="dropdown-item" href="#">Need Help</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Sign out</a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <div class="d-flex">
        <aside class="sidebar bg-light rounded-3" id="sidebar">
            <style>
                a {
                    display: flex; /* Gunakan flexbox untuk meratakan item */
                    align-items: center; /* Ratakan item secara vertikal */
                    text-decoration: none; /* Menghilangkan garis bawah */
                    padding: 10px; /* Jarak antara teks dan ikon */
                    color: #28a745; /* Warna teks */
                }

                a i {
                    margin-right: 10px; /* Memberi jarak antara ikon dan teks */
                    font-size: 20px; /* Ukuran ikon */
                }

                a.active {
                    font-weight: bold; /* Menebalkan teks tautan aktif */
                    color: #28a745; /* Warna teks untuk tautan aktif */
                }

                a:hover {
                    background-color: #f0f0f0; /* Efek hover */
                }
            </style>

            <a href="{{ route('dashboard') }}"><i class="fas fa-home me-2"></i>Dashboard</a>
            <a href="{{ route('board.index') }}" ><i class="fas fa-clipboard-list me-2"></i>Papan Status Senjata</a>
            <a href="{{ route('personnels.index') }}"><i class="fas fa-user me-2"></i>Data Personel</a>
            <a href="{{ route('weapons.index') }}" ><i class="fas fa-sitemap me-2"></i>Data Senjata</a>
            <a href="{{ route('admin.index') }}" class="active"><i class="fas fa-lock me-2"></i>Admin</a>

        </aside>
        <div class="content flex-grow-1" id="mainContent">

            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')

        <!-- Script for Sidebar Toggle -->
        <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar'); // Sesuaikan ID sidebar yang ingin di-toggle
                sidebar.classList.toggle('active'); // Menambah atau menghapus kelas 'active' untuk menampilkan atau menyembunyikan sidebar
            });
        </script>

            <div class="container-fluid p-2">
            <div class="container">
              <h2>Edit Admin</h2>
              <p>Formulir untuk mengedit Admin</p>

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

              <form action="{{ route('admin.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Pengguna</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

            <script href="{{ asset('assets/sweetalert/package/dist/sweetalert2.min.js') }}"></script>
            <script>
                document.querySelector('form').addEventListener('submit', function (e) {
                    e.preventDefault(); // Mencegah submit default
                    const form = this;

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data pengguna akan diperbarui.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, update!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire(
                                'Berhasil!',
                                'Data pengguna telah diperbarui.',
                                'success'
                            );
                        }
                    });
                });

                @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
            </script>
            @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggleButton = document.getElementById("sidebarToggle");
            const sidebar = document.getElementById("sidebar");

            // Event Listener untuk Toggle Button
            toggleButton.addEventListener("click", function () {
                if (sidebar.classList.contains("collapsed")) {
                    expandSidebar();
                } else {
                    collapseSidebar();
                }
            });

            // Fungsi untuk memperluas Sidebar
            function expandSidebar() {
                sidebar.classList.remove("collapsed");
                sidebar.style.width = "250px";  // Sesuaikan ukuran sidebar
                sidebar.style.transition = "width 0.3s ease";
            }

            // Fungsi untuk menyembunyikan Sidebar
            function collapseSidebar() {
                sidebar.style.width = "0";
                sidebar.style.transition = "width 0.3s ease";
                setTimeout(function () {
                    sidebar.classList.add("collapsed");
                }, 300);  // Waktu disesuaikan dengan durasi transisi
            }
        });
    </>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-csOnv+IjgYjKbj4w3j/KTFlkEgo8flXMi/jYYFT/hqly9TCtrRf+vKcmybn9BjQ2" crossorigin="anonymous"></script>
</body>
</html>

