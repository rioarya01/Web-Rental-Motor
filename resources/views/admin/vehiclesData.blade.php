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
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="mb-4">
                                <button class="btn btn-primary btn-action" data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </button>
                            </div>
                            <!-- Filter Component -->
                            <form method="GET" id="filterForm" class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <select name="operational_status" class="form-control"
                                            onchange="document.getElementById('filterForm').submit()">
                                            <option value="">-- Status --</option>
                                            <option value="active"
                                                {{ request('operational_status') == 'active' ? 'selected' : '' }}>
                                                Tersedia
                                            </option>
                                            <option value="inactive"
                                                {{ request('operational_status') == 'inactive' ? 'selected' : '' }}>
                                                Tidak
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
                                            <th scope="col">Tipe Kendaraan</th>
                                            <th scope="col">Merk</th>
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
                                                <td>{{ $v->vehicle_category->name ?? 'N/A' }}</td>
                                                <td>{{ $v->vehicle_brand->name ?? 'N/A' }}</td>
                                                <td>Rp {{ number_format($v->price_per_day, 0, ',', '.') }}</td>
                                                <td>
                                                    <span style="{{ $v->operational_status_color }}"
                                                        class="badge px-2 py-1 text-xs fw-semibold rounded">
                                                        {{ $v->operational_status_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($v->image && file_exists(public_path('storage/' . $v->image)))
                                                        <img src="{{ asset('storage/' . $v->image) }}" width="80">
                                                    @elseif ($v->image && file_exists(public_path('img/vehicles/' . $v->image)))
                                                        <img src="{{ asset('img/vehicles/' . $v->image) }}" width="80">
                                                    @else
                                                        <img src="{{ asset('img/default/defaultIMG.png') }}"
                                                            width="80">
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="badge bg-success px-3 py-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateModal{{ $v->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('vehicles-data.destroy', $v->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger  px-3 py-2 border-0"
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

    {{-- add modal --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm" action="{{ route('vehicles-data.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Tipe</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    @foreach ($category as $c)
                                        <option value="{{ $c->id }}">
                                            {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Merk</label>
                                <select name="brand_id" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    @foreach ($brands as $b)
                                        <option value="{{ $b->id }}">
                                            {{ $b->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Plate Number</label>
                                <input type="text" name="plate_number" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Fuel Tank Capacity</label>
                                <input type="number" step="0.01" name="fuel_tank_capacity" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Price Per Day (Rp)</label>
                                <input type="number" name="price_per_day" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Status</label>

                                <select name="operational_status" class="form-control" required>
                                    <option value="">--Pilih--</option>
                                    <option value="active">active</option>
                                    <option value="inactive">inactive</option>
                                    <option value="maintenance">maintenance</option>
                                </select>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="addForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->

    {{-- update modal --}}
    @foreach ($vehicles as $v)
        <div class="modal fade" id="updateModal{{ $v->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm{{ $v->id }}" action="{{ route('vehicles-data.update', $v->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6 mb-3">
                                    <label>Tipe</label>
                                    <select name="category_id" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($category as $c)
                                            <option value="{{ $c->id }}"
                                                {{ $v->category_id == $c->id ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Merk</label>
                                    <select name="brand_id" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        @foreach ($brands as $b)
                                            <option value="{{ $b->id }}"
                                                {{ $v->brand_id == $b->id ? 'selected' : '' }}>
                                                {{ $b->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control" required
                                        value="{{ $v->code }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" required
                                        value="{{ $v->name }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Plate Number</label>
                                    <input type="text" name="plate_number" class="form-control" required
                                        value="{{ $v->plate_number }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Fuel Tank Capacity</label>
                                    <input type="number" step="0.01" name="fuel_tank_capacity" class="form-control"
                                        required value="{{ $v->fuel_tank_capacity }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Price Per Day (Rp)</label>
                                    <input type="number" name="price_per_day" class="form-control" required
                                        value="{{ $v->price_per_day }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label>Status</label>

                                    <select name="operational_status" class="form-control" required>
                                        <option value="">--Pilih--</option>
                                        <option value="active" {{ $v->operational_status == 'active' ? 'selected' : '' }}>
                                            active
                                        </option>
                                        <option value="inactive"
                                            {{ $v->operational_status == 'inactive' ? 'selected' : '' }}>inactive
                                        </option>
                                        <option value="maintenance"
                                            {{ $v->operational_status == 'maintenance' ? 'selected' : '' }}>
                                            maintenance
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="4">{{ $v->description }}</textarea>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="editForm{{ $v->id }}" class="btn btn-primary">Save
                            changes</button>
                    </div>
                </div>
            </div>
        </div><!-- End Basic Modal-->
    @endforeach

@endsection
