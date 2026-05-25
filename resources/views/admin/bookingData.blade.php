@extends('layouts.main')
@section('title', 'Data Konfirmasi Booking')
@section('content')
    <main id="main" class="main d-flex flex-column min-vh-100">
        <div class="pagetitle">
            <h1>Data Konfirmasi Booking</h1>
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
                            <h5 class="card-title">Data Konfirmasi Booking</h5>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Whatsapp</th>
                                            <th scope="col">Jumlah Bayar</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($booking as $index => $b)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $b->booking_code }}</td>
                                                <td>{{ $b->user->name }}</td>
                                                <td>{{ $b->vehicle->name }}</td>
                                                <td>{{ $b->user->email }}</td>
                                                <td>{{ $b->user->no_telp }}</td>
                                                @if ($b->booking_status_id == '1')
                                                    <td class="fw-bold text-danger">Rp
                                                        {{ number_format($b->total_amount, 0, ',', '.') }}
                                                    </td>
                                                @elseif ($b->booking_status_id == '2')
                                                    <td class="fw-bold text-success">Rp
                                                        {{ number_format($b->total_amount, 0, ',', '.') }}
                                                    </td>
                                                @endif
                                                <td>
                                                    <span class="badge rounded-pill {{ $b->booking_status_badge }}">
                                                        {{ $b->booking_status_label }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if ($b->booking_status_id == '1')
                                                        <form action="{{ route('booking.updateStatus', $b->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="badge bg-success px-3 py-2 border-0 ">
                                                                <i class="bi bi-check-circle-fill fs-5"></i>
                                                            </button>
                                                        </form>
                                                    @elseif ($b->booking_status_id == '2')
                                                        <form action="{{ route('booking.cancel', $b->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="badge bg-danger px-3 py-2 border-0 ">
                                                                <i class="bi bi-x-circle-fill fs-5"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center">
                                    <nav aria-label="Vehicle pagination">
                                        <ul class="pagination">

                                            {{-- Previous --}}
                                            <li class="page-item {{ $booking->onFirstPage() ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ $booking->previousPageUrl() }}">
                                                    Previous
                                                </a>
                                            </li>

                                            {{-- Number --}}
                                            @for ($i = 1; $i <= $booking->lastPage(); $i++)
                                                <li class="page-item {{ $booking->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $booking->url($i) }}">
                                                        {{ $i }}
                                                    </a>
                                                </li>
                                            @endfor

                                            {{-- Next --}}
                                            <li class="page-item {{ $booking->hasMorePages() ? '' : 'disabled' }}">
                                                <a class="page-link" href="{{ $booking->nextPageUrl() }}">
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
                </div>
            </div>
        </section>
    </main>
@endsection
