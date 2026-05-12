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

<div class="container" style="padding: 100px 0;">
    <div class="vehicle-wrapper">
        <div class="row g-4">
            <!-- LEFT -->
            <div class="col-lg-4">
                <img
                    src="{{ asset('img/vehicles/' . $vehicle->image) }}"
                    class="vehicle-image"
                    alt="{{ $vehicle->name }}"
                >
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
            </div>

            <!-- RIGHT -->
            <div class="col-lg-8">
                <h1 class="vehicle-title">{{ $vehicle->name }}</h1>
                <div class="mb-4">
                    <span style="{{ $vehicle->operational_status_color }}"
                        class="px-2 py-1 text-xs fw-semibold rounded">
                        {{ $vehicle->operational_status_label }}
                    </span>
                </div>
                <p class="vehicle-desc">
                    {{ $vehicle->description ?? 'Tidak ada deskripsi untuk kendaraan ini.' }}
                </p>
                <hr class="border border-dark">
                <div class="section-title">
                    Perlengkapan:
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <ul class="equipment-list">
                            <li>Bensin 1 liter</li>
                            <li>Helm SNI 2 buah</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="equipment-list">
                            <li>Jas hujan 2 buah</li>
                            <li>STNK</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="equipment-list">
                            <li>Tas belanja 1 buah</li>
                            <li>Sarung tangan 1 buah</li>
                        </ul>
                    </div>
                </div>
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
</div>
@endsection