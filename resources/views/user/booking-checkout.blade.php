@extends('layouts.main')
@section('title', 'Detail Pemesanan')
@section('content')
    <main class="justify-content-center" style="margin-top: 150px;">
        <div class="container">
            <div class="pagetitle mb-4">
                <div class="mb-3 mb-md-5">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Detail Pemesanan</h2>
                    <p class="text-gray-600">Berikut adalah detail pemesanan kendaraan Anda.</p>
                </div>
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
                                    <td class="fw-semibold">{{ $booking->user->no_telp ?? '-' }}</td>
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
                            <small class="text-muted d-block mt-3" style="font-size: 12px;">Kamu bisa mengubah data profilmu
                                di menu Akun.</small>
                        </div>
                    </div>

                    <!-- Syarat & Ketentuan -->
                    <h5 class="fw-bold mb-3">Syarat & Ketentuan Rental Motor</h5>
                    <p class="text-muted mb-3" style="font-size: 14px;">Transparansi adalah kunci. Pastikan Anda memenuhi
                        beberapa persyaratan dasar sebelum melakukan pemesanan.</p>
                    <ol class="text-muted" style="font-size: 14px; line-height: 1.8;">
                        <li class="mb-2">Lakukan pemesanan minimal <strong>1x24 jam</strong> sebelum waktu penggunaan.
                            Setelah pesanan dikonfirmasi, penyewa wajib melakukan konfirmasi pengambilan motor melalui nomor
                            whatsapp atau datang ke lokasi rental.</li>
                        <li class="mb-2">Membawa <strong>2 kartu identitas</strong> (SIM C, KK, KTP, ID Kerja atau ID
                            Pelajar).</li>
                        <li class="mb-2">Menyertakan akun sosial media dan <strong>nomor whatsapp</strong> yang aktif.
                        </li>
                        <li class="mb-2">Pada saat serah terima kendaraan, pihak penyedia rental akan melakukan
                            <strong>pengecekan keaslian data</strong> dan kondisi kendaraan.
                        </li>
                        <li class="mb-2">Pihak penyedia rental <strong>berhak membatalkan</strong> apabila data tidak
                            sesuai dan syarat sewa tidak dapat dilengkapi.</li>
                        <li class="mb-2">Apabila pembayaran telah selesai dan kendaraan yang dipesan tidak tersedia,
                            penyewa <strong>berhak memilih kendaraan lain</strong> yang tersedia tanpa dikenakan biaya
                            tambahan.</li>
                    </ol>
                </div>

                <!-- Sidebar / Ringkasan -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 100px;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="fw-bold mb-0">Durasi sewa : {{ $booking->duration_days }} hari</h6>
                                @if(!$booking->payment_proof)
                                    <a href="{{ route('booking.edit', $booking->id) }}"
                                        class="text-primary text-decoration-none" style="font-size: 14px;">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <small class="text-muted d-block mb-1">Tanggal sewa</small>
                                    <span class="fw-semibold d-block"
                                        style="font-size: 14px;">{{ \Carbon\Carbon::parse($booking->rent_start)->translatedFormat('D, d M Y') }}</span>
                                    <span class="text-muted"
                                        style="font-size: 13px;">{{ \Carbon\Carbon::parse($booking->rent_start)->format('H:i') }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block mb-1">Selesai sewa</small>
                                    <span class="fw-semibold d-block"
                                        style="font-size: 14px;">{{ \Carbon\Carbon::parse($booking->rent_end)->translatedFormat('D, d M Y') }}</span>
                                    <span class="text-muted"
                                        style="font-size: 13px;">{{ \Carbon\Carbon::parse($booking->rent_end)->format('H:i') }}</span>
                                </div>
                            </div>

                            <div class="row mb-3 mt-3">
                                <div class="col-12 mb-2">
                                    <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i> Alamat Penjemputan / Pengiriman</small>
                                    <span class="text-dark d-block" style="font-size: 13px;">{{ $booking->pickup_address ?: 'Tidak ada alamat tambahan yang diisi.' }}</span>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted d-block mb-1"><i class="bi bi-chat-text me-1"></i> Catatan Tambahan</small>
                                    <span class="text-dark d-block" style="font-size: 13px;">{{ $booking->notes ?: 'Tidak ada catatan tambahan.' }}</span>
                                </div>
                            </div>

                            <hr style="border-style: dashed; opacity: 0.2;">

                            <div class="d-flex align-items-center mb-4 mt-3">
                                @if ($booking->vehicle->image && file_exists(public_path('storage/' . $booking->vehicle->image)))
                                    <img src="{{ asset('storage/' . $booking->vehicle->image) }}"
                                        class="img-fluid vehicle-image" class="img-fluid rounded me-3"
                                        style="width: 80px; height: 60px; object-fit: contain;">
                                @elseif ($booking->vehicle->image && file_exists(public_path('img/vehicles/' . $booking->vehicle->image)))
                                    <img src="{{ asset('img/vehicles/' . $booking->vehicle->image) }}"
                                        class="img-fluid vehicle-image" class="img-fluid rounded me-3"
                                        style="width: 80px; height: 60px; object-fit: contain;">
                                @else
                                    <img src="{{ asset('img/default/defaultIMG.png') }}" class="img-fluid vehicle-image"
                                        class="img-fluid rounded me-3"
                                        style="width: 80px; height: 60px; object-fit: contain;">

                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 60px;">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $booking->vehicle->name ?? '-' }}</h6>
                                    <small class="text-muted d-block"
                                        style="font-size: 12px;">{{ $booking->vehicle->vehicle_category->name ?? 'Motor' }}</small>
                                </div>
                            </div>

                            <div class="bg-light rounded p-3 mb-4">
                                <h6 class="fw-bold mb-3" style="font-size: 14px;">Ringkasan transaksi</h6>
                                <div class="d-flex justify-content-between mb-2 text-muted" style="font-size: 14px;">
                                    <span>Harga</span>
                                    <span>Rp
                                        {{ number_format($booking->duration_days * $booking->price_per_day, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3 text-muted align-items-start" style="font-size: 14px;">
                                    @php
                                        $baseTotal = $booking->duration_days * $booking->price_per_day;
                                        $percentage = $baseTotal > 0 && $booking->discount_amount > 0 ? round(($booking->discount_amount / $baseTotal) * 100) : 0;
                                    @endphp
                                    <div>
                                        <span>Diskon</span>
                                        @if($percentage > 0)
                                            <small class="text-muted d-block" style="font-size: 12px; line-height: 1.2;">
                                                {{ $activeDiscount ? $activeDiscount->name : 'Potongan Harga' }} ({{ $percentage }}%)
                                            </small>
                                        @endif
                                    </div>
                                    @if($booking->discount_amount > 0)
                                        <span class="text-success text-end">-Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-end">-</span>
                                    @endif
                                </div>
                                <hr style="opacity: 0.1;">
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="text-muted">Total harga</span>
                                    <span class="fw-bold fs-5">Rp
                                        {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            @php
                                if ($booking->status->name == 'paid') {
                                    $btnText = 'Pembayaran Berhasil';
                                    $btnClass = 'btn-success';
                                    $btnIcon = 'bi-check-circle-fill';
                                    $isModal = false;
                                } elseif ($booking->status->name == 'payment_failed') {
                                    $btnText = 'Unggah Ulang Bukti (Ditolak)';
                                    $btnClass = 'btn-danger';
                                    $btnIcon = 'bi-exclamation-circle';
                                    $isModal = true;
                                } elseif ($booking->payment_proof) {
                                    $btnText = 'Menunggu Konfirmasi';
                                    $btnClass = 'btn-info text-white';
                                    $btnIcon = 'bi-clock-history';
                                    $isModal = true;
                                } else {
                                    $btnText = 'Bayar Sekarang';
                                    $btnClass = 'btn-primary';
                                    $btnIcon = 'bi-wallet2';
                                    $isModal = true;
                                }
                            @endphp
                            
                            <button class="btn {{ $btnClass }} w-100 py-2 fw-semibold" style="border-radius: 8px;"
                                @if($isModal) data-bs-toggle="modal" data-bs-target="#paymentModal" @else disabled @endif>
                                <i class="bi {{ $btnIcon }} me-1"></i> {{ $btnText }}
                            </button>
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
                    <p class="text-muted mb-4">Silakan transfer sejumlah <strong>Rp
                            {{ number_format($booking->total_amount, 0, ',', '.') }}</strong> ke rekening di bawah ini:</p>

                    <div class="card bg-light border-0 mb-4 text-start">
                        <div class="card-body p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Bank BCA</span>
                                <span class="fw-bold text-dark">{{ $paymentSetting->bank_bca ?? '0123456789' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Bank Mandiri</span>
                                <span class="fw-bold text-dark">{{ $paymentSetting->bank_mandiri ?? '9876543210' }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Atas Nama</span>
                                <span class="fw-bold text-dark">{{ $paymentSetting->account_name ?? 'Admin Rental Motor' }}</span>
                            </div>
                        </div>
                    </div>

                    @if($booking->status->name == 'payment_failed')
                        <div class="alert alert-danger text-start mb-3" role="alert" style="font-size: 13px;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> <strong>Bukti pembayaran ditolak!</strong><br>
                            Alasan: {{ $booking->payment_notes ?? 'Tidak ada alasan.' }}
                        </div>
                        @if($booking->payment_proof)
                            <div class="text-center mb-3">
                                <a href="{{ route('booking.showProof', $booking->id) }}" target="_blank" title="Klik untuk melihat ukuran penuh">
                                    <img src="{{ route('booking.showProof', $booking->id) }}" alt="Bukti Ditolak" class="img-fluid rounded shadow-sm border border-danger" style="max-height: 150px;">
                                </a>
                                <p class="text-danger mt-1 mb-0" style="font-size: 12px;">(Bukti yang ditolak)</p>
                            </div>
                        @endif
                        <hr>
                        <p class="text-dark fw-bold mb-2" style="font-size: 13px;">Silakan unggah ulang bukti yang benar:</p>
                    @endif

                    @if(!$booking->payment_proof || $booking->status->name == 'payment_failed')
                        @if(!$booking->payment_proof && !$booking->payment_notes)
                            <p class="text-muted" style="font-size: 13px;">Setelah transfer, harap unggah bukti pembayaran di bawah ini atau konfirmasi melalui WhatsApp Admin.</p>
                        @endif

                        <form action="{{ route('booking.uploadProof', $booking->id) }}" method="POST" enctype="multipart/form-data" class="mb-3 text-start">
                            @csrf
                            <div class="mb-2">
                                <label for="payment_proof" class="form-label" style="font-size: 14px;">Upload Bukti Pembayaran</label>
                                <input class="form-control form-control-sm" type="file" id="payment_proof" name="payment_proof" accept="image/*" required>
                                @error('payment_proof')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold mb-2" style="border-radius: 8px;">
                                <i class="bi bi-upload me-2"></i> Unggah Bukti
                            </button>
                        </form>

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
                    @else
                        <div class="alert alert-success text-start" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Bukti pembayaran berhasil diunggah. Menunggu konfirmasi Admin.
                        </div>
                        <div class="text-center mb-3">
                            <a href="{{ route('booking.showProof', $booking->id) }}" target="_blank" title="Klik untuk melihat ukuran penuh">
                                <img src="{{ route('booking.showProof', $booking->id) }}" alt="Bukti Pembayaran" class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                            </a>
                        </div>
                        <p class="text-muted" style="font-size: 13px;">Admin akan segera memverifikasi pembayaran Anda.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success') || $errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modalElement = document.getElementById('paymentModal');
                if (modalElement) {
                    var paymentModal = bootstrap.Modal.getOrCreateInstance(modalElement);
                    paymentModal.show();
                }
            });
        </script>
    @endif
@endsection
