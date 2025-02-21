<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
        <aside class="sidebar rounded-3" id="sidebar">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-home ms-2 me-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('board.index') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-clipboard-list ms-2 me-3"></i>
                <span>Papan Status Senjata</span>
            </a>
            <a href="{{ route('personnels.index') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-user ms-2 me-3"></i>
                <span>Data Personel</span>
            </a>
            <a href="{{ route('weapons.index') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-sitemap ms-2 me-3"></i>
                <span>Data Senjata</span>
            </a>
            <a href="{{ route('admin.index') }}" class="d-flex align-items-center py-2 active">
                <i class="fas fa-lock ms-2 me-3"></i>
                <span>Admin</span>
            </a>
        </aside>
        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')

            <div class="container-fluid p-1">
                <div class="container mt-2">
                    <h2>Admin Dashboard</h2>
                    <p>Tampilan data Admin</p>
                    <table class="table table-bordered table-custom">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td style="text-align: center; display: flex; justify-content: center; align-items: center; gap: 15px;">
                                    <button type="button" class="btn btn-success btn-sm" title="Edit User" style="display: flex; align-items: center;" onclick="window.location.href='{{ route('admin.edit', $user->id) }}'">
                                        <i class="fas fa-pencil-alt" style="margin-right: 5px;"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" title="Delete User" style="display: flex; align-items: center;" onclick="confirmDelete({{ $user->id }});">
                                        <i class="fas fa-trash-alt" style="margin-right: 5px;"></i> Hapus
                                    </button>
                                    <!-- Form untuk penghapusan -->
                                    <form id="delete-form-{{ $user->id }}" action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <script src="{{ asset('assets/sweetalert/package/dist/sweetalert2.min.js') }}"></script>
                                    <script>
                                        function confirmDelete(userId) {
                                            // SweetAlert Konfirmasi
                                            Swal.fire({
                                                title: 'Yakin ingin menghapus admin ini?',
                                                text: "Data tidak bisa dikembalikan setelah dihapus!",
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Ya, Hapus!',
                                                cancelButtonText: 'Batal'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Submit Form untuk Penghapusan
                                                    document.getElementById(`delete-form-${userId}`).submit();
                                                }
                                            });
                                        }
                                    </script>
                                    @if(session('success'))
                                    <script>
                                        Swal.fire({
                                            title: 'Berhasil!',
                                            text: '{{ session('success') }}',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                @endif

                                @if(session('error'))
                                    <script>
                                        Swal.fire({
                                            title: 'Gagal!',
                                            text: '{{ session('error') }}',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    </script>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('admin.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('full');
        });
    </script>
</body>
</html>
