@extends('layouts.main')
@section('title', $vehicle->name)
@section('content')
    <style>
        .vehicle-heading-section {
            margin-top: 150px;
        }

        .vehicle-detail-section {
            padding: 50px 0;
        }

        .vehicle-wrapper {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .vehicle-wrapper > .row {
            min-height: 570px;
        }

        /* LEFT COLUMN */
        .vehicle-left-column {
            display: flex;
            flex-direction: column;
            padding: 32px;
            background: #f8fafc;
            border-right: 1px solid #e5e7eb;
        }

        .vehicle-header {
            margin-bottom: 20px;
        }

        .vehicle-title {
            margin: 0 0 12px;
            color: #0f172a;
            font-size: 32px;
            font-weight: 700;
            line-height: 1.3;
        }

        .vehicle-status {
            display: flex;
            align-items: center;
        }

        .status {
            color: #84cc16;
            font-size: 14px;
            font-weight: 500;
        }

        .vehicle-image-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 310px;
            padding: 14px;
            margin-bottom: 24px;
        }

        .vehicle-image {
            display: block;
            width: 100%;
            max-width: 450px;
            max-height: 350px;
            object-fit: contain;
        }

        .vehicle-specification {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 28px;
            width: 100%;
        }

        .spec-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            min-width: 0;
            padding: 13px 0;
            border-bottom: 1px solid #dfe5ec;
        }

        .spec-label {
            flex-shrink: 0;
            color: #94a3b8;
            font-size: 14px;
        }

        .spec-value {
            min-width: 0;
            color: #334155;
            font-size: 14px;
            font-weight: 500;
            text-align: right;
            overflow-wrap: anywhere;
        }

        /* RIGHT COLUMN */
        .vehicle-content-column {
            display: flex;
            flex-direction: column;
            padding: 38px 40px;
        }

        .description-wrapper {
            width: 100%;
        }

        .content-title,
        .section-title {
            margin-bottom: 14px;
            color: #64748b;
            font-size: 15px;
            font-weight: 600;
        }

        .vehicle-desc {
            margin: 0;
            color: #6b7280;
            font-size: 15px;
            line-height: 1.9;
        }

        .vehicle-divider {
            margin: 28px 0;
            border-color: #e2e8f0 !important;
            opacity: 1;
        }

        /* EQUIPMENT */
        .equipment-wrapper {
            width: 100%;
        }

        .equipment-list {
            --bs-gutter-x: 24px;
            --bs-gutter-y: 10px;
            font-size: 14px;
        }

        .equipment-item {
            display: flex;
            align-items: flex-start;
            color: #75a2ff;
            font-size: 14px;
            line-height: 1.7;
        }

        .equipment-dot {
            flex-shrink: 0;
            color: #3867f4;
            font-size: 17px;
            font-weight: 700;
            line-height: 1.4;
        }

        .equipment-empty {
            padding: 12px 0;
            color: #94a3b8;
            font-size: 14px;
        }

        /* BOOKING */
        .booking-wrapper {
            position: static;
            margin-top: auto;
        }

        .booking-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .price {
            color: #0f172a;
            font-size: 38px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
        }

        .price small {
            color: #94a3b8;
            font-size: 16px;
            font-weight: 500;
        }

        .btn-book {
            min-width: 150px;
            padding: 14px 40px;
            background: #3867f4;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
        }

        .btn-book:hover {
            background: #2f5ae0;
        }

        .btn-book.btn-secondary {
            background: #64748b;
        }

        .btn-book.btn-secondary:hover {
            background: #64748b;
        }

        .btn-book:disabled {
            cursor: not-allowed;
        }

        /* LAPTOP */
        @media (max-width: 1199.98px) {
            .vehicle-left-column {
                padding: 28px;
            }

            .vehicle-content-column {
                padding: 34px 32px;
            }

            .vehicle-specification {
                grid-template-columns: 1fr;
            }

            .price {
                font-size: 34px;
            }
        }

        /* TABLET */
        @media (max-width: 991.98px) {
            .vehicle-wrapper > .row {
                min-height: auto;
            }

            .vehicle-left-column {
                padding: 30px;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }

            .vehicle-image-box {
                min-height: 320px;
            }

            .vehicle-image {
                max-width: 480px;
                max-height: 350px;
            }

            .vehicle-specification {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .vehicle-content-column {
                min-height: 420px;
                padding: 32px 30px;
            }
        }

        /* MOBILE */
        @media (max-width: 767.98px) {
            .vehicle-heading-section {
                margin-top: 120px;
                padding-right: 16px;
                padding-left: 16px;
            }

            .vehicle-heading-section p {
                font-size: 14px;
                line-height: 1.7;
            }

            .vehicle-detail-section {
                padding: 30px 16px;
            }

            .vehicle-wrapper {
                padding: 0 12px 0 12px;
                border-radius: 12px;
            }

            .vehicle-left-column {
                padding: 24px 20px;
                background: #ffffff;
            }

            .vehicle-header {
                margin-bottom: 18px;
            }

            .vehicle-title {
                font-size: 28px;
            }

            .vehicle-image-box {
                min-height: 260px;
                padding: 10px;
                margin-bottom: 20px;
            }

            .vehicle-image {
                max-height: 280px;
            }

            .vehicle-specification {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                column-gap: 20px;
            }

            .spec-item {
                padding: 12px 0;
            }

            .vehicle-content-column {
                min-height: auto;
                padding: 26px 20px;
            }

            .vehicle-desc {
                font-size: 14px;
                line-height: 1.8;
            }

            .vehicle-divider {
                margin: 22px 0;
            }

            .equipment-list {
                --bs-gutter-x: 16px;
                --bs-gutter-y: 8px;
            }

            .booking-wrapper {
                position: static;
                width: 100%;
                margin-top: 0;
            }

            .booking-content {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }

            .price {
                flex-shrink: 0;
                font-size: 28px;
                white-space: nowrap;
            }

            .price small {
                font-size: 14px;
            }

            .btn-book {
                width: auto;
                min-width: 130px;
                padding: 13px 24px;
            }
        }

        /* SMALL MOBILE */
        @media (max-width: 575.98px) {
            .vehicle-heading-section {
                margin-top: 110px;
                padding-right: 16px;
                padding-left: 16px;
            }

            .vehicle-detail-section {
                padding: 24px 16px;
            }

            .vehicle-left-column {
                padding: 22px 18px;
            }

            .vehicle-title {
                font-size: 24px;
            }

            .vehicle-image-box {
                min-height: 220px;
                padding: 6px;
                margin-bottom: 18px;
            }

            .vehicle-image {
                max-height: 240px;
            }

            .vehicle-specification {
                grid-template-columns: 1fr;
            }

            .spec-label {
                max-width: 45%;
                font-size: 14px;
            }

            .spec-value {
                max-width: 55%;
                font-size: 14px;
            }

            .vehicle-content-column {
                padding: 24px 18px;
            }

            .equipment-item {
                font-size: 14px;
            }

            .booking-content {
                gap: 12px;
            }

            .price {
                font-size: 25px;
            }

            .price small {
                font-size: 13px;
            }

            .btn-book {
                min-width: 120px;
                padding: 12px 20px;
                font-size: 14px;
            }
        }

        /* VERY SMALL MOBILE */
        @media (max-width: 390px) {
            .vehicle-detail-section {
                padding-right: 12px;
                padding-left: 12px;
            }

            .vehicle-left-column,
            .vehicle-content-column {
                padding-right: 16px;
                padding-left: 16px;
            }

            .booking-content {
                gap: 10px;
            }

            .price {
                font-size: 22px;
            }

            .price small {
                font-size: 12px;
            }

            .btn-book {
                min-width: 105px;
                padding: 11px 16px;
            }
        }
    </style>

    {{-- Heading --}}
    <section class="container vehicle-heading-section">
        <div>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Detail Kendaraan
            </h2>

            <p class="text-gray-600">
                Lihat detail lengkap kendaraan yang ingin Anda sewa, mulai dari spesifikasi, harga, hingga fasilitas yang
                tersedia.
            </p>
        </div>
    </section>

    {{-- Vehicle Details --}}
    <section class="container vehicle-detail-section">
        <div class="vehicle-wrapper">
            <div class="row g-0">
                <!-- LEFT -->
                <div class="col-lg-5 vehicle-left-column">
                    <div class="vehicle-header">
                        <h1 class="vehicle-title">{{ $vehicle->name }}</h1>

                        <div class="vehicle-status">
                            <span style="{{ $vehicle->operational_status_color }}"
                                class="px-2 py-1 text-xs fw-semibold rounded">
                                {{ $vehicle->operational_status_label }}
                            </span>
                        </div>
                    </div>

                    <div class="vehicle-image-box">
                        @if ($vehicle->image && file_exists(public_path('storage/' . $vehicle->image)))
                            <img src="{{ asset('storage/' . $vehicle->image) }}" class="img-fluid vehicle-image"
                                alt="{{ $vehicle->name }}">
                        @elseif ($vehicle->image && file_exists(public_path('img/vehicles/' . $vehicle->image)))
                            <img src="{{ asset('img/vehicles/' . $vehicle->image) }}" class="img-fluid vehicle-image"
                                alt="{{ $vehicle->name }}">
                        @else
                            <img src="{{ asset('img/default/defaultIMG.png') }}" class="img-fluid vehicle-image"
                                alt="Gambar kendaraan tidak tersedia">
                        @endif
                    </div>

                    <div class="vehicle-specification">
                        <div class="spec-item">
                            <span class="spec-label">Brand</span>
                            <span class="spec-value">
                                {{ $vehicle->vehicle_brand->name ?? '-' }}
                            </span>
                        </div>

                        <div class="spec-item">
                            <span class="spec-label">Tipe</span>
                            <span class="spec-value">
                                {{ $vehicle->vehicle_category->name ?? '-' }}
                            </span>
                        </div>

                        <div class="spec-item">
                            <span class="spec-label">Kapasitas Tangki</span>
                            <span class="spec-value">
                                {{ $vehicle->fuel_tank_capacity ?? '-' }}
                            </span>
                        </div>

                        <div class="spec-item">
                            <span class="spec-label">No. Plat</span>
                            <span class="spec-value">
                                {{ $vehicle->plate_number ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-lg-7 vehicle-content-column">
                    <div class="description-wrapper">
                        <div class="content-title">
                            Deskripsi:
                        </div>

                        <p class="vehicle-desc">
                            {{ $vehicle->description ?? 'Tidak ada deskripsi untuk kendaraan ini.' }}
                        </p>
                    </div>

                    <hr class="vehicle-divider border-secondary-subtle">

                    <div class="equipment-wrapper">
                        <div class="section-title">
                            Perlengkapan Kendaraan
                        </div>

                        <div class="row equipment-list">
                            @forelse($vehicle->features as $feature)
                                <div class="col-12 col-sm-6 col-xl-4">
                                    <div class="equipment-item gap-2">
                                        <span class="equipment-dot">•</span>

                                        <span>
                                            {{ $feature->name }}

                                            @if($feature->pivot->qty && $feature->unit)
                                                ({{ $feature->pivot->qty }} {{ $feature->unit->name }})
                                            @elseif($feature->pivot->qty)
                                                ({{ $feature->pivot->qty }})
                                            @elseif($feature->unit)
                                                ({{ $feature->unit->name }})
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="equipment-empty">
                                        Belum ada perlengkapan untuk kendaraan ini.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="booking-wrapper">
                        <hr class="vehicle-divider border-secondary-subtle">

                        <div class="booking-content">
                            <div class="price">
                                Rp{{ number_format($vehicle->price_per_day, 0, ',', '.') }}
                                <small>/hari</small>
                            </div>

                            @if($vehicle->operational_status == 'active')
                                <a href="{{ route('booking.create', $vehicle->slug) }}"
                                    class="btn btn-primary btn-book text-decoration-none">
                                    Booking
                                </a>
                            @else
                                <button class="btn btn-secondary btn-book" disabled>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection