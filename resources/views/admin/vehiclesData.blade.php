@extends('layouts.main')
@section('title', 'Vehicles')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Kendaraan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Data</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tabel Data Kendaraan</h5>
                            <div class="mb-4">
                                <button class="btn btn-primary btn-action" data-toggle="" data-target="#">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </button>
                            </div>
                            <!-- Filter Component -->
                            <form method="GET" action="{{ route('vehicles-data') }}" id="filterForm" class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <select name="operational_status" class="form-control"
                                            onchange="document.getElementById('filterForm').submit()">
                                            <option value="">-- Status --</option>
                                            <option value="active"
                                                {{ request('operational_status') == 'active' ? 'selected' : '' }}>Tersedia
                                            </option>
                                            <option value="inactive"
                                                {{ request('operational_status') == 'inactive' ? 'selected' : '' }}>Tidak
                                                Tersedia
                                            </option>
                                            <option value="maintenance"
                                                {{ request('operational_status') == 'maintenance' ? 'selected' : '' }}>
                                                Pemeliharaan
                                            </option>
                                        </select>
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
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Cari Kendaraan..." value="{{ request('search') }}"
                                            onchange="document.getElementById('filterForm').submit()">
                                    </div>
                                </div>

                            </form>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Kendaraan</th>
                                            {{-- <th scope="col">Tipe Kendaraan</th>
                                            <th scope="col">Merk</th> --}}
                                            <th scope="col">Harga Sewa / Hari</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Gambar</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($vehicles as $index => $v)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $v->name }}</td>
                                                {{-- <td>{{ $v->vehicle_category->name ?? 'N/A' }}</td>
                                                <td>{{ $v->vehicle_brand->name ?? 'N/A' }}</td> --}}
                                                <td>Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</td>
                                                <td>
                                                    <span style="{{ $v->operational_status_color }}"
                                                        class="badge px-2 py-1 text-xs fw-semibold rounded">
                                                        {{ $v->operational_status_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($v->image)
                                                        <img src="{{ asset('img/vehicles/' . $v->image) }}" width="80">
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" class="badge bg-success text-decoration-none"><i
                                                            class="bi bi-pencil-fill"></i>
                                                    </a>
                                                    <a href="#" class="badge bg-warning text-decoration-none"><i
                                                            class="bi bi-ticket-detailed-fill"></i>
                                                    </a>
                                                    <form action="#" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="badge bg-danger border-0 text-decoration-none"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?')">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="fas fa-inbox"></i> Tidak ada produk yang ditemukan
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                <nav aria-label="Vehicle pagination">
                                    <ul class="pagination">

                                        {{-- Previous --}}
                                        <li class="page-item {{ $vehicles->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $vehicles->previousPageUrl() }}">
                                                Previous
                                            </a>
                                        </li>

                                        {{-- Number --}}
                                        @for ($i = 1; $i <= $vehicles->lastPage(); $i++)
                                            <li class="page-item {{ $vehicles->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $vehicles->url($i) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor

                                        {{-- Next --}}
                                        <li class="page-item {{ $vehicles->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $vehicles->nextPageUrl() }}">
                                                Next
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- end of pagination -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
