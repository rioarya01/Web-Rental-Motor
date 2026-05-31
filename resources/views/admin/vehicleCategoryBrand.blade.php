@extends('layouts.main')
@section('title', 'Category')
@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Kategori</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Data Kategori</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tabel Data Kategori</h5>
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

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama </th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($categories as $index => $category)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>
                                                    <button class="badge bg-success px-3 py-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateModal{{ $category->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('vehicle-category.destroy', $category->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger px-3 py-2 border-0">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data kategori kendaraan.
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
                                        <li class="page-item {{ $categories->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $categories->previousPageUrl() }}">
                                                Previous
                                            </a>
                                        </li>

                                        {{-- Number --}}
                                        @for ($i = 1; $i <= $categories->lastPage(); $i++)
                                            <li class="page-item {{ $categories->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $categories->url($i) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor

                                        {{-- Next --}}
                                        <li class="page-item {{ $categories->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $categories->nextPageUrl() }}">
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
    <hr>
    <main id="main" class="main" style="margin-top: 2vh;">
        <div class="pagetitle">
            <h1>Data Merk</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Data Merk</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tabel Data Merk</h5>
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
                                    data-bs-target="#addModalBrand">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama </th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($brand as $index => $b)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $b->name }}</td>
                                                <td>
                                                    <button class="badge bg-success px-3 py-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#updateModalBrand{{ $b->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('vehicle-brand.destroy', $b->id) }}"
                                                        method="POST" class="d-inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger px-3 py-2 border-0">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada data kategori kendaraan.
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
                                        <li class="page-item {{ $brand->onFirstPage() ? 'disabled' : '' }}">
                                            <a class="page-link" href="{{ $brand->previousPageUrl() }}">
                                                Previous
                                            </a>
                                        </li>

                                        {{-- Number --}}
                                        @for ($i = 1; $i <= $brand->lastPage(); $i++)
                                            <li class="page-item {{ $brand->currentPage() == $i ? 'active' : '' }}">
                                                <a class="page-link" href="{{ $brand->url($i) }}">
                                                    {{ $i }}
                                                </a>
                                            </li>
                                        @endfor

                                        {{-- Next --}}
                                        <li class="page-item {{ $brand->hasMorePages() ? '' : 'disabled' }}">
                                            <a class="page-link" href="{{ $brand->nextPageUrl() }}">
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

{{-- add modal --}}
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('vehicle-category.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

{{-- update modal --}}
@foreach ($categories as $c)
    <div class="modal fade" id="updateModal{{ $c->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm{{ $c->id }}" action="{{ route('vehicle-category.update', $c->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $c->name }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->
@endforeach

{{-- add modal --}}
<div class="modal fade" id="addModalBrand" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Merk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm" action="{{ route('vehicle-brand.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->

{{-- update modal --}}
@foreach ($brand as $b)
    <div class="modal fade" id="updateModalBrand{{ $b->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Merk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm{{ $b->id }}" action="{{ route('vehicle-brand.update', $b->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Nama</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $b->name }}" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save
                                changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- End Basic Modal-->
@endforeach
