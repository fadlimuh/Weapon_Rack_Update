<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Status Senjata</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>

        body {
            font-family: 'PlusJakartaSans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            overflow-x: hidden; /* Menghindari scroll bar horizontal */
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background-color: #fff;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
        }

        /* Main Content */
        .content {
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: calc(100vw - 250px); /* Memastikan content tidak melebihi lebar viewport */
            overflow-x: hidden; /* Menghindari scroll bar horizontal */
        }

        .content.full {
            margin-left: 0;
            max-width: 100vw; /* Saat sidebar tertutup, content mengambil lebar penuh */
        }

        /* Navbar */
        .navbar {
            background-color: #fff;
            padding: 10px 20px;
            border-bottom: 1px solid #e9ecef;
            z-index: 100;
            position: sticky;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .navbar-brand {
            font-weight: bold;
            color: #28a745;
            font-size: 24px;
        }

        .navbar .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar .navbar-nav .nav-item {
            margin-left: 15px;
        }

        .navbar .navbar-nav .nav-item .nav-link {
            color: #333;
            transition: color 0.3s ease;
        }

        .navbar .navbar-nav .nav-item .nav-link:hover {
            color: #28a745;
        }

        /* Table */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 12px 16px;
            border: 1px solid #e9ecef;
            text-align: left;
        }

        .table th {
            background-color: #f7f7f7;
            font-weight: bold;
        }

        .table td {
            background-color: #fff;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Cards */
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
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
            color: #555;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }

            .content {
                margin-left: 0;
                max-width: 100vw; /* Saat di mobile, content mengambil lebar penuh */
            }

            .sidebar a {
                padding: 10px;
            }

            .navbar .navbar-brand {
                font-size: 20px;
            }

            .navbar .navbar-nav {
                flex-direction: column;
                align-items: flex-end;
            }

            .navbar .navbar-nav .nav-item {
                margin-left: 0;
                margin-bottom: 10px;
            }

            .table td, .table th {
                padding: 8px;
                font-size: 14px;
            }

            .card {
                padding: 15px;
            }

            .card-title {
                font-size: 18px;
            }

            .card-body {
                font-size: 14px;
            }

            .col-md-4, .col-md-8 {
                width: 100%;
            }

            #racks {
                height: 300px;
            }
        }

        @media (max-width: 480px) {
            .sidebar {
                width: 160px;
            }

            .sidebar a {
                padding: 8px;
                font-size: 14px;
            }

            .navbar .navbar-brand {
                font-size: 18px;
            }

            .table td, .table th {
                padding: 6px;
                font-size: 12px;
            }

            .card {
                padding: 10px;
            }

            .card-title {
                font-size: 16px;
            }

            .card-body {
                font-size: 12px;
            }
        }
        #racks {
        max-height: 250px; /* Sesuaikan tinggi untuk layar sangat kecil */
    }
    </style>
</head>
<body>
    @include('components.navbar')

    <div class="d-flex">
        <!-- Sidebar -->
        <aside class="sidebar rounded-3" id="sidebar">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-home ms-2 me-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('board.index') }}" class="d-flex align-items-center py-2 active">
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
            <!-- Sidebar Toggle Button for Mobile -->
            @include('components.togglebutton')

            <div class="container-fluid p-3" id="contentArea" style="overflow-x: hidden;">
                <h2>Status Senjata</h2>
                <div class="row">
                    <!-- Kolom Kiri: Deskripsi Papan -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="Tampilan Papan" style="max-width: 100%;">
                            <div class="card-body">
                                <h6 class="card-title">Tampilan Papan</h6>
                                <p class="card-text">
                                    Papan ini berfungsi untuk menampilkan status pada rak senjata. Bila statusnya <span style="color: red">merah</span> menunjukkan senjata tidak tersedia, jika berwarna <span style="color: yellow">kuning</span> menunjukkan senjatanya tersedia tetapi magazine nya tidak ada dan jika berwarna <span style="color: green">hijau</span> maka statusnya menunjukkan senjata tersedia dan magazine nya ada.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Daftar Rak Senjata -->
                    <div class="col-md-8">
                        <div class="border p-3" id="racks" style="height: 400px; overflow-y: auto; overflow-x: hidden;">
                            <!-- Racks akan dimasukkan secara dinamis di sini -->
                        </div>
                        <script>
                            $(document).ready(function() {
                                $.ajax({
                                    url: "", // Ganti dengan URL endpoint yang sesuai
                                    type: 'GET',
                                    success: function(response) {
                                        let racks = '<div class="row" style="gap: 10px; flex-wrap: wrap;">'; // Gunakan flexbox untuk layout yang lebih fleksibel
                                        response.forEach(weapon => {
                                            racks += `
                                                <div class="col-md-4 col-sm-6 mb-3" style="flex: 1 1 calc(33.333% - 20px);"> <!-- Sesuaikan lebar kartu -->
                                                    <div class="card h-100">
                                                        <div class="card-body text-center">
                                                            <h6 class="card-title">Rak ${weapon.rack}</h6>
                                                            <div class="d-flex justify-content-center">
                                            `;
                                            for (let i = 1; i <= 3; i++) {
                                                racks += `
                                                    <div class="rounded-circle bg-${weapon.magazine == i ? 'success' : 'secondary'} text-white d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; margin: 5px; ${weapon.magazine == i ? 'box-shadow: 0 0 10px 2px green;' : ''}">
                                                        ${weapon.magazine == i ? '<i class="fas fa-check"></i>' : ''}
                                                    </div>
                                                `;
                                            }
                                            racks += `
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                        racks += '</div>'; // Tutup row
                                        $('#racks').html(racks); // Masukkan konten ke dalam #racks
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("AJAX Error: ", status, error); // Handle error jika AJAX gagal
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const contentArea = document.getElementById('contentArea');

            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('full');
            contentArea.style.width = sidebar.classList.contains('closed') ? '100%' : 'calc(100vw - 250px)';
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-csOnv+IjgYjKbj4w3j/KTFlkEgo8flXMi/jYYFT/hqly9TCtrRf+vKcmybn9BjQ2" crossorigin="anonymous"></script>
</body>
</html>
