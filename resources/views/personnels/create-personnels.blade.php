<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Personel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>
        body {
            font-family: 'PlusJakartaSans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .content {
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #e9ecef;
            width: 100%;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        .btn-primary {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-primary:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .text-danger {
            color: #dc3545; /* Warna merah */
            font-size: 0.875rem; /* Ukuran font kecil */
            margin-top: 0.25rem; /* Jarak dari input */
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
            <div class="container mt-2">
                <h2>Tambah Personel</h2>
                <p>Formulir untuk menambahkan data personel baru.</p>

                <form action="{{ route('personnels.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="personnel_id">ID Personel</label>
                        <input type="text" name="personnel_id" id="personnel_id" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="loadCellID">ID Senjata</label>
                        <select name="loadCellID" id="loadCellID" class="form-control" required>
                            <option value="" disabled selected>Pilih ID Senjata</option>
                            @foreach (\App\Models\Weapons::distinct()->pluck('loadCellID') as $loadCellID)
                                <option value="{{ $loadCellID }}">{{ $loadCellID }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nokartu">No Kartu</label>
                        @php
                            $nokartu = \App\Models\Tmprfids::pluck('nokartu')->first();
                        @endphp

                        @if ($nokartu)
                            <input type="text" name="nokartu" id="nokartu" class="form-control" required readonly value="{{ old('nokartu', $nokartu) }}">
                        @else
                            <input type="text" name="nokartu" id="nokartu" class="form-control" required readonly value="Tidak ada data RFID yang terbaca">
                            <small class="text-danger">Silakan tempelkan kartu RFID Anda.</small>
                        @endif
                    </div>

                    <script>
                        $(document).ready(function () {
                            $.ajax({
                                url: "{{ url('api/tmprfids') }}",
                                method: 'GET',
                                success: function (response) {
                                    $('#nokartu').val(response);
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error: ", status, error);
                                }
                            });
                        });
                    </script>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pangkat">Pangkat</label>
                        <input type="text" name="pangkat" id="pangkat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nrp">NRP</label>
                        <input type="text" name="nrp" id="nrp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="kesatuan">Kesatuan</label>
                        <input type="text" name="kesatuan" id="kesatuan" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('personnels.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
