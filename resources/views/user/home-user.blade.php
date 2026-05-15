@extends('layouts.main')
@section('title', 'Home')
@section('content')
<style>
    /* HERO SECTION */
    .hero-section {
        position: relative;
        min-height: 92vh;
        background-image: url('/img/hero-banner.webp');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(
            90deg,
            rgba(0,0,0,0.72) 0%,
            rgba(0,0,0,0.42) 42%,
            rgba(0,0,0,0.12) 100%
        );
    }

    .hero-content {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 720px;
        padding-left: 7%;
        padding-right: 1.5rem;
        padding-top: 80px;
    }

    .hero-title {
        font-size: clamp(2.2rem, 4vw, 3.7rem);
        line-height: 1.15;
        letter-spacing: -1px;
        margin-bottom: 1.5rem;
    }

    .hero-subtitle {
        max-width: 520px;
        font-size: 1.05rem;
        line-height: 1.8;
        color: rgba(255,255,255,0.92);
        margin-bottom: 2rem;
    }

    .hero-content .btn {
        min-width: 185px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }

    @media (max-width: 992px) {
        .hero-section {
            min-height: 82vh;
            background-position: 62% center;
        }

        .hero-content {
            padding-left: 2rem;
            padding-right: 2rem;
            padding-top: 100px;
        }

        .hero-title {
            font-size: 2.7rem;
        }
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 74vh;
            background-position: 68% center;
        }

        .hero-content {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
            padding-top: 90px;
        }

        .hero-title {
            font-size: 2.1rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 0.98rem;
            line-height: 1.7;
        }

        .hero-content .btn {
            min-width: unset;
            width: 100%;
        }
    }

    /* HOW IT WORKS SECTION */
    .how-title {
        font-size: clamp(1.8rem, 3vw, 3rem);
        line-height: 1.2;
    }

    .how-subtitle {
        max-width: 700px;
        font-size: 1rem;
    }

    .how-card {
        background: #fff;
        border: 1px solid #dbe3ef;
        border-radius: 15px;
        padding: 1.5rem;
        transition: 0.3s ease;
    }

    .how-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    }

    .how-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        border-radius: 12px;
        background: rgba(13,110,253,0.12);
        color: #0d6efd;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    @media (max-width: 768px) {
        .how-title {
            font-size: 2rem;
        }

        .how-card {
            padding: 1.25rem;
            border-radius: 10px;
        }
    }
</style>

<main class="justify-content-center">
    <!-- Hero Section -->
    <section class="hero-section position-relative overflow-hidden">
        <!-- Overlay -->
        <div class="hero-overlay"></div>
        <!-- Content -->
        <div class="hero-content position-relative text-white d-flex flex-column justify-content-center">
            <h1 class="hero-title fw-bold lh-sm mb-4">
                Rental Motor Cepat & Aman,
                <br>
                Mulai Rp75.000/hari
            </h1>
            <p class="hero-subtitle mb-4">
                Pilihan terlengkap, harga transparan,
                dan layanan 24 jam.
                Siap menemani setiap petualangan Anda.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('vehicles-list.index') }}" class="btn btn-primary rounded-3 px-4 py-2 fw-semibold">
                    Lihat Kendaraan
                </a>
            </div>
        </div>
    </section>
    {{-- How It Works Section --}}
    <section class="container" style="margin-top: 100px;">
        {{-- Heading --}}
        <div class="mb-3 mb-md-5">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Mulai Petualangan Anda dalam 3 Langkah Mudah
            </h2>
            <p class="text-gray-600">
                Tidak perlu repot! Proses penyewaan motor tercepat, paling aman, dan transparan.    
            </p>
        </div>
        <!-- Steps -->
        <div class="row g-3">
            <!-- Item -->
            <div class="col-lg-4">
                <div class="how-card h-100 d-flex align-items-start gap-3">
                    <div class="how-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">
                            Pilih & Booking
                        </h5>
                        <p class="mb-0 text-secondary">
                            Pilih motor impian Anda dan tentukan tanggal rental.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-lg-4">
                <div class="how-card h-100 d-flex align-items-start gap-3">
                    <div class="how-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">
                            Konfirmasi & Pembayaran
                        </h5>
                        <p class="mb-0 text-secondary">
                            Selesaikan pembayaran dan dapatkan konfirmasi instan via email/WhatsApp.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Item -->
            <div class="col-lg-4">
                <div class="how-card h-100 d-flex align-items-start gap-3">
                    <div class="how-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-2">
                            Ambil / Diantar
                        </h5>
                        <p class="mb-0 text-secondary">
                            Ambil motor di lokasi kami, atau konfirmasi melalui whatsapp untuk diantar ke lokasi Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Vehicle List Section --}}
    <section class="container" style="margin-top: 50px;">
        {{-- Heading --}}
        <div class="mb-3 mb-md-5">
            {{-- Heading Desktop --}}
            <div class="d-none d-md-flex justify-content-between align-items-center">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Pilihan  Motor Terpopuler
                </h2>
                {{-- View All Button Desktop --}}
                <a href="{{ route('vehicles-list.index') }}" class="text-primary">Lihat semua</a>
            </div>
            {{-- Heading Mobile --}}
            <div class="d-flex d-md-none justify-content-between align-items-center">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Pilihan  Motor Terpopuler
                </h2>
            </div>
            <p class="text-gray-600">
                Pilih kendaraan yang paling sesuai dengan gaya perjalanan dan budget Anda. Semua motor terawat, siap jalan!    
            </p>
        </div>
        <!-- Vehicle List -->
        <div class="row g-4">
            @forelse ($vehicles as $vehicle)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3 vehicle-card">
                        {{-- Header --}}
                        <div >
                            <h5 class="fw-bold fs-4 mb-1">{{ $vehicle->name }}</h5>

                            <p class="text-secondary mb-0">
                                {{ $vehicle->vehicle_category->name ?? '-' }}
                            </p>
                        </div>

                        {{-- Image --}}
                        <div class="text-center my-3">
                            @if ($vehicle->image)
                                <img src="{{ asset('img/vehicles/' . $vehicle->image) }}"
                                    alt="{{ $vehicle->name }}"
                                    class="img-fluid vehicle-image">
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="d-flex justify-content-between align-items-center text-secondary small mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-credit-card-2-front"></i>
                                <span>{{ $vehicle->plate_number ?? 'AB1234CD' }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-1 px-2 py-1 rounded-2"
                                style="{{ $vehicle->operational_status_color }}">
                                {{ $vehicle->operational_status_label }}
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="d-block justify-content-between align-items-end my-auto gap-2">
                            <div>
                                <h3 class="fw-bold mb-3">
                                    Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                    <span class="fs-6 text-secondary fw-normal">/day</span>
                                </h3>
                            </div>
                            <div class="d-flex gap-2 w-100">
                                <a href="{{ route('vehicle-detail.show', $vehicle->slug) }}"
                                    class="btn btn-outline-primary rounded-3 w-100">
                                    View Details
                                </a>
                                <button class="btn btn-primary rounded-3 w-100">
                                    Booking
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-secondary">
                        Kendaraan tidak tersedia.
                    </p>
                </div>
            @endforelse
        </div>
        {{-- View All Button Mobile --}}
        <div class="d-flex d-md-none justify-content-center mt-4">
            <a href="{{ route('vehicles-list.index') }}" class="text-primary">Lihat semua</a>
        </div>
    </section>
    {{-- Terms and Conditions Section--}}
    <section class="container" style="margin-top: 50px; margin-bottom: 100px;">
        <div class="space-y-4 text-justify">
            <!-- Title -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Syarat & Ketentuan Rental Motor
                </h2>
                <p class="text-md text-gray-600 mt-3">
                    Transparansi adalah kunci. Pastikan Anda memenuhi beberapa persyaratan dasar sebelum
                    melakukan pemesanan.
                </p>
            </div>
            <!-- Content -->
            <ol class="list-decimal space-y-3 text-md text-gray-700">
                <li>
                    Lakukan pemesanan minimal 1x24 jam sebelum waktu penggunaan. Setelah pesanan dikonfirmasi,
                    penyewa wajib melakukan konfirmasi pengambilan motor melalui nomor WhatsApp atau datang ke
                    lokasi Sewa Motor ID.
                </li>
                <li>
                    Membawa <b>2 kartu identitas</b> (SIM A, KK, KTP, ID Kerja atau ID Pelajar).
                </li>
                <li>
                    Menyertakan akun sosial media dan <b>nomor whatsApp</b> yang aktif.
                </li>
                <li>
                    Pada saat serah terima kendaraan, pihak penyedia rental akan melakukan <b>pengecekan
                        keaslian data</b> dan kondisi kendaraan.
                </li>
                <li>
                    Pihak penyedia rental <b>berhak membatalkan</b> apabila data tidak sesuai dan syarat sewa
                    tidak dapat dilengkapi.
                </li>
                <li>
                    Apabila pembayaran telah selesai dan kendaraan yang dipesan tidak tersedia, penyewa
                    <b>berhak memilih kendaraan lain</b> yang tersedia tanpa dikenakan biaya tambahan.
                </li>
            </ol>
        </div>
    </section>
</main>
@endsection
