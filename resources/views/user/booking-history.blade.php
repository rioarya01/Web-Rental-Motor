@extends('layouts.main')
@section('title', 'Riwayat Penyewaan')
@section('content')
    <main class="justify-content-center" style="margin-top: 150px;">
        <div class="container">
            <div class="pagetitle mb-4">
                <div class="mb-3 mb-md-5">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Riwayat Penyewaan</h2>
                    <p class="text-gray-600">Berikut adalah riwayat penyewaan kendaraan Anda.</p>
                </div>
            </div><!-- End Page Title -->

            <section class="section">
                <div class="row">
                    <div class="col-12">

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="d-flex align-items-center mb-3">
                            <h5 class="card-title mb-0">Daftar Pesanan Saya</h5>
                        </div>

                        @forelse ($bookings as $booking)
                            <div class="card mb-3 shadow-sm border-0" style="border-radius: 12px;">
                                <div
                                    class="card-body d-flex flex-wrap align-items-center justify-content-between p-3 gap-3">
                                    <!-- Motor Image & Info -->
                                    <div class="d-flex align-items-center" style="min-width: 200px;">
                                        @if ($booking->vehicle->image && file_exists(public_path('storage/' . $booking->vehicle->image)))
                                            <img src="{{ asset('storage/' . $booking->vehicle->image) }}" alt="Motor"
                                                class="img-fluid rounded me-3"
                                                style="width: 80px; height: 60px; object-fit: contain;">
                                        @elseif ($booking->vehicle->image && file_exists(public_path('img/vehicles/' . $booking->vehicle->image)))
                                            <img src="{{ asset('img/vehicles/' . $booking->vehicle->image) }}"
                                                alt="Motor" class="img-fluid rounded me-3"
                                                style="width: 80px; height: 60px; object-fit: contain;">
                                        @else
                                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                style="width: 80px; height: 60px;">
                                                <i class="bi bi-image text-muted fs-4"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <small class="text-muted d-block"
                                                style="font-size: 11px;">{{ $booking->vehicle->vehicle_category->name ?? 'Motor' }}</small>
                                            <span
                                                class="fw-bold">{{ $booking->vehicle->name ?? 'Kendaraan Dihapus' }}</span>
                                        </div>
                                    </div>

                                    <!-- Kode Booking -->
                                    <div class="text-center d-none d-md-block">
                                        <small class="text-muted d-block" style="font-size: 11px;">Kode Booking</small>
                                        <span class="fw-semibold">{{ $booking->booking_code }}</span>
                                    </div>

                                    <!-- Tanggal Booking -->
                                    <div class="text-center d-none d-md-block">
                                        <small class="text-muted d-block" style="font-size: 11px;">Tanggal Booking</small>
                                        <span
                                            class="fw-semibold">{{ \Carbon\Carbon::parse($booking->booking_date ?? $booking->created_at)->format('d-m-Y') }}</span>
                                    </div>

                                    <!-- Status -->
                                    <div class="text-center">
                                        <small class="text-muted d-block d-md-none" style="font-size: 11px;">Status</small>
                                        <span class="badge rounded-pill {{ $booking->booking_status_badge }}">
                                            {{ $booking->booking_status_label }}
                                        </span>
                                        {{-- @if ($booking->booking_status_id == 1)
                                            <span class="badge rounded-pill bg-light text-secondary border">Belum
                                                bayar</span>
                                        @elseif ($booking->booking_status_id == 2)
                                            <span
                                                class="badge rounded-pill bg-success-light text-success border border-success">Sudah
                                                Dibayar</span>
                                        @elseif ($booking->booking_status_id == 7)
                                            <span
                                                class="badge rounded-pill bg-danger-light text-danger border border-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge rounded-pill bg-secondary">Status
                                                {{ $booking->booking_status_id }}</span>
                                        @endif --}}
                                    </div>

                                    <!-- Harga -->
                                    <div class="text-center d-none d-sm-block">
                                        <small class="text-muted d-block" style="font-size: 11px;">Harga</small>
                                        <span class="fw-bold">Rp
                                            {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                    </div>

                                    <!-- Detail Button -->
                                    <div>
                                        <button class="btn btn-primary btn-sm px-4 rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#modalDetail{{ $booking->id }}">Detail</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Detail Pemesanan -->
                            <div class="modal fade" id="modalDetail{{ $booking->id }}" tabindex="-1"
                                aria-labelledby="modalDetailLabel{{ $booking->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="modal-title fw-bold" id="modalDetailLabel{{ $booking->id }}">Detail
                                                Pemesanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body p-4 pt-2">
                                            <div class="row mb-4">
                                                <div class="col-md-5 text-center text-md-start">
                                                    <div class="mb-2">
                                                        <h5 class="fw-bold mb-0">
                                                            {{ $booking->vehicle->name ?? 'Kendaraan Dihapus' }}</h5>
                                                        <small
                                                            class="text-muted">{{ $booking->vehicle->vehicle_category->name ?? 'Motor' }}</small>
                                                        <div class="mt-1">
                                                            <span class="badge bg-secondary"><i class="bi bi-credit-card-2-front me-1"></i>{{ $booking->vehicle->plate_number ?? '-' }}</span>
                                                        </div>
                                                    </div>
                                                    @if ($booking->vehicle->image && file_exists(public_path('storage/' . $booking->vehicle->image)))
                                                        <img src="{{ asset('storage/' . $booking->vehicle->image) }}"
                                                            class="img-fluid rounded" alt="{{ $booking->vehicle->name }}">
                                                    @elseif ($booking->vehicle->image && file_exists(public_path('img/vehicles/' . $booking->vehicle->image)))
                                                        <img src="{{ asset('img/vehicles/' . $booking->vehicle->image) }}"
                                                            style="max-height: 180px; object-fit: contain;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center w-100"
                                                            style="height: 180px;">
                                                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-md-7 mt-4 mt-md-0">
                                                    <h6 class="fw-bold mb-3">Pemesan</h6>
                                                    <table class="table table-borderless table-sm mb-0">
                                                        <tr>
                                                            <td class="text-muted" style="width: 140px;">Nama</td>
                                                            <td style="width: 10px;">:</td>
                                                            <td class="fw-semibold">{{ $booking->user->name ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">No. whatsapp</td>
                                                            <td>:</td>
                                                            <td class="fw-semibold">{{ $booking->user->whatsapp ?? '-' }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">Kode booking</td>
                                                            <td>:</td>
                                                            <td class="fw-semibold">{{ $booking->booking_code }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted">Tanggal booking</td>
                                                            <td>:</td>
                                                            <td class="fw-semibold">
                                                                {{ \Carbon\Carbon::parse($booking->booking_date ?? $booking->created_at)->translatedFormat('d M Y') }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                            <hr style="border-style: dashed; opacity: 0.2;">

                                            <div class="row mt-4 align-items-center">
                                                <div class="col-6 col-md-3 mb-3 mb-md-0">
                                                    <small class="text-muted d-block mb-1">Tanggal sewa</small>
                                                    <span
                                                        class="fw-semibold d-block">{{ \Carbon\Carbon::parse($booking->rent_start)->translatedFormat('D, d M Y') }}</span>
                                                    <span
                                                        class="text-muted">{{ \Carbon\Carbon::parse($booking->rent_start)->format('H:i') }}</span>
                                                </div>
                                                <div class="col-6 col-md-3 mb-3 mb-md-0">
                                                    <small class="text-muted d-block mb-1">Selesai sewa</small>
                                                    <span
                                                        class="fw-semibold d-block">{{ \Carbon\Carbon::parse($booking->rent_end)->translatedFormat('D, d M Y') }}</span>
                                                    <span
                                                        class="text-muted">{{ \Carbon\Carbon::parse($booking->rent_end)->format('H:i') }}</span>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <small class="text-muted d-block mb-1">Status</small>
                                                    <span class="badge rounded-pill {{ $booking->booking_status_badge }}">
                                                        {{ $booking->booking_status_label }}
                                                    </span>
                                                    @if($booking->payment)
                                                        <div class="mt-1">
                                                            @if($booking->payment->method === 'cash')
                                                                <small class="text-success fw-semibold"><i class="bi bi-cash-stack"></i> Cash</small>
                                                            @else
                                                                <small class="text-primary fw-semibold"><i class="bi bi-bank"></i> Transfer</small>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-6 col-md-3 text-end">
                                                    <small class="text-muted d-block mb-1">Harga Total</small>
                                                    <span class="fw-bold text-primary fs-5">Rp
                                                        {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                                </div>
                                            </div>

                                            <div class="row mt-4 bg-light rounded p-3 mx-0">
                                                <div class="col-md-6 mb-3 mb-md-0">
                                                    <h6 class="fw-bold mb-1" style="font-size: 13px;"><i class="bi bi-geo-alt me-1"></i> Alamat Jemput / Antar</h6>
                                                    <p class="text-muted mb-0" style="font-size: 13px;">{{ $booking->pickup_address ?: 'Tidak ada alamat tambahan yang diisi.' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="fw-bold mb-1" style="font-size: 13px;"><i class="bi bi-chat-text me-1"></i> Catatan</h6>
                                                    <p class="text-muted mb-0" style="font-size: 13px;">{{ $booking->notes ?: 'Tidak ada catatan tambahan.' }}</p>
                                                </div>
                                            </div>

                                            @if ($booking->status->name == 'payment_failed')
                                                <div class="alert alert-danger mt-4 mb-0" style="font-size: 13px;">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> <strong>Pembayaran ditolak:</strong><br>
                                                    {{ $booking->payment_notes ?? 'Tidak ada alasan.' }}
                                                </div>
                                            @endif
                                        </div>

                                        @if (in_array($booking->status->name, ['paid', 'payment_failed', 'cancelled']))
                                            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                                                @php
                                                    if ($booking->status->name == 'payment_failed') {
                                                        $btnText = 'Unggah Ulang Bukti (Ditolak)';
                                                        $btnClass = 'btn-danger';
                                                    } elseif ($booking->payment_proof) {
                                                        $btnText = 'Cek Status Pembayaran';
                                                        $btnClass = 'btn-info text-white';
                                                    } else {
                                                        $btnText = 'Lanjutkan Pembayaran';
                                                        $btnClass = 'btn-primary';
                                                    }
                                                @endphp
                                                <a href="{{ route('booking.checkout', $booking->id) }}"
                                                    class="btn {{ $btnClass }} w-100 py-2 fw-semibold"
                                                    style="border-radius: 8px;">{{ $btnText }}</a>
                                                
                                                @if($booking->payment_proof)
                                                    <a href="{{ route('booking.showProof', $booking->id) }}" target="_blank"
                                                        class="btn btn-outline-secondary w-100 py-2 mt-2 fw-semibold"
                                                        style="border-radius: 8px;">
                                                        <i class="bi bi-image me-1"></i> Lihat Bukti Pembayaran
                                                    </a>
                                                @endif

                                                @php
                                                    $waNumber = $paymentSetting->whatsapp_number ?? '6285735717807'; 
                                                    $waText = urlencode(
                                                        "Halo Admin, saya ingin bertanya terkait pesanan dengan Kode Booking: *{$booking->booking_code}*\nNama Pemesan: *{$booking->user->name}*\nTotal Transfer: *Rp " .
                                                            number_format($booking->total_amount, 0, ',', '.') .
                                                            '*',
                                                    );
                                                @endphp

                                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                                                    class="btn btn-success w-100 py-2 fw-semibold" style="border-radius: 8px;">
                                                    <i class="bi bi-whatsapp me-2"></i> Tanya via WhatsApp
                                                </a>
                                            </div>

                                        @elseif($booking->payment_proof)
                                            <div class="modal-footer border-0 pt-0 pb-4 px-4">
                                                <a href="{{ route('booking.showProof', $booking->id) }}" target="_blank"
                                                    class="btn btn-outline-secondary w-100 py-2 fw-semibold"
                                                    style="border-radius: 8px;">
                                                    <i class="bi bi-image me-1"></i> Lihat Bukti Pembayaran
                                                </a>
                                                
                                                @php
                                                    $waNumber = $paymentSetting->whatsapp_number ?? '6285735717807'; 
                                                    $waText = urlencode(
                                                        "Halo Admin, saya ingin konfirmasi pembayaran untuk pesanan motor.\n\nKode Booking: *{$booking->booking_code}*\nNama Pemesan: *{$booking->user->name}*\nTotal Transfer: *Rp " .
                                                            number_format($booking->total_amount, 0, ',', '.') .
                                                            '*',
                                                    );
                                                @endphp

                                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank"
                                                    class="btn btn-success w-100 py-2 fw-semibold" style="border-radius: 8px;">
                                                    <i class="bi bi-whatsapp me-2"></i> Konfirmasi via WhatsApp
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                                <div class="card-body text-center text-secondary py-5">
                                    <i class="bi bi-box-seam display-4 d-block mb-3"></i>
                                    Belum ada riwayat pesanan.
                                </div>
                            </div>
                        @endforelse

                        <div class="d-flex justify-content-end mt-4">
                            {{ $bookings->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
