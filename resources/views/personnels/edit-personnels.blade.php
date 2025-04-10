<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Personel</title>
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
    @include('components.aside')

    <div class="content flex-grow-1" id="mainContent">
        @include('components.togglebutton')

        <div class="container mt-2">
            <h2>{{ __('messages.edit_personnel_title') }}</h2>
            <p>{{ __('messages.edit_personnel_description') }}</p>
            <form action="{{ route('personnels.update', $personnel->personnel_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="personnel_id">{{ __('messages.form_personnel_id') }}</label>
                    <input type="text" name="personnel_id" id="personnel_id" class="form-control" value="{{ $personnel->personnel_id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="loadCellID">{{ __('messages.form_weapon_id') }}</label>
                    <select name="loadCellID" id="loadCellID" class="form-control @error('loadCellID') is-invalid @enderror" required>
                        <option value="" disabled selected>{{ __('messages.Select_LoadCells') }}</option>
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
                    <label for="nokartu">{{ __('messages.form_card_number') }}</label>
                    <input type="text" name="nokartu" id="nokartu" class="form-control @error('nokartu') is-invalid @enderror" required readonly value="{{ old('nokartu', \App\Models\tmprfids::pluck('nokartu')->first()) }}">
                    @error('nokartu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nama">{{ __('messages.form_name') }}</label>
                    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $personnel->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="pangkat">{{ __('messages.form_rank') }}</label>
                    <input type="text" name="pangkat" id="pangkat" class="form-control @error('pangkat') is-invalid @enderror" value="{{ old('pangkat', $personnel->pangkat) }}" required>
                    @error('pangkat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nrp">{{ __('messages.form_nrp') }}</label>
                    <input type="text" name="nrp" id="nrp" class="form-control @error('nrp') is-invalid @enderror" value="{{ old('nrp', $personnel->nrp) }}" required>
                    @error('nrp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="jabatan">{{ __('messages.form_position') }}</label>
                    <input type="text" name="jabatan" id="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $personnel->jabatan) }}" required>
                    @error('jabatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kesatuan">{{ __('messages.form_unit') }}</label>
                    <input type="text" name="kesatuan" id="kesatuan" class="form-control @error('kesatuan') is-invalid @enderror" value="{{ old('kesatuan', $personnel->kesatuan) }}" required>
                    @error('kesatuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('messages.form_save_changes') }}</button>
                    <a href="{{ route('personnels.index') }}" class="btn btn-secondary">{{ __('messages.form_cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
