<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet">
    <script href="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>
        body {
            font-family: 'PlusJakartaSans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            overflow-x: hidden; /* Nonaktifkan scrollbar horizontal */
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

        .btn {
            font-size: 13px;
            padding: 5px 10px;
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
            <a href="{{ route('personnels.index') }}" class="d-flex align-items-center py-2 active">
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
            @include('components.togglebutton')

            <div class="container mt-2">
                <h2>Data Personel</h2>
                <p>Daftar lengkap data personel yang terdaftar dalam sistem.</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-2 d-flex flex-column justify-content-center">
                            <div class="card-title">Total Personel</div>
                            <div class="card-body fs-1">{{ $personnel->count() }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-2 d-flex flex-column justify-content-center">
                            <div class="card-title">Senjata Tersedia</div>
                            <div class="card-body fs-1">{{ $weapons->count() }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-2 d-flex flex-column justify-content-center">
                            <div class="card-title">Personel Aktif</div>
                            <div class="card-body fs-1">{{ $personnel->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <a href="{{ route('personnels.create') }}" class="btn btn-primary me-2" id="addPersonnelButton">
                        <i class="fas fa-plus"></i> Tambah Personel
                    </a>
                </div>

                <table class="table table-striped table-hover table-bordered align-middle" id="personnelTable" style="width: 100%; font-size: 14px;">
                    <thead class="table-white">
                        <tr>
                            <th>No</th>
                            <th>ID Senjata</th>
                            <th>ID Pengguna</th>
                            <th>Nama Pengguna</th>
                            <th>Pangkat</th>
                            <th>NRP</th>
                            <th>Jabatan</th>
                            <th>Kesatuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($personnel as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->loadCellID }}</td>
                            <td>{{ $p->personnel_id }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->pangkat }}</td>
                            <td>{{ $p->nrp }}</td>
                            <td>{{ $p->jabatan }}</td>
                            <td>{{ $p->kesatuan }}</td>
                            <td>
                                <a href="{{ route('personnels.edit', $p->personnel_id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('personnels.destroy', $p->personnel_id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DataTables JS -->
        <script src="{{ asset('assets/datatables/datatables.min.js') }}" defer></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                try {
                    // Konfigurasi DataTables
                    const tableConfig = {
                        responsive: true, // Aktifkan responsif
                        autoWidth: false, // Nonaktifkan auto width
                        language: {
                            search: '<i class="fas fa-search"></i> Cari:', // Custom placeholder untuk pencarian
                            lengthMenu: "Tampilkan _MENU_ data", // Custom teks untuk dropdown lengthMenu
                            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data", // Custom teks info
                            infoFiltered: "(disaring dari total _MAX_ data)", // Custom teks info filtered
                            paginate: {
                                first: '<i class="fas fa-step-backward"></i> Pertama', // Custom teks untuk tombol first
                                last: '<i class="fas fa-step-forward"></i> Terakhir', // Custom teks untuk tombol last
                                next: '<i class="fas fa-chevron-right"></i> Berikutnya', // Custom teks untuk tombol next
                                previous: '<i class="fas fa-chevron-left"></i> Sebelumnya' // Custom teks untuk tombol previous
                            }
                        },
                        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>t<"d-flex justify-content-between align-items-center mt-3"ip>', // Custom layout
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fas fa-copy"></i> Salin',
                                className: 'btn btn-secondary btn-sm',
                                title: 'Data Personel - Salin'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv"></i> Ekspor CSV',
                                className: 'btn btn-primary btn-sm',
                                title: 'Data Personel - CSV'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel"></i> Ekspor Excel',
                                className: 'btn btn-success btn-sm',
                                title: 'Data Personel - Excel'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fas fa-file-pdf"></i> Ekspor PDF',
                                className: 'btn btn-danger btn-sm',
                                title: 'Data Personel - PDF',
                                customize: function(doc) {
                                    doc.defaultStyle.fontSize = 10; // Ukuran font PDF
                                    doc.styles.tableHeader.fontSize = 12; // Ukuran font header tabel
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> Cetak',
                                className: 'btn btn-info btn-sm',
                                title: 'Data Personel - Cetak',
                                customize: function(win) {
                                    $(win.document.body).css('font-size', '12px'); // Ukuran font cetak
                                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                                }
                            }
                        ],
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]], // Custom dropdown lengthMenu
                        pageLength: 10, // Default jumlah data per halaman
                        order: [[0, 'asc']], // Default pengurutan berdasarkan kolom pertama (No)
                        initComplete: function() {
                            console.log('DataTables telah diinisialisasi dengan sukses!');
                        }
                    };

                    // Inisialisasi DataTables
                    $('#personnelTable').DataTable(tableConfig);
                } catch (error) {
                    console.error('Gagal menginisialisasi DataTables:', error);
                }
            });
        </script>


    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');

            sidebar.classList.toggle('closed');
            content.classList.toggle('full');
        });
    </script>
</body>
</html>
