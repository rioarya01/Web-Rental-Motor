@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <!--main-->
    <main id="main" class="main" style="margin: 8vh">
        <div class="container">
            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
            <section class="section dashboard">
                <div class="row">
                    {{-- Heading --}}
                    <div class="mb-10">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                            Daftar Motor yang Tersedia
                        </h2>
                        <p class="text-gray-600">
                            Pilih motor yang paling sesuai dengan gaya perjalanan dan budget Anda.
                        </p>
                    </div>
                    <!-- Filter Component -->
                    <form method="GET" action="{{ route('home.user') }}" id="filterForm" class="col-12 mb-3">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama motor..."
                                    value="{{ request('search') }}"
                                    onchange="document.getElementById('filterForm').submit()">
                            </div>

                            <div class="col-md-4 mb-3">
                                <select name="vehicle_category" class="form-control"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">-- Tipe Motor --</option>
                                    @forelse ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('vehicle_category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <select name="vehicle_brand" class="form-control"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">-- Merk Motor --</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('vehicle_brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <select name="operational_status" class="form-control"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">-- Status --</option>
                                    <option value="active"
                                        {{ request('operational_status') == 'active' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="inactive"
                                        {{ request('operational_status') == 'inactive' ? 'selected' : '' }}>Tidak Tersedia
                                    </option>
                                    <option value="maintenance"
                                        {{ request('operational_status') == 'maintenance' ? 'selected' : '' }}>Pemeliharaan
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2 mb-3">
                                <input type="number" name="min_price" class="form-control" placeholder="Min Price"
                                    value="{{ request('min_price') }}">
                            </div>

                            <div class="col-md-2 mb-3">
                                <input type="number" name="max_price" class="form-control" placeholder="Max Price"
                                    value="{{ request('max_price') }}">
                            </div>

                            <div class="col-md-1 mb-3 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Filter
                                </button>
                            </div>
                            <div class="mb-3 d-grid">
                                <a href="{{ route('home.user') }}" class="btn btn-danger">
                                    Reset
                                </a>
                            </div>
                        </div>

                    </form>

                    <!-- List Vehicles -->
                    @forelse ($vehicles as $vehicle)
                        <div class="col-md-6 mb-4 d-flex justify-content-center">
                            <div class="card" style="max-width: 540px;">
                                <div class="row g-0 align-items-center">

                                    {{-- Gambar di kiri --}}
                                    <div class="col-md-4">
                                        @if ($vehicle->image)
                                            <img src="{{ asset('img/vehicles/' . $vehicle->image) }}"
                                                class="img-fluid rounded-start h-100 object-fit-contain"
                                                alt="{{ $vehicle->name }}">
                                        @endif
                                    </div>

                                    <div class="col-md-8">
                                        <div class="card-body">

                                            <div class="mb-2">
                                                <span style="{{ $vehicle->operational_status_color }}"
                                                    class="px-2 py-1 text-xs fw-semibold rounded">
                                                    {{ $vehicle->operational_status_label }}
                                                </span>
                                            </div>

                                            <h5 class="card-title mb-1">{{ $vehicle->name }}</h5>

                                            <p class="text-sm text-secondary mb-2">
                                                {{ $vehicle->vehicle_category->name ?? '-' }}
                                            </p>
                                            <p class="text-sm text-secondary mb-2">
                                                {{ $vehicle->vehicle_brand->name ?? '-' }}
                                            </p>

                                            <p class="card-text mb-2">
                                                <strong>Harga Sewa :</strong> Rp
                                                {{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                                <span class="text-muted">/hari</span>
                                            </p>

                                            <div class="d-flex gap-2">
                                                <a href="{{ route('vehicle.detail', $vehicle->slug) }}" class="btn btn-primary btn-sm">View Details</a>
                                                <button class="btn btn-success btn-sm">Booking</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center w-full text-gray-500">
                            Kendaraan tidak tersedia.
                        </p>
                    @endforelse
                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mb-5">
                        {{ $vehicles->links('pagination::bootstrap-5') }}
                    </div>
                    {{-- Terms and Conditions --}}
                    <div class="space-y-4 text-justify">
                        <!-- Judul -->
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">
                                Syarat & Ketentuan Rental Motor
                            </h2>
                            <p class="text-md text-gray-600 mt-3">
                                Transparansi adalah kunci. Pastikan Anda memenuhi beberapa persyaratan dasar sebelum
                                melakukan pemesanan.
                            </p>
                        </div>
                        <!-- Isi -->
                        <ol class="list-decimal pl-5 space-y-3 text-md text-gray-700">
                            <li>
                                Lakukan pemesanan minimal 1x24 jam sebelum waktu penggunaan. Setelah pesanan dikonfirmasi,
                                penyewa wajib melakukan konfirmasi pengambilan motor melalui nomor WhatsApp atau datang ke
                                lokasi Sewa Motor ID.
                            </li>
                            <li>
                                Membawa <b>2 kartu identitas</b> (SIM A, KK, KTP, ID Kerja atau ID Pelajar).
                            </li>
                            <li>
                                Menyertakan akun sosial media dan <b>nomor whatsApp</b> yang aktif.
                            </li>
                            <li>
                                Pada saat serah terima kendaraan, pihak penyedia rental akan melakukan <b>pengecekan
                                    keaslian data</b> dan kondisi kendaraan.
                            </li>
                            <li>
                                Pihak penyedia rental <b>berhak membatalkan</b> apabila data tidak sesuai dan syarat sewa
                                tidak dapat dilengkapi.
                            </li>
                            <li>
                                Apabila pembayaran telah selesai dan kendaraan yang dipesan tidak tersedia, penyewa
                                <b>berhak memilih kendaraan lain</b> yang tersedia tanpa dikenakan biaya tambahan.
                            </li>
                        </ol>
                    </div>
                </div>
            </section>
        </div>

    </main><!-- End #main -->
@endsection
