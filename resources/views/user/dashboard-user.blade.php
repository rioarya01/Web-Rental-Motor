@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
<style>
    .vehicle-card {
        background-color: #f8f8f8;
        transition: 0.3s ease;
    }

    .vehicle-card:hover {
        transform: translateY(-4px);
    }

    .vehicle-image {
        width: 100%;
        max-height: 260px;
        object-fit: contain;
    }

    /* Mobile */
    @media (max-width: 767px) {
        .vehicle-card {
            padding: 1rem;
        }

        .vehicle-image {
            max-height: 220px;
        }

        .vehicle-card h3 {
            font-size: 1.4rem;
        }
    }
</style>

<main class="justify-content-center">
    {{-- Heading & Filter Section --}}
    <section class="container" style="margin-top: 100px;">
        {{-- Heading --}}
        <div class="mx-3 mx-md-0">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Daftar Kendaraan
            </h2>
            <p class="text-gray-600">
                Pilih motor yang paling sesuai dengan gaya perjalanan dan budget Anda.
            </p>
        </div>
        <!-- Filter Component -->
        <div class="mx-3 mx-md-0">
            {{-- Mobile & Tablet Toggle --}}
            <div class="d-lg-none mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">Cari kendaraan</h5>

                    <button class="btn btn-link text-decoration-none p-0 d-flex align-items-center gap-1"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#mobileFilter">
                            Edit filter
                        <i class="bi bi-chevron-down"></i>
                    </button>
                </div>
            </div>
            {{-- Filter Options --}}
            <div class="collapse d-lg-block" id="mobileFilter">
                <form method="GET" action="{{ route('home.user') }}" id="filterForm" class="col-12 mb-4 bg-light p-4 rounded-4 shadow-sm">
                    <div class="row g-3 align-items-end">
                        {{-- Search --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold small">
                                Cari Motor
                            </label>
        
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
        
                                <input type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Cari nama motor..."
                                    value="{{ request('search') }}"
                                    onchange="document.getElementById('filterForm').submit()">
                            </div>
                        </div>
        
                        {{-- Category --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold small">
                                Tipe Motor
                            </label>
        
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-grid"></i>
                                </span>
        
                                <select name="vehicle_category"
                                    class="form-select"
                                    onchange="document.getElementById('filterForm').submit()">
        
                                    <option value="">Semua Tipe</option>
        
                                    @forelse ($category as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('vehicle_category') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
        
                        {{-- Brand --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold small">
                                Merk Motor
                            </label>
        
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-bicycle"></i>
                                </span>
        
                                <select name="vehicle_brand"
                                    class="form-select"
                                    onchange="document.getElementById('filterForm').submit()">
        
                                    <option value="">Semua Merk</option>
        
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ request('vehicle_brand') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
        
                        {{-- Status --}}
                        <div class="col-12 col-md-6 col-lg-3">
                            <label class="form-label fw-semibold small">
                                Status
                            </label>
        
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-check-circle"></i>
                                </span>
        
                                <select name="operational_status"
                                    class="form-select"
                                    onchange="document.getElementById('filterForm').submit()">
        
                                    <option value="">Semua Status</option>
        
                                    <option value="active"
                                        {{ request('operational_status') == 'active' ? 'selected' : '' }}>
                                        Tersedia
                                    </option>
        
                                    <option value="inactive"
                                        {{ request('operational_status') == 'inactive' ? 'selected' : '' }}>
                                        Tidak Tersedia
                                    </option>
        
                                    <option value="maintenance"
                                        {{ request('operational_status') == 'maintenance' ? 'selected' : '' }}>
                                        Pemeliharaan
                                    </option>
                                </select>
                            </div>
                        </div>
        
                        {{-- Min Price --}}
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label fw-semibold small">
                                Harga Minimum
                            </label>
        
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-cash-stack"></i>
                                </span>
        
                                <input type="number"
                                    name="min_price"
                                    class="form-control"
                                    placeholder="Min"
                                    value="{{ request('min_price') }}">
                            </div>
                        </div>
        
                        {{-- Max Price --}}
                        <div class="col-12 col-md-6 col-lg-2">
                            <label class="form-label fw-semibold small">
                                Harga Maximum
                            </label>
        
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-cash"></i>
                                </span>
        
                                <input type="number"
                                    name="max_price"
                                    class="form-control"
                                    placeholder="Max"
                                    value="{{ request('max_price') }}">
                            </div>
                        </div>
        
                        {{-- Filter Button --}}
                        <div class="col-6 col-lg-2 d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel me-1"></i>
                                Filter
                            </button>
                        </div>
        
                        {{-- Reset Button --}}
                        <div class="col-6 col-lg-2 d-grid">
                            <a href="{{ route('home.user') }}"
                                class="btn btn-outline-danger">
        
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Reset
                            </a>
                        </div>
        
                    </div>
                </form>
            </div>
        </div>
    </section>
    {{-- Vehicle List & Pagination Section --}}
    <section class="container" style="margin-top: 50px;">
        <div class="mx-3 mx-md-0">
            <!-- Vehicle List -->
            <div class="row g-4">
                @forelse ($vehicles as $vehicle)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 p-3 vehicle-card">

                            {{-- Header --}}
                            <div >
                                <h5 class="fw-bold fs-4 mb-1">{{ $vehicle->name }}</h5>

                                <p class="text-secondary mb-0">
                                    {{ $vehicle->vehicle_category->name ?? '-' }}
                                </p>
                            </div>

                            {{-- Image --}}
                            <div class="text-center my-3">
                                @if ($vehicle->image)
                                    <img src="{{ asset('img/vehicles/' . $vehicle->image) }}"
                                        alt="{{ $vehicle->name }}"
                                        class="img-fluid vehicle-image">
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="d-flex justify-content-between align-items-center text-secondary small mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-credit-card-2-front"></i>
                                    <span>{{ $vehicle->plate_number ?? 'AB1234CD' }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-1 px-2 py-1 rounded-2"
                                    style="{{ $vehicle->operational_status_color }}">
                                    {{ $vehicle->operational_status_label }}
                                </div>
                            </div>

                            {{-- Footer --}}
                            <div class="d-block justify-content-between align-items-end my-auto gap-2">
                                <div>
                                    <h3 class="fw-bold mb-3">
                                        Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                        <span class="fs-6 text-secondary fw-normal">/day</span>
                                    </h3>
                                </div>
                                <div class="d-flex gap-2 w-100">
                                    <a href="{{ route('vehicle.detail', $vehicle->slug) }}"
                                        class="btn btn-outline-primary rounded-3 w-100">
                                        View Details
                                    </a>
                                    <button class="btn btn-primary rounded-3 w-100">
                                        Booking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-secondary">
                            Kendaraan tidak tersedia.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $vehicles->links('pagination::bootstrap-5') }}
        </div>
    </section>
    {{-- Terms and Conditions Section--}}
    <section class="container" style="margin-top: 50px; margin-bottom: 100px;">
        <div class="mx-3 mx-md-0 space-y-4 text-justify">
            <!-- Title -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Syarat & Ketentuan Rental Motor
                </h2>
                <p class="text-md text-gray-600 mt-3">
                    Transparansi adalah kunci. Pastikan Anda memenuhi beberapa persyaratan dasar sebelum
                    melakukan pemesanan.
                </p>
            </div>
            <!-- Content -->
            <ol class="list-decimal space-y-3 text-md text-gray-700">
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
    </section>
</main>
@endsection
