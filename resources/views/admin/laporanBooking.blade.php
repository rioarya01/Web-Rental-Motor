@extends('layouts.main')
@section('title', 'Data Konfirmasi Booking')
@section('content')
    <main id="main" class="main d-flex flex-column min-vh-100">
        <div class="pagetitle">
            <h1>Laporan Booking</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Laporan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Laporan Booking</h5>
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
                                            <th scope="col">Detail</th>
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
                                                <td>
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#detailModal{{ $b->id }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i> Detail
                                                    </button>
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
    @foreach ($booking as $b)
        <div class="modal fade" id="detailModal{{ $b->id }}" tabindex="-1"
            aria-labelledby="detailModalLabel{{ $b->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $b->id }}">Detail Booking -
                            {{ $b->booking_code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Informasi Customer</h6>
                                <p><strong>Nama:</strong> {{ $b->user->name }}</p>
                                <p><strong>Email:</strong> {{ $b->user->email }}</p>
                                <p><strong>No. Whatsapp:</strong> {{ $b->user->no_telp }}</p>
                                <p><strong>No. KTP:</strong> {{ $b->user->ktp_number }}</p>
                                <p><strong>Alamat:</strong>
                                    <textarea class="form-control" rows="3" readonly>{{ $b->user->address }}</textarea>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Informasi Booking</h6>
                                <p><strong>Motor:</strong> {{ $b->vehicle->name }}</p>
                                <p><strong>Tanggal Booking:</strong> {{ $b->booking_date }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ $b->rent_start }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ $b->rent_end }}</p>
                                <p><strong>Durasi:</strong> {{ $b->duration_days }} hari</p>
                                <p><strong>Total Bayar:</strong> <span class="fw-bold text-success">Rp
                                        {{ number_format($b->total_amount, 0, ',', '.') }}</span></p>
                                <p><strong>Status:</strong>
                                    <span class="badge rounded-pill {{ $b->booking_status_badge }}">
                                        {{ $b->booking_status_label }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
