<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senjata</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href=" {{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables/datatables.min.css') }}" rel="stylesheet>">
    <script href="{{ asset('assets/datatables/datatables.min.js') }}"></script>
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

        <!-- Main Content -->
        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')


            <div class="container-fluid p-1">
                <div class="container mt-2">
                    <h2>{{ __('messages.menu_weapons') }}</h2>
                    <p>{{ __('messages.dashboard_description') }}</p>

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <!-- Table for Weapon Data -->
                                <table class="table table-bordered mt-4" id="weaponTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">{{ __('messages.table_rack') }}</th>
                                            <th scope="col">{{ __('messages.table_load_cell_id') }}</th>
                                            <th scope="col">{{ __('messages.table_status') }}</th>
                                            <th scope="col">{{ __('messages.table_weight') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weaponTableBody">

                                    </tbody>
                                </table>
                                <script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>
                                <!-- DataTables JS -->
                                <script src="{{ asset('assets/datatables/datatables.min.js') }}" defer></script>
                                <script>
                                    $(document).ready(function () {
                                        // Inisialisasi DataTables
                                        const table = $('#weaponTable').DataTable({
                                            responsive: true,
                                            autoWidth: false,
                                            ajax: {
                                                url: "/api/weapons", // Endpoint API
                                                type: 'GET',
                                                dataSrc: function (response) {
                                                    console.log('Response API:', response); // Debugging
                                                    if (response.success && Array.isArray(response.data)) {
                                                        return response.data;
                                                    } else {
                                                        console.error('Respons API tidak valid:', response);
                                                        return [];
                                                    }
                                                }
                                            },
                                            columns: [
                                                {
                                                    data: 'rackNumber',
                                                    render: function (data, type, row, meta) {
                                                        if (meta.row === 0 || row.rackNumber !== table.row(meta.row - 1).data().rackNumber) {
                                                            const rowspan = table
                                                                .rows()
                                                                .data()
                                                                .filter(r => r.rackNumber === row.rackNumber).length;
                                                            return `<td rowspan="${rowspan}" class="align-middle">${row.rackNumber}</td>`;
                                                        }
                                                        return '';
                                                    },
                                                    className: 'align-middle',
                                                    title: '{{ __("messages.table_rack") }}'
                                                },
                                                {
                                                    data: 'loadCellID',
                                                    title: '{{ __("messages.table_load_cell_id") }}'
                                                },
                                                {
                                                    data: 'status',
                                                    render: function (data) {
                                                        if (data === 0) {
                                                            return `<span class="badge bg-danger">{{ __('messages.status_red_description') }}</span>`;
                                                        } else if (data === 1) {
                                                            return `<span class="badge bg-warning">{{ __('messages.status_yellow_description') }}</span>`;
                                                        } else if (data === 2) {
                                                            return `<span class="badge bg-success">{{ __('messages.status_green_description') }}</span>`;
                                                        }
                                                        return '';
                                                    },
                                                    title: '{{ __("messages.table_status") }}'
                                                },
                                                {
                                                    data: 'weight',
                                                    render: function (data) {
                                                        return data + ' {{ __("messages.table_weight_unit") }}';
                                                    },
                                                    className: 'align-middle',
                                                    title: '{{ __("messages.table_weight") }}'
                                                }
                                            ],
                                            language: {
                                                search: '<i class="fas fa-search"></i> {{ __("messages.datatable_search") }}',
                                                lengthMenu: "{{ __('messages.datatable_length_menu') }}",
                                                info: "{{ __('messages.datatable_info') }}",
                                                infoFiltered: "{{ __('messages.datatable_info_filtered') }}",
                                                paginate: {
                                                    first: '<i class="fas fa-step-backward"></i> {{ __("messages.datatable_first") }}',
                                                    last: '<i class="fas fa-step-forward"></i> {{ __("messages.datatable_last") }}',
                                                    next: '<i class="fas fa-chevron-right"></i> {{ __("messages.datatable_next") }}',
                                                    previous: '<i class="fas fa-chevron-left"></i> {{ __("messages.datatable_previous") }}'
                                                }
                                            },
                                            dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>t<"d-flex justify-content-between align-items-center mt-3"ip>',
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
                                                        doc.defaultStyle.fontSize = 10;
                                                        doc.styles.tableHeader.fontSize = 12;
                                                    }
                                                },
                                                {
                                                    extend: 'print',
                                                    text: '<i class="fas fa-print"></i> {{ __("messages.datatable_print") }}',
                                                    className: 'btn btn-info btn-sm',
                                                    title: '{{ __("messages.datatable_print") }}',
                                                    customize: function(win) {
                                                        $(win.document.body).css('font-size', '12px');
                                                        $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                                                    }
                                                }
                                            ],
                                            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "{{ __('messages.datatable_length_menu_all') }}"]],
                                            pageLength: 10,
                                            order: [[0, 'asc']],
                                            initComplete: function() {
                                                console.log('DataTables telah diinisialisasi dengan sukses!');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
