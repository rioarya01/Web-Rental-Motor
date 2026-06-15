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
                                                <td class="fw-bold {{ $b->booking_status_id == '2' ? 'text-success' : 'text-danger' }}">Rp
                                                    {{ number_format($b->total_amount, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span class="badge rounded-pill {{ $b->booking_status_badge }}">
                                                        {{ $b->booking_status_label }}
                                                    </span>
                                                </td>
                                                <td class="text-center d-flex justify-content-center gap-2">
                                                    <button type="button" class="badge bg-primary px-3 py-2 border-0" data-bs-toggle="modal" data-bs-target="#proofModal{{ $b->id }}">
                                                        <i class="bi bi-wallet2 fs-5"></i>
                                                    </button>
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

                                            <!-- Modal Bukti Bayar -->
                                            <div class="modal fade" id="proofModal{{ $b->id }}" tabindex="-1" aria-labelledby="proofModalLabel{{ $b->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="proofModalLabel{{ $b->id }}">Bukti Pembayaran - {{ $b->booking_code }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="row text-start bg-light rounded p-2 mb-3 mx-0">
                                                                <div class="col-12 mb-2">
                                                                    <small class="text-muted d-block mb-1">
                                                                        <i class="bi bi-wrench me-1"></i>
                                                                        Perlengkapan Kendaraan
                                                                    </small>

                                                                    @if(!empty($b->features_snapshot) && count($b->features_snapshot))
                                                                        <div class="d-flex flex-wrap gap-1">
                                                                            @foreach($b->features_snapshot as $feature)
                                                                                <span class="badge bg-info-subtle text-info-emphasis border">
                                                                                    {{ $feature['name'] ?? '-' }}
                                                                                    {{ $feature['qty'] ?? 1 }}
                                                                                    {{ $feature['unit'] ?? '' }}
                                                                                </span>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        <small class="text-dark" style="font-size:13px;">
                                                                            Tidak ada data perlengkapan.
                                                                        </small>
                                                                    @endif
                                                                </div>
                                                                <div class="col-12 mb-2">
                                                                    <small class="text-muted d-block mb-1"><i class="bi bi-geo-alt me-1"></i> Alamat Penjemputan / Pengiriman</small>
                                                                    <span class="text-dark d-block" style="font-size: 13px;">{{ $b->pickup_address ?: 'Tidak ada alamat tambahan yang diisi.' }}</span>
                                                                </div>
                                                                <div class="col-12">
                                                                    <small class="text-muted d-block mb-1"><i class="bi bi-chat-text me-1"></i> Catatan Tambahan</small>
                                                                    <span class="text-dark d-block" style="font-size: 13px;">{{ $b->notes ?: 'Tidak ada catatan tambahan.' }}</span>
                                                                </div>
                                                                @if($b->payment)
                                                                <div class="col-12 mt-2 pt-2 border-top">
                                                                    <small class="text-muted d-block mb-1"><i class="bi bi-credit-card me-1"></i> Metode Pembayaran</small>
                                                                    <span class="text-dark d-block fw-bold" style="font-size: 13px;">
                                                                        @if($b->payment->method === 'cash')
                                                                            <span class="text-success"><i class="bi bi-cash-stack me-1"></i> Uang Tunai (Cash)</span>
                                                                        @else
                                                                            <span class="text-primary"><i class="bi bi-bank me-1"></i> Transfer Bank</span>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <hr style="border-style: dashed; opacity: 0.2;">
                                                            @if($b->payment_proof)
                                                                <a href="{{ route('booking.showProof', $b->id) }}" target="_blank" title="Klik untuk melihat ukuran penuh">
                                                                    <img src="{{ route('booking.showProof', $b->id) }}" alt="Bukti Pembayaran" class="img-fluid rounded mb-3" style="max-height: 400px;">
                                                                </a>
                                                                <p class="text-muted mb-0">Diunggah pada pesanan ini.</p>
                                                                @if($b->booking_status_id == '3')
                                                                    <div class="alert alert-danger mt-2 mb-0 py-2 small text-start">
                                                                        <strong>Ditolak:</strong> {{ $b->payment_notes ?? 'Tidak ada alasan' }}
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="alert alert-warning">
                                                                    Belum ada bukti pembayaran yang diunggah.
                                                                </div>
                                                                <p class="text-muted small">Jika pengguna mengirimkan bukti via WhatsApp, Anda dapat mengunggahnya di sini sebagai arsip.</p>
                                                                
                                                                <form action="{{ route('booking.adminUploadProof', $b->id) }}" method="POST" enctype="multipart/form-data" class="text-start mt-3">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="payment_proof{{ $b->id }}" class="form-label">Unggah Bukti</label>
                                                                        <input class="form-control form-control-sm" type="file" id="payment_proof{{ $b->id }}" name="payment_proof" accept="image/*" required>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary btn-sm w-100">Simpan Bukti Pembayaran</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer justify-content-between flex-wrap">
                                                            @if ($b->booking_status_id == '1')
                                                                <div class="w-100 mb-2">
                                                                    <div class="collapse" id="collapseReject{{ $b->id }}">
                                                                        <form action="{{ route('booking.rejectProof', $b->id) }}" method="POST" class="text-start mb-2">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <label class="form-label text-danger" style="font-size: 13px;">Alasan Penolakan (wajib)</label>
                                                                            <textarea class="form-control mb-2" name="payment_notes" rows="2" placeholder="Contoh: Bukti buram, nominal transfer tidak sesuai..." required></textarea>
                                                                            <button type="submit" class="btn btn-danger btn-sm w-100">Kirim Penolakan</button>
                                                                        </form>
                                                                    </div>
                                                                </div>

                                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="collapse" data-bs-target="#collapseReject{{ $b->id }}" aria-expanded="false" {{ !$b->payment_proof ? 'disabled' : '' }}>
                                                                    Tolak Bukti
                                                                </button>

                                                                <form action="{{ route('booking.updateStatus', $b->id) }}" method="POST" class="w-100 text-start mt-3 p-3 border rounded bg-light">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-2">
                                                                        <label for="payment_method{{ $b->id }}" class="form-label fw-bold" style="font-size: 13px;">Metode Pembayaran</label>
                                                                        <select name="payment_method" id="payment_method{{ $b->id }}" class="form-select form-select-sm">
                                                                            <option value="manual_transfer" selected>Transfer Bank</option>
                                                                            <option value="cash">Uang Tunai (Cash)</option>
                                                                        </select>
                                                                    </div>
                                                                    <button type="submit" class="btn btn-success w-100">Konfirmasi Pembayaran (Lunas)</button>
                                                                </form>

                                                            @elseif(in_array($b->booking_status_id, ['2', '3']))
                                                                @if ($b->booking_status_id == '2')
                                                                    @php
                                                                        $whatsappNumber = preg_replace('/[^0-9]/', '', $b->user->no_telp ?? '');

                                                                        if (substr($whatsappNumber, 0, 1) == '0') {
                                                                            $whatsappNumber = '62' . substr($whatsappNumber, 1);
                                                                        }

                                                                        $message = urlencode('Halo, pembayaran Anda telah diverifikasi dan pesanan telah dikonfirmasi. Silahkan segera datang ke lokasi. Terimakasih.');
                                                                    @endphp

                                                                    <a href="https://wa.me/{{ $whatsappNumber }}?text={{ $message }}" target="_blank" class="btn btn-success w-100 mb-2">
                                                                        <i class="bi bi-whatsapp me-2"></i>
                                                                        Chat WhatsApp Customer
                                                                    </a>
                                                                @endif

                                                                <form action="{{ route('booking.cancel', $b->id) }}" method="POST" class="w-100">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit" class="btn btn-outline-secondary w-100" onclick="return confirm('Apakah Anda yakin ingin membatalkan keputusan ini? Status akan dikembalikan seperti semula.');">
                                                                        Batalkan Keputusan
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Modal -->
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
