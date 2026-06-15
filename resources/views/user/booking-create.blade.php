@extends('layouts.main')
@section('title', 'Sewa Kendaraan')
@section('content')
    <main class="justify-content-center" style="margin-top: 120px;">
        <div class="container">
            <div class="mb-3 mb-md-5">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Sewa Kendaraan</h2>
                <p class="text-gray-600">Lengkapi form berikut untuk melanjutkan pemesanan kendaraan Anda.</p>
            </div>

            <section>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <h5 class="card-title fw-bold mb-4">Formulir Penyewaan</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ isset($booking) ? route('booking.update', $booking->id) : route('booking.store', $vehicle->slug) }}" method="POST">
                                @csrf
                                @if(isset($booking))
                                    @method('PUT')
                                @endif
                                <div class="row mb-3">
                                    <label for="rent_start" class="col-sm-3 col-form-label">Tanggal & Jam Ambil</label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" class="form-control" id="rent_start" name="rent_start"
                                            value="{{ old('rent_start', isset($booking) ? \Carbon\Carbon::parse($booking->rent_start)->format('Y-m-d\TH:i') : \Carbon\Carbon::tomorrow()->format('Y-m-d\T06:00')) }}"
                                            required min="{{ \Carbon\Carbon::now()->addHours(24)->format('Y-m-d\TH:i') }}">
                                        <small class="text-muted d-block mt-1">* Pemesanan wajib <strong>minimal 1x24
                                                jam</strong> sebelum waktu penggunaan.</small>
                                        <small class="text-muted d-block">* Jam operasional pengambilan kendaraan pukul
                                            06:00 - 22:00</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="duration_days" class="col-sm-3 col-form-label">Durasi Sewa</label>
                                    <div class="col-sm-9">
                                        <select class="form-select mb-1" id="duration_days" name="duration_days" required>
                                            <option value="1" {{ old('duration_days', $booking->duration_days ?? '') == '1' ? 'selected' : '' }}>1 Hari</option>
                                            <option value="2" {{ old('duration_days', $booking->duration_days ?? '') == '2' ? 'selected' : '' }}>2 Hari</option>
                                            <option value="3" {{ old('duration_days', $booking->duration_days ?? '') == '3' ? 'selected' : '' }}>3 Hari</option>
                                            <option value="4" {{ old('duration_days', $booking->duration_days ?? '') == '4' ? 'selected' : '' }}>4 Hari</option>
                                            <option value="5" {{ old('duration_days', $booking->duration_days ?? '') == '5' ? 'selected' : '' }}>5 Hari</option>
                                        </select>
                                        <small class="text-primary d-block fw-semibold mb-1">* 1 hari dihitung 24 jam.
                                            Waktu pengembalian menyesuaikan jam pengambilan.</small>
                                        <small class="text-danger fw-bold" id="end_date_display">Selesai: -</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">
                                        Perlengkapan Kendaraan
                                    </label>

                                    <div class="col-sm-9">
                                        @if($vehicle->features->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($vehicle->features as $feature)
                                                    <span
                                                        class="badge rounded-1 border border-primary-subtle bg-primary-subtle text-primary-emphasis text-wrap px-3 py-2 fw-normal">
                                                        {{ $feature->name }}

                                                        @if($feature->pivot->qty && $feature->unit)
                                                            ({{ $feature->pivot->qty }} {{ $feature->unit->name }})
                                                        @elseif($feature->pivot->qty)
                                                            ({{ $feature->pivot->qty }})
                                                        @elseif($feature->unit)
                                                            ({{ $feature->unit->name }})
                                                        @endif
                                                    </span>
                                                @endforeach
                                            </div>

                                            <small class="d-block mt-2 text-muted">
                                                Perlengkapan di atas sudah termasuk dalam penyewaan kendaraan.
                                            </small>
                                        @else
                                            <small class="text-muted">
                                                Belum ada perlengkapan untuk kendaraan ini.
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="pickup_address" class="col-sm-3 col-form-label">Alamat Pengambilan / Pengiriman</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="pickup_address" name="pickup_address" rows="3" required
                                            placeholder="Tuliskan alamat lengkap">{{ old('pickup_address', $booking->pickup_address ?? '') }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="notes" class="col-sm-3 col-form-label">Catatan Tambahan
                                        (Opsional)</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Cth: Helm 2, Jas hujan 2">{{ old('notes', $booking->notes ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">{{ isset($booking) ? 'Simpan Perubahan' : 'Konfirmasi Pesanan' }}</button>
                                        <a href="{{ isset($booking) ? route('booking.checkout', $booking->id) : route('home.user') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                            <h5 class="card-title fw-bold mb-4">Ringkasan Kendaraan</h5>
                            @if ($vehicle->image && file_exists(public_path('storage/' . $vehicle->image)))
                                <img src="{{ asset('storage/' . $vehicle->image) }}" class="img-fluid vehicle-image">
                            @elseif ($vehicle->image && file_exists(public_path('img/vehicles/' . $vehicle->image)))
                                <img src="{{ asset('img/vehicles/' . $vehicle->image) }}" class="img-fluid vehicle-image">
                            @else
                                <img src="{{ asset('img/default/defaultIMG.png') }}" class="img-fluid vehicle-image">
                            @endif
                            <h6 class="fw-bold">{{ $vehicle->name }}</h6>
                            <p class="text-secondary small mb-1">{{ $vehicle->vehicle_category->name ?? '-' }} |
                                {{ $vehicle->vehicle_brand->name ?? '-' }}</p>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Harga / Hari:</span>
                                <span class="fw-semibold">Rp
                                    {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Estimasi Durasi:</span>
                                <span class="fw-semibold" id="duration_display">- Hari</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 align-items-start">
                                <div>
                                    <span>Diskon:</span>
                                    @if($activeDiscount)
                                        <small class="text-muted d-block" style="font-size: 12px; line-height: 1.2;">
                                            {{ $activeDiscount->name }} ({{ $activeDiscount->percentage }}%)
                                        </small>
                                    @endif
                                </div>
                                <span class="fw-semibold text-success text-end" id="discount_display">-Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-primary">Estimasi Total:</span>
                                <span class="fw-bold text-primary fs-5" id="total_display">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startInput = document.getElementById('rent_start');
            const durationInput = document.getElementById('duration_days');
            const durationDisplay = document.getElementById('duration_display');
            const discountDisplay = document.getElementById('discount_display');
            const totalDisplay = document.getElementById('total_display');
            const endDateDisplay = document.getElementById('end_date_display');
            const pricePerDay = {{ $vehicle->price_per_day }};
            const discountPercentage = {{ $activeDiscount ? $activeDiscount->percentage : 0 }};

            const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];

            function calculateTotal() {
                if (durationInput.value && startInput.value) {
                    const diffDays = parseInt(durationInput.value);
                    const baseTotal = diffDays * pricePerDay;
                    const discountAmount = (baseTotal * discountPercentage) / 100;
                    const total = baseTotal - discountAmount;

                    durationDisplay.textContent = diffDays + ' Hari';
                    if (discountAmount > 0) {
                        discountDisplay.textContent = '-Rp ' + discountAmount.toLocaleString('id-ID');
                    } else {
                        discountDisplay.textContent = '-';
                    }
                    totalDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID');

                    // Hitung End Date
                    const startDate = new Date(startInput.value);
                    startDate.setDate(startDate.getDate() + diffDays);
                    const dayName = days[startDate.getDay()];
                    const date = startDate.getDate();
                    const monthName = months[startDate.getMonth()];

                    // Ambil jam dan menit dengan format 00:00
                    const hours = String(startDate.getHours()).padStart(2, '0');
                    const minutes = String(startDate.getMinutes()).padStart(2, '0');

                    endDateDisplay.textContent =
                        `Batas Pengembalian: ${dayName}, ${date} ${monthName} ${startDate.getFullYear()} pukul ${hours}:${minutes}`;
                } else {
                    durationDisplay.textContent = '- Hari';
                    discountDisplay.textContent = '-Rp 0';
                    totalDisplay.textContent = 'Rp 0';
                    endDateDisplay.textContent = 'Batas Pengembalian: -';
                }
            }

            durationInput.addEventListener('change', calculateTotal);
            startInput.addEventListener('change', calculateTotal);

            // Kalkulasi di awal
            calculateTotal();
        });
    </script>
@endsection
