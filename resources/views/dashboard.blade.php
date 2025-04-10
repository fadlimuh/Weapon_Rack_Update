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
    @include('components.aside')

    <div class="d-flex">

        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')

            <!-- Content -->
            <div class="container mt-4">
                <h2>{{ __('messages.dashboard_title') }}</h2>
                <p>{{ __('messages.dashboard_description') }}</p>

                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.total_weapons') }}</h5>
                                <p>{{ $statuses->pluck('loadCellID')->unique()->count() }} Loadcell</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.active_personnel') }}</h5>
                                <p>{{ $statuses->pluck('personnel_id')->count() }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('messages.latest_status') }}</h5>
                                <p>{{ $statuses->where('time_out', null)->count() }} {{ __('messages.active_weapons') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel untuk menampilkan data status -->
                <div class="table-responsive mt-4">
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>{{ __('messages.table_no') }}</th>
                                <th>{{ __('messages.table_weapon_id') }}</th>
                                <th>{{ __('messages.table_user_name') }}</th>
                                <th>{{ __('messages.table_date') }}</th>
                                <th>{{ __('messages.table_time_in') }}</th>
                                <th>{{ __('messages.table_time_out') }}</th>
                                <th>{{ __('messages.table_duration') }}</th>
                                <th>{{ __('messages.table_status') }}</th>
                            </tr>
                        </thead>
                        <tbody id="statusTableBody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>

            <script>
                // Fetch data from API and populate the dashboard
                fetch('/api/dashboard')
                    .then(response => response.json())
                    .then(data => {
                        const tableBody = document.getElementById('statusTableBody');
                        data.forEach((status, index) => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${index + 1}</td>
                                <td>${status.loadCellID}</td>
                                <td>${status.personnel ? status.personnel.nama : 'N/A'}</td>
                                <td>${status.tanggal}</td>
                                <td>${status.time_in}</td>
                                <td>${status.time_out ?? '{{ __('messages.status_active') }}'}</td>
                                <td>${status.time_out ? Math.abs(new Date(status.time_out) - new Date(status.time_in)) / 60000 : 'N/A'}</td>
                                <td>
                                    ${status.time_out ? '<span class="badge bg-success">{{ __('messages.status_completed') }}</span>' : '<span class="badge bg-warning">{{ __('messages.status_active') }}</span>'}
                                </td>
                            `;
                            tableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error fetching data:', error));
            </script>
</body>
</html>
