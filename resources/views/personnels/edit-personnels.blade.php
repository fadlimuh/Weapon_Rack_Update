<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss'])
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="{{ asset('assets/img/logo/icon-logo-website.png') }}" type="image/png">
    <style>
        /* Global Styles */
        body {
            font-family: 'PlusJakartaSans', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .d-flex {
            display: flex;
        }

        .flex-grow-1 {
            flex-grow: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar.closed {
            width: 60px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #f1f1f1;
        }

        .sidebar span {
            margin-left: 10px;
            white-space: nowrap;
            transition: opacity 0.3s ease;
        }

        .sidebar.closed span {
            opacity: 0;
        }

        /* Main Content */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .content.full {
            margin-left: 60px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #e9ecef;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
            margin-top: 0.25rem;
        }

        /* Buttons */
        .btn-primary {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
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
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
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

        <!-- Main Content -->
        <div class="content flex-grow-1" id="mainContent">
            <div class="container mt-2">
                <h2>Edit Personel</h2>
                <p>Formulir untuk mengedit data personel.</p>
                <form action="{{ route('personnels.update', $personnel->personnel_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="personnel_id">ID Personel</label>
                        <input type="text" name="personnel_id" id="personnel_id" class="form-control" value="{{ $personnel->personnel_id }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="loadCellID">ID Senjata</label>
                        <select name="loadCellID" id="loadCellID" class="form-control @error('loadCellID') is-invalid @enderror" required>
                            <option value="" disabled selected>Pilih ID Senjata</option>
                            @foreach (\App\Models\Weapons::distinct()->pluck('loadCellID') as $loadCellID)
                                <option value="{{ $loadCellID }}" {{ old('loadCellID', $personnel->loadCellID) == $loadCellID ? 'selected' : '' }}>
                                    {{ $loadCellID }}
                                </option>
                            @endforeach
                        </select>
                        @error('loadCellID')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nokartu">No Kartu</label>
                        <input type="text" name="nokartu" id="nokartu" class="form-control @error('nokartu') is-invalid @enderror" required readonly value="{{ old('nokartu', \App\Models\tmprfids::pluck('nokartu')->first()) }}">
                        @error('nokartu')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $personnel->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pangkat">Pangkat</label>
                        <input type="text" name="pangkat" id="pangkat" class="form-control @error('pangkat') is-invalid @enderror" value="{{ old('pangkat', $personnel->pangkat) }}" required>
                        @error('pangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nrp">NRP</label>
                        <input type="text" name="nrp" id="nrp" class="form-control @error('nrp') is-invalid @enderror" value="{{ old('nrp', $personnel->nrp) }}" required>
                        @error('nrp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $personnel->jabatan) }}" required>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kesatuan">Kesatuan</label>
                        <input type="text" name="kesatuan" id="kesatuan" class="form-control @error('kesatuan') is-invalid @enderror" value="{{ old('kesatuan', $personnel->kesatuan) }}" required>
                        @error('kesatuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        <a href="{{ route('personnels.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Sidebar Toggle Functionality
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            const content = document.querySelector('.content');
            sidebar.classList.toggle('closed');
            content.classList.toggle('full');
        });
    </script>
</body>
</html>
