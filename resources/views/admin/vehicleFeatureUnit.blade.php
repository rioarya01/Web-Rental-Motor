@extends('layouts.main')
@section('title', 'Perlengkapan dan Satuan')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Perlengkapan dan Satuan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home.admin') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Perlengkapan dan Satuan
                    </li>
                </ol>
            </nav>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i>
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <section class="section">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2">
                                <div>
                                    <h5 class="card-title mb-0">Tabel Data Perlengkapan</h5>
                                    <p class="text-muted small mb-0">
                                        Kelola perlengkapan yang tersedia pada kendaraan.
                                    </p>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFeatureModal">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Perlengkapan
                                </button>
                            </div>

                            <form action="{{ route('vehicle-feature.index') }}" method="GET" class="row g-2 mb-4">
                                @if(request('unit_search'))
                                    <input type="hidden" name="unit_search" value="{{ request('unit_search') }}">
                                @endif
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" name="feature_search" class="form-control"
                                            value="{{ request('feature_search') }}"
                                            placeholder="Cari perlengkapan atau satuan...">
                                        <button type="submit" class="btn btn-primary">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                                @if(request('feature_search'))
                                    <div class="col-auto">
                                        <a href="{{ route('vehicle-feature.index', array_filter([
                                            'unit_search' => request('unit_search')
                                        ])) }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Reset
                                        </a>
                                    </div>
                                @endif
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 80px;">No</th>
                                            <th scope="col">Nama Perlengkapan</th>
                                            <th scope="col">Satuan</th>
                                            <th scope="col" class="text-center" style="width: 140px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($features as $index => $feature)
                                            <tr>
                                                <td>
                                                    {{ $features->firstItem() + $index }}
                                                </td>
                                                <td>
                                                    {{ $feature->name }}
                                                </td>
                                                <td>
                                                    @if($feature->unit)
                                                        <span class="badge bg-info text-dark px-3 py-2">
                                                            {{ $feature->unit->name }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary px-3 py-2">
                                                            Tanpa Satuan
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    <button type="button"
                                                        class="badge bg-success px-3 py-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editFeatureModal{{ $feature->id }}"
                                                        title="Edit">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('vehicle-feature.destroy', $feature) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus perlengkapan {{ $feature->name }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="badge bg-danger px-3 py-2 border-0"
                                                            title="Hapus">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                        Tidak ada data perlengkapan kendaraan.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($features->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    <nav aria-label="Feature pagination">
                                        <ul class="pagination">
                                            <li class="page-item {{ $features->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $features->previousPageUrl() }}">
                                                    Previous
                                                </a>
                                            </li>

                                            @for ($i = 1; $i <= $features->lastPage(); $i++)
                                                <li class="page-item {{ $features->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $features->url($i) }}">
                                                        {{ $i }}
                                                    </a>
                                                </li>
                                            @endfor

                                            <li class="page-item {{ $features->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $features->nextPageUrl() }}">
                                                    Next
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-2">
                                <div>
                                    <h5 class="card-title mb-0">Tabel Data Satuan</h5>
                                    <p class="text-muted small mb-0">
                                        Kelola satuan yang digunakan oleh perlengkapan.
                                    </p>
                                </div>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addUnitModal">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Tambah Satuan
                                </button>
                            </div>

                            <form action="{{ route('vehicle-feature.index') }}" method="GET" class="row g-2 mb-4">
                                @if(request('feature_search'))
                                    <input type="hidden" name="feature_search" value="{{ request('feature_search') }}">
                                @endif
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" name="unit_search" class="form-control"
                                            value="{{ request('unit_search') }}"
                                            placeholder="Cari nama satuan...">
                                        <button type="submit" class="btn btn-primary">
                                            Cari
                                        </button>
                                    </div>
                                </div>
                                @if(request('unit_search'))
                                    <div class="col-auto">
                                        <a href="{{ route('vehicle-feature.index', array_filter([
                                            'feature_search' => request('feature_search')
                                        ])) }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Reset
                                        </a>
                                    </div>
                                @endif
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col" style="width: 80px;">No</th>
                                            <th scope="col">Nama Satuan</th>
                                            <th scope="col">Jumlah Perlengkapan</th>
                                            <th scope="col" class="text-center" style="width: 140px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($units as $index => $unit)
                                            <tr>
                                                <td>
                                                    {{ $units->firstItem() + $index }}
                                                </td>
                                                <td>
                                                    {{ $unit->name }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-primary px-3 py-2">
                                                        {{ $unit->features_count }} Perlengkapan
                                                    </span>
                                                </td>
                                                <td class="text-center text-nowrap">
                                                    <button type="button"
                                                        class="badge bg-success px-3 py-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editUnitModal{{ $unit->id }}"
                                                        title="Edit">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('vehicle-unit.destroy', $unit) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus satuan {{ $unit->name }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="badge bg-danger px-3 py-2 border-0"
                                                            title="Hapus">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                        Tidak ada data satuan kendaraan.
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($units->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    <nav aria-label="Unit pagination">
                                        <ul class="pagination">
                                            <li class="page-item {{ $units->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $units->previousPageUrl() }}">
                                                    Previous
                                                </a>
                                            </li>

                                            @for ($i = 1; $i <= $units->lastPage(); $i++)
                                                <li class="page-item {{ $units->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $units->url($i) }}">
                                                        {{ $i }}
                                                    </a>
                                                </li>
                                            @endfor

                                            <li class="page-item {{ $units->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $units->nextPageUrl() }}">
                                                    Next
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

{{-- add modal feature --}}
<div class="modal fade" id="addFeatureModal" tabindex="-1"
    aria-labelledby="addFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('vehicle-feature.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFeatureModalLabel">
                        Tambah Perlengkapan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->createFeature->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->createFeature->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="featureName" class="form-label">
                            Nama Perlengkapan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="featureName" name="name"
                            class="form-control @error('name', 'createFeature') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Contoh: Helm, Sarung tangan" required>
                        @error('name', 'createFeature')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="featureUnit" class="form-label">
                            Satuan
                        </label>
                        <select id="featureUnit" name="unit_id"
                            class="form-select @error('unit_id', 'createFeature') is-invalid @enderror">
                            <option value="">Tanpa Satuan</option>
                            @foreach($unitOptions as $unitOption)
                                <option value="{{ $unitOption->id }}"
                                    @selected(old('unit_id') == $unitOption->id)>
                                    {{ $unitOption->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id', 'createFeature')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Pilih satuan yang digunakan untuk menghitung jumlah perlengkapan.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><!-- End Basic Modal-->

{{-- update modal feature --}}
@foreach($features as $feature)
    <div class="modal fade" id="editFeatureModal{{ $feature->id }}" tabindex="-1"
        aria-labelledby="editFeatureModalLabel{{ $feature->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('vehicle-feature.update', $feature) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFeatureModalLabel{{ $feature->id }}">
                            Edit Perlengkapan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($errors->{'updateFeature_' . $feature->id}->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->{'updateFeature_' . $feature->id}->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="editFeatureName{{ $feature->id }}" class="form-label">
                                Nama Perlengkapan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="editFeatureName{{ $feature->id }}"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $feature->name) }}"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editFeatureUnit{{ $feature->id }}" class="form-label">
                                Satuan
                            </label>
                            <select id="editFeatureUnit{{ $feature->id }}"
                                name="unit_id" class="form-select">
                                <option value="">Tanpa Satuan</option>
                                @foreach($unitOptions as $unitOption)
                                    <option value="{{ $unitOption->id }}"
                                        @selected(old('unit_id', $feature->unit_id) == $unitOption->id)>
                                        {{ $unitOption->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

{{-- add modal unit --}}
<div class="modal fade" id="addUnitModal" tabindex="-1"
    aria-labelledby="addUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('vehicle-unit.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitModalLabel">
                        Tambah Satuan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($errors->createUnit->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->createUnit->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="unitName" class="form-label">
                            Nama Satuan
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" id="unitName" name="name"
                            class="form-control @error('name', 'createUnit') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Contoh: buah, set, unit" required>
                        @error('name', 'createUnit')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div><!-- End Basic Modal-->

{{-- update modal unit --}}
@foreach($units as $unit)
    <div class="modal fade" id="editUnitModal{{ $unit->id }}" tabindex="-1"
        aria-labelledby="editUnitModalLabel{{ $unit->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('vehicle-unit.update', $unit) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUnitModalLabel{{ $unit->id }}">
                            Edit Satuan
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($errors->{'updateUnit_' . $unit->id}->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->{'updateUnit_' . $unit->id}->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="editUnitName{{ $unit->id }}" class="form-label">
                                Nama Satuan
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="editUnitName{{ $unit->id }}"
                                name="name" class="form-control"
                                value="{{ old('name', $unit->name) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach