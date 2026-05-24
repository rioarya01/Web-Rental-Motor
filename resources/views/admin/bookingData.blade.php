@extends('layouts.main')
@section('title', 'Booking Data')
@section('content')
    <main id="main" class="main d-flex flex-column min-vh-100">
        <div class="pagetitle">
            <h1>Booking Data</h1>
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
                            <h5 class="card-title">Booking Data</h5>
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
                                            <th scope="col">Nama Lengkap</th>
                                            <th scope="col">Motor</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Whatsapp</th>
                                            <th scope="col">Total Harga</th>
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
                                                <td class="fw-bold text-danger">Rp
                                                    {{ number_format($b->total_amount, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill {{ $b->booking_status_badge }}">
                                                        {{ $b->booking_status_label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($b->booking_status_id == '1')
                                                        <form action="{{ route('booking.updateStatus', $b->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="badge bg-primary   px-3 py-2 rounded-pill">
                                                                Setujui
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $booking->links('pagination::bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
