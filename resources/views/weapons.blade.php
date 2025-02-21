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
    <div class="d-flex">
        <!-- Sidebar -->
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
            <a href="{{ route('weapons.index') }}" class="d-flex align-items-center py-2 active">
                <i class="fas fa-sitemap ms-2 me-3"></i>
                <span>Data Senjata</span>
            </a>
            <a href="{{ route('admin.index') }}" class="d-flex align-items-center py-2">
                <i class="fas fa-lock ms-2 me-3"></i>
                <span>Admin</span>
            </a>
        </aside>

        <!-- Main Content -->
        <div class="content flex-grow-1" id="mainContent">
            <!-- Sidebar Toggle Button -->
            @include('components.togglebutton')

            <div class="container-fluid p-1">
                <div class="container mt-2">
                    <h2>Data Senjata</h2>
                    <p>Tampilan data Senjata</p>

                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <!-- Table for Weapon Data -->
                                <table class="table table-bordered mt-4" id="weaponTable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Rak</th>
                                            <th scope="col">Load Cell ID</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Berat</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weaponTableBody">

                                    </tbody>
                                </table>
                                <script src="{{ asset('assets/jquery/jquery-3.7.1.min.js') }}"></script>
                                <script>
                                    $(document).ready(function () {
                                        $.ajax({
                                            url: "api/weapons", // Endpoint API
                                            type: 'GET',
                                            dataType: 'json',
                                            success: function (response) {
                                                // Pastikan respons memiliki properti 'success' dan 'data'
                                                if (response.success && Array.isArray(response.data)) {
                                                    // Kelompokkan data berdasarkan rackNumber
                                                    const groupedData = {};
                                                    response.data.forEach(weapon => {
                                                        const rackNumber = weapon.rackNumber;
                                                        if (!groupedData[rackNumber]) {
                                                            groupedData[rackNumber] = [];
                                                        }
                                                        groupedData[rackNumber].push(weapon);
                                                    });

                                                    // Buat baris tabel untuk setiap rak
                                                    let tr = '';
                                                    for (const [rackNumber, weapons] of Object.entries(groupedData)) {
                                                        tr += `
                                                            <tr>
                                                                <td>${rackNumber}</td>
                                                                <td>
                                                                    <ul class="list-unstyled">
                                                                        ${weapons.map((weapon, index) => `<li>${index + 1}</li>`).join('')}
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <ul class="list-unstyled">
                                                                        ${weapons.map(weapon => `
                                                                            <li>
                                                                                ${weapon.status === 0 ? '<span class="badge rounded-pill bg-danger">Tidak Tersedia</span>' : ''}
                                                                                ${weapon.status === 1 ? '<span class="badge rounded-pill bg-warning">Tersedia (Tidak ada Magazine)</span>' : ''}
                                                                                ${weapon.status === 2 ? '<span class="badge rounded-pill bg-success">Tersedia (Ada Magazine)</span>' : ''}
                                                                            </li>
                                                                        `).join('')}
                                                                    </ul>
                                                                </td>
                                                                <td>
                                                                    <ul class="list-unstyled">
                                                                        ${weapons.map(weapon => `<li>${weapon.weight} kg</li>`).join('')}
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        `;
                                                    }
                                                    $('#weaponTableBody').html(tr); // Update isi tabel
                                                } else {
                                                    console.error('Respons API tidak valid:', response);
                                                }
                                            },
                                            error: function (xhr, status, error) {
                                                console.error('Error saat mengambil data senjata:', error);
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

        <!-- DataTables JS -->
        <script src="{{ asset('assets/datatables/datatables.min.js') }}" defer></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                try {
                    // Konfigurasi DataTables
                    const tableConfig = {
                        responsive: true,
                        autoWidth: false,
                        language: {
                            search: '<i class="fas fa-search"></i> Cari:',
                            lengthMenu: "Tampilkan _MENU_ data",
                            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                            infoFiltered: "(disaring dari total _MAX_ data)",
                            paginate: {
                                first: '<i class="fas fa-step-backward"></i> Pertama',
                                last: '<i class="fas fa-step-forward"></i> Terakhir',
                                next: '<i class="fas fa-chevron-right"></i> Berikutnya',
                                previous: '<i class="fas fa-chevron-left"></i> Sebelumnya'
                            }
                        },
                        dom: '<"d-flex justify-content-between align-items-center mb-3"Bf>t<"d-flex justify-content-between align-items-center mt-3"ip>',
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
                                    doc.defaultStyle.fontSize = 10;
                                    doc.styles.tableHeader.fontSize = 12;
                                }
                            },
                            {
                                extend: 'print',
                                text: '<i class="fas fa-print"></i> Cetak',
                                className: 'btn btn-info btn-sm',
                                title: 'Data Personel - Cetak',
                                customize: function(win) {
                                    $(win.document.body).css('font-size', '12px');
                                    $(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
                                }
                            }
                        ],
                        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
                        pageLength: 10,
                        order: [[0, 'asc']],
                        initComplete: function() {
                            console.log('DataTables telah diinisialisasi dengan sukses!');
                        }
                    };

                    // Inisialisasi DataTables
                    $('#weaponTable').DataTable(tableConfig);
                } catch (error) {
                    console.error('Gagal menginisialisasi DataTables:', error);
                }
            });
        </script>

        <!-- Sidebar Toggle Script -->
        <script>
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('mainContent');

            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('closed');
                content.classList.toggle('full');
            });
        </script>

</body>
</html>
