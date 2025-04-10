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

        .card-status {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 10px;
        }
        .card-status.red {
            background-color: red;
        }
        .card-status.yellow {
            background-color: yellow;
        }
        .card-status.green {
            background-color: green;
        }
        .card-status.secondary {
            background-color: gray;
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
    @include('components.aside')

    <div class="d-flex">

        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button for Mobile -->
            @include('components.togglebutton')

            <nav style="margin-top: 10px; margin-left: 16px;" aria-label="breadcrumb mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="font-weight: bold;"><a href="{{ route('board.index') }}">Papan Status</a></li>
                </ol>
            </nav>

            <div class="container-fluid p-3" id="contentArea" style="overflow-x: hidden;">
                <h2>Status Senjata</h2>
                <div class="row">
                <!-- Kolom Kiri: Deskripsi Papan -->
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <img src="https://via.placeholder.com/200x150" class="card-img-top" alt="{{ __('board_title') }}" style="max-width: 100%;">
                            <div class="card-body">
                                <h6 class="card-title">{{ __('messages.board_title') }}</h6>
                                <p class="card-text">
                                    {{ __('messages.board_description') }}
                                    <span class="fw-bold text-danger">{{ __('messages.status_red') }}</span> {{ __('messages.status_red_description') }},
                                    <span class="fw-bold text-warning">{{ __('messages.status_yellow') }}</span> {{ __('messages.status_yellow_description') }},
                                    <span class="fw-bold text-success">{{ __('messages.status_green') }}</span> {{ __('messages.status_green_description') }}.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Data Rak -->
                    <div class="col-md-8 col-sm-12">
                        <div class="card shadow-3">
                            <div class="card-body">
                                <h6 class="card-title">Data Rak</h6>
                                <div class="table-responsive" id="racksTable">
                                    <div class="row g-3" id="rack-data">
                                        <!-- Data rak akan dimuat di sini -->
                                    </div>
                                    <script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>
                                    @include('components.papan')
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- jQuery -->
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-csOnv+IjgYjKbj4w3j/KTFlkEgo8flXMi/jYYFT/hqly9TCtrRf+vKcmybn9BjQ2" crossorigin="anonymous"></script>
</body>
</html>
