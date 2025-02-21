<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}">
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>
        /* CSS Anda tetap dipertahankan */
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

        .table {
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px 16px;
            border: 1px solid #e9ecef;
        }

        .table th {
            background-color: #f7f7f7;
            text-align: left;
        }

        .table td {
            background-color: #fff;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

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
            margin-bottom: 10px;
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-body {
            font-size: 16px;
            color: #000000;
            flex-grow: 1;
        }
    </style>
</head>
<body>
    @include('components.navbar')

    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar rounded-3" id="sidebar">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center py-2 active">
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
            <a href="{{ route('admin.index') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-lock ms-2 me-3"></i>
                <span>Admin</span>
            </a>
        </aside>

        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')
            <div class="container mt-4">
                <h2>Dashboard</h2>
                <p>Tampilan dashboard Senjata</p>

                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Total Senjata</h5>
                                <p>{{ $statuses->count() }} Senjata</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Personel Aktif</h5>
                                <p>{{ $statuses->unique('loadCellID')->count() }} Personel</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Status Terbaru</h5>
                                <p>{{ $statuses->where('time_out', null)->count() }} Senjata aktif</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel untuk menampilkan data status -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Senjata</th>
                                <th>Nama Pengguna</th>
                                <th>Tanggal</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statuses as $index => $status)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $status->loadCellID }}</td>
                                <td>{{ $status->personnel->nama_personel ?? 'N/A' }}</td>
                                <td>{{ $status->tanggal }}</td>
                                <td>{{ $status->time_in }}</td>
                                <td>{{ $status->time_out ?? 'Masih aktif' }}</td>
                                <td>{{ $status->duration ?? 'N/A' }}</td>
                                <td>
                                    @if ($status->time_out)
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById("sidebarToggle").onclick = function() {
            document.getElementById("sidebar").classList.toggle("closed");
            document.getElementById("mainContent").classList.toggle("full");
        };

        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.getElementById("sidebar").classList.toggle("open");
        });
    </script>
</body>
</html>
