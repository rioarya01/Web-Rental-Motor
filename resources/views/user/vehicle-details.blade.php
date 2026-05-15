@extends('layouts.main')
@section('title', $vehicle->name)
@section('content')
<style>
    .vehicle-wrapper{
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
    }

    .vehicle-image{
        width: 100%;
        object-fit: contain;
    }

    .vehicle-title{
        font-size: 32px;
        font-weight: 700;
    }

    .status{
        color: #84cc16;
        font-size: 14px;
        font-weight: 500;
    }

    .vehicle-desc{
        color: #6b7280;
        line-height: 1.9;
        font-size: 15px;
    }

    .spec-label{
        color: #94a3b8;
        font-size: 15px;
    }

    .spec-value{
        font-weight: 500;
        color: #475569;
        text-align: right;
    }

    .section-title{
        color: #94a3b8;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .equipment-list{
        color: #94a3b8;
        line-height: 2;
        font-size: 14px;
    }

    .price{
        font-size: 42px;
        font-weight: 700;
    }

    .price small{
        font-size: 16px;
        color: #94a3b8;
        font-weight: 500;
    }

    .btn-book{
        background: #3867f4;
        border: none;
        border-radius: 6px;
        padding: 14px 40px;
        font-weight: 600;
    }

    .btn-book:hover{
        background: #2f5ae0;
    }

    /* MOBILE */
    @media (max-width: 768px){

        .vehicle-wrapper{
            margin: 0 12px;
            padding: 18px;
        }

        .vehicle-title{
            font-size: 28px;
            margin-bottom: 12px;
        }

        .vehicle-desc{
            font-size: 14px;
            line-height: 1.8;
        }

        .price{
            font-size: 28px;
        }

        .btn-book{
            width: 100%;
            padding: 12px;
        }
    }
</style>

{{-- Heading --}}
<section class="container" style="margin-top: 150px;">
    {{-- Heading --}}
    <div>
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            Detail Kendaraan
        </h2>
        <p class="text-gray-600">
            Lihat detail lengkap kendaraan yang ingin Anda sewa, mulai dari spesifikasi, harga, hingga fasilitas yang tersedia.
        </p>
    </div>
</section>
{{-- Vehicle Details --}}
<section class="container" style="padding: 50px 0;">
    <div class="vehicle-wrapper">
        <div class="row">
            <!-- LEFT -->
            <div class="col-lg-5">
                <img
                    src="{{ asset('img/vehicles/' . $vehicle->image) }}"
                    class="vehicle-image"
                    alt="{{ $vehicle->name }}"
                >
            </div>
            <!-- RIGHT -->
            <div class="col-lg-7">
                <h1 class="vehicle-title">{{ $vehicle->name }}</h1>
                <div class="mb-4">
                    <span style="{{ $vehicle->operational_status_color }}"
                        class="px-2 py-1 text-xs fw-semibold rounded">
                        {{ $vehicle->operational_status_label }}
                    </span>
                </div>
                <div class="mt-4">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="spec-label">Brand</span>
                        <span class="spec-value">{{ $vehicle->vehicle_brand->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="spec-label">Tipe</span>
                        <span class="spec-value">{{ $vehicle->vehicle_category->name ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="spec-label">Kapasitas Tangki</span>
                        <span class="spec-value">{{ $vehicle->fuel_tank_capacity ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="spec-label">No. Plat</span>
                        <span class="spec-value">{{ $vehicle->plate_number ?? '-' }}</span>
                    </div>
                </div>
                <p class="vehicle-desc mt-4">
                    {{ $vehicle->description ?? 'Tidak ada deskripsi untuk kendaraan ini.' }}
                </p>
                <hr class="border border-dark">
                <div class="booking-wrapper mt-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div class="price">
                            Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                            <small>/ hari</small>
                        </div>
                        <button class="btn btn-primary btn-book">
                            Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection