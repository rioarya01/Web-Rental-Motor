@extends('layouts.main')
@section('title', 'Sewa Kendaraan')
@section('content')
<main id="main" class="main" style="margin: 8vh">
    <div class="container">
        <div class="pagetitle">
            <h1>Sewa Kendaraan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.user') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('home.user') }}">Pilih Kendaraan</a></li>
                    <li class="breadcrumb-item active">Sewa</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #f9fbfd;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold">Formulir Penyewaan</h5>

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('booking.store', $vehicle->slug) }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <label for="rent_start" class="col-sm-3 col-form-label">Tanggal & Jam Ambil</label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" class="form-control" id="rent_start" name="rent_start" value="{{ old('rent_start', \Carbon\Carbon::tomorrow()->format('Y-m-d\T06:00')) }}" required min="{{ \Carbon\Carbon::now()->addHours(24)->format('Y-m-d\TH:i') }}">
                                        <small class="text-muted d-block mt-1">* Pemesanan wajib <strong>minimal 1x24 jam</strong> sebelum waktu penggunaan.</small>
                                        <small class="text-muted d-block">* Jam operasional pengambilan kendaraan pukul 06:00 - 22:00</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="duration_days" class="col-sm-3 col-form-label">Durasi Sewa</label>
                                    <div class="col-sm-9">
                                        <select class="form-select mb-1" id="duration_days" name="duration_days" required>
                                            <option value="1">1 Hari</option>
                                            <option value="2">2 Hari</option>
                                            <option value="3">3 Hari</option>
                                            <option value="4">4 Hari</option>
                                            <option value="5">5 Hari</option>
                                        </select>
                                        <small class="text-primary d-block fw-semibold mb-1">* 1 hari dihitung 24 jam. Waktu pengembalian menyesuaikan jam pengambilan.</small>
                                        <small class="text-danger fw-bold" id="end_date_display">Selesai: -</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="pickup_address" class="col-sm-3 col-form-label">Alamat Pengambilan / Pengiriman</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="pickup_address" name="pickup_address" rows="3" required placeholder="Tuliskan alamat lengkap">{{ old('pickup_address') }}</textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="notes" class="col-sm-3 col-form-label">Catatan Tambahan (Opsional)</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Cth: Helm 2, Jas hujan 2">{{ old('notes') }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
                                        <a href="{{ route('home.user') }}" class="btn btn-secondary">Batal</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="border-radius: 12px; top: 100px;">
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold">Ringkasan Kendaraan</h5>
                            @if ($vehicle->image)
                                <img src="{{ asset('img/vehicles/' . $vehicle->image) }}" class="img-fluid rounded mb-3" alt="{{ $vehicle->name }}">
                            @endif
                            <h6 class="fw-bold">{{ $vehicle->name }}</h6>
                            <p class="text-secondary small mb-1">{{ $vehicle->vehicle_category->name ?? '-' }} | {{ $vehicle->vehicle_brand->name ?? '-' }}</p>
                            <hr>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Harga / Hari:</span>
                                <span class="fw-semibold">Rp {{ number_format($vehicle->price_per_day, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Estimasi Durasi:</span>
                                <span class="fw-semibold" id="duration_display">- Hari</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-primary">Estimasi Total:</span>
                                <span class="fw-bold text-primary fs-5" id="total_display">Rp 0</span>
                            </div>
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
        const totalDisplay = document.getElementById('total_display');
        const endDateDisplay = document.getElementById('end_date_display');
        const pricePerDay = {{ $vehicle->price_per_day }};

        const days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        function calculateTotal() {
            if (durationInput.value && startInput.value) {
                const diffDays = parseInt(durationInput.value);
                const total = diffDays * pricePerDay;
                
                durationDisplay.textContent = diffDays + ' Hari';
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
                
                endDateDisplay.textContent = `Batas Pengembalian: ${dayName}, ${date} ${monthName} ${startDate.getFullYear()} pukul ${hours}:${minutes}`;
            } else {
                durationDisplay.textContent = '- Hari';
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
