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
    @include('components.aside')

        <div class="content flex-grow-1" id="mainContent">
            @include('components.togglebutton')

            <div class="container mt-2">
                <h2>{{ __('messages.personnel_title') }}</h2>
                <p>{{ __('messages.personnel_description') }}</p>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-2 d-flex flex-column justify-content-center">
                            <div class="card-title">{{ __('messages.personnel_total') }}</div>
                            <div class="card-body fs-1">{{ $personnel->count() }}</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-2 d-flex flex-column justify-content-center">
                            <div class="card-title">{{ __('messages.personnel_active') }}</div>
                            <div class="card-body fs-1">{{ $personnel->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <a href="{{ route('personnels.create') }}" class="btn btn-primary me-2" id="addPersonnelButton">
                        <i class="fas fa-plus"></i> {{ __('messages.personnel_add') }}
                    </a>
                </div>

                <table class="table table-striped table-hover table-bordered align-middle" id="personnelTable" style="width: 100%; font-size: 14px;">
                    <thead class="table-white">
                        <tr>
                            <th>{{ __('messages.table_no') }}</th>
                            <th>{{ __('messages.table_weapon_id') }}</th>
                            <th>{{ __('messages.table_user_id') }}</th>
                            <th>{{ __('messages.table_user_name') }}</th>
                            <th>{{ __('messages.table_rank') }}</th>
                            <th>{{ __('messages.table_nrp') }}</th>
                            <th>{{ __('messages.table_position') }}</th>
                            <th>{{ __('messages.table_unit') }}</th>
                            <th>{{ __('messages.table_action') }}</th>
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
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('{{ __('messages.Are you sure you want to delete this data?') }}')">
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
                            search: '<i class="fas fa-search"></i> {{ __("messages.datatable_search") }}', // Custom placeholder untuk pencarian
                            lengthMenu: "{{ __('messages.datatable_length_menu') }}", // Custom teks untuk dropdown lengthMenu
                            info: "{{ __('messages.datatable_info') }}", // Custom teks info
                            infoFiltered: "{{ __('messages.datatable_info_filtered') }}", // Custom teks info filtered
                            paginate: {
                                first: "{{ __('messages.datatable_first') }}", // Custom teks untuk tombol first
                                last: "{{ __('messages.datatable_last') }}", // Custom teks untuk tombol last
                                next: "{{ __('messages.datatable_next') }}", // Custom teks untuk tombol next
                                previous: "{{ __('messages.datatable_previous') }}" // Custom teks untuk tombol previous
                            }
                        },
                        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>t<"d-flex justify-content-between align-items-center mt-3"ip>', // Custom layout
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="fas fa-copy"></i> {{ __("messages.datatable_copy") }}',
                                className: 'btn btn-secondary btn-sm',
                                title: '{{ __("messages.datatable_copy") }}'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="fas fa-file-csv"></i> {{ __("messages.datatable_csv") }}',
                                className: 'btn btn-primary btn-sm',
                                title: '{{ __("messages.datatable_csv") }}'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="fas fa-file-excel"></i> {{ __("messages.datatable_excel") }}',
                                className: 'btn btn-success btn-sm',
                                title: '{{ __("messages.datatable_excel") }}'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="fas fa-file-pdf"></i> {{ __("messages.datatable_pdf") }}',
                                className: 'btn btn-danger btn-sm',
                                title: '{{ __("messages.datatable_pdf") }}',
                                customize: function(doc) {
                                    doc.defaultStyle.fontSize = 10; // Ukuran font PDF
                                    doc.styles.tableHeader.fontSize = 12; // Ukuran font header tabel
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> {{ __("messages.datatable_print") }}',
                                className: 'btn btn-info btn-sm',
                                title: '{{ __("messages.datatable_print") }}',
                                customize: function(win) {
                                    $(win.document.body).css('font-size', '12px'); // Ukuran font cetak
                                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                                }
                            }
                        ],
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "{{ __('messages.datatable_length_menu') }}"]], // Custom dropdown lengthMenu
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
</body>
</html>
