@extends('layouts.main')
@section('title', 'Detail Pemesanan')
@section('content')
<main id="main" class="main" style="margin: 8vh">
    <div class="container">
        
        <div class="pagetitle mb-4">
            <h1>Detail Pemesanan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.user') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Pilih Kendaraan</a></li>
                    <li class="breadcrumb-item active">Detail Pemesanan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <div class="row">
            <div class="col-lg-8 mb-4">
                <!-- Pemesan Info -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background-color: #f9fbfd;">
                    <div class="card-body p-4">
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
                                <td class="fw-semibold">{{ $booking->user->whatsapp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. KTP</td>
                                <td>:</td>
                                <td class="fw-semibold">{{ $booking->user->ktp_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">No. SIM</td>
                                <td>:</td>
                                <td class="fw-semibold">{{ $booking->user->sim_number ?? '-' }}</td>
                            </tr>
                        </table>
                        <small class="text-muted d-block mt-3" style="font-size: 12px;">Kamu bisa mengubah data profilmu di menu Akun.</small>
                    </div>
                </div>

                <!-- Syarat & Ketentuan -->
                <h5 class="fw-bold mb-3">Syarat & Ketentuan Rental Motor</h5>
                <p class="text-muted mb-3" style="font-size: 14px;">Transparansi adalah kunci. Pastikan Anda memenuhi beberapa persyaratan dasar sebelum melakukan pemesanan.</p>
                <ol class="text-muted" style="font-size: 14px; line-height: 1.8;">
                    <li class="mb-2">Lakukan pemesanan minimal <strong>1x24 jam</strong> sebelum waktu penggunaan. Setelah pesanan dikonfirmasi, penyewa wajib melakukan konfirmasi pengambilan motor melalui nomor whatsapp atau datang ke lokasi rental.</li>
                    <li class="mb-2">Membawa <strong>2 kartu identitas</strong> (SIM C, KK, KTP, ID Kerja atau ID Pelajar).</li>
                    <li class="mb-2">Menyertakan akun sosial media dan <strong>nomor whatsapp</strong> yang aktif.</li>
                    <li class="mb-2">Pada saat serah terima kendaraan, pihak penyedia rental akan melakukan <strong>pengecekan keaslian data</strong> dan kondisi kendaraan.</li>
                    <li class="mb-2">Pihak penyedia rental <strong>berhak membatalkan</strong> apabila data tidak sesuai dan syarat sewa tidak dapat dilengkapi.</li>
                    <li class="mb-2">Apabila pembayaran telah selesai dan kendaraan yang dipesan tidak tersedia, penyewa <strong>berhak memilih kendaraan lain</strong> yang tersedia tanpa dikenakan biaya tambahan.</li>
                </ol>
            </div>

            <!-- Sidebar / Ringkasan -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 100px;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted">Durasi sewa : <span class="fw-semibold text-dark">{{ $booking->duration_days }} hari</span></span>
                            <a href="{{ route('booking.history') }}" class="text-primary text-decoration-none" style="font-size: 14px;"><i class="bi bi-pencil"></i> Edit</a>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block mb-1">Tanggal sewa</small>
                                <span class="fw-semibold d-block" style="font-size: 14px;">{{ \Carbon\Carbon::parse($booking->rent_start)->translatedFormat('D, d M Y') }}</span>
                                <span class="text-muted" style="font-size: 13px;">{{ \Carbon\Carbon::parse($booking->rent_start)->format('H:i') }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block mb-1">Selesai sewa</small>
                                <span class="fw-semibold d-block" style="font-size: 14px;">{{ \Carbon\Carbon::parse($booking->rent_end)->translatedFormat('D, d M Y') }}</span>
                                <span class="text-muted" style="font-size: 13px;">{{ \Carbon\Carbon::parse($booking->rent_end)->format('H:i') }}</span>
                            </div>
                        </div>

                        <hr style="border-style: dashed; opacity: 0.2;">

                        <div class="d-flex align-items-center mb-4 mt-3">
                            @if ($booking->vehicle->image)
                                <img src="{{ asset('img/vehicles/' . $booking->vehicle->image) }}" class="rounded me-3" style="width: 80px; object-fit: contain;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 60px;">
                                    <i class="bi bi-image text-muted fs-4"></i>
                                </div>
                            @endif
                            <div>
                                <h6 class="fw-bold mb-0">{{ $booking->vehicle->name ?? '-' }}</h6>
                                <small class="text-muted d-block" style="font-size: 12px;">{{ $booking->vehicle->vehicle_category->name ?? 'Motor' }}</small>
                            </div>
                        </div>

                        <div class="bg-light rounded p-3 mb-4">
                            <h6 class="fw-bold mb-3" style="font-size: 14px;">Ringkasan transaksi</h6>
                            <div class="d-flex justify-content-between mb-2 text-muted" style="font-size: 14px;">
                                <span>Harga</span>
                                <span>Rp {{ number_format($booking->duration_days * $booking->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 text-muted" style="font-size: 14px;">
                                <span>Diskon</span>
                                <span>-</span>
                            </div>
                            <hr style="opacity: 0.1;">
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-muted">Total harga</span>
                                <span class="fw-bold fs-5">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 py-2 fw-semibold" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#paymentModal">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<!-- Modal Pembayaran -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="paymentModalLabel">Instruksi Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="bi bi-wallet2 text-primary mb-3 d-block" style="font-size: 3rem;"></i>
                <p class="text-muted mb-4">Silakan transfer sejumlah <strong>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</strong> ke rekening di bawah ini:</p>
                
                <div class="card bg-light border-0 mb-4 text-start">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bank BCA</span>
                            <span class="fw-bold text-dark">0123456789</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Bank Mandiri</span>
                            <span class="fw-bold text-dark">9876543210</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Atas Nama</span>
                            <span class="fw-bold text-dark">Admin Rental Motor</span>
                        </div>
                    </div>
                </div>

                <p class="text-muted" style="font-size: 13px;">Setelah transfer, harap konfirmasi pembayaran Anda melalui WhatsApp Admin dengan menekan tombol di bawah ini.</p>
                
                @php
                    $waNumber = '6281234567890'; // Ganti dengan nomor WA Admin yang asli
                    $waText = urlencode("Halo Admin, saya ingin konfirmasi pembayaran untuk pesanan motor.\n\nKode Booking: *{$booking->booking_code}*\nNama Pemesan: *{$booking->user->name}*\nTotal Transfer: *Rp " . number_format($booking->total_amount, 0, ',', '.') . "*");
                @endphp
                
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" class="btn btn-success w-100 py-2 fw-semibold" style="border-radius: 8px;">
                    <i class="bi bi-whatsapp me-2"></i> Konfirmasi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
