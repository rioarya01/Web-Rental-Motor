@extends('template.layouts')
@section('title', 'Vehicles')
@section('content')
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    {{-- Heading --}}
    <div class="mb-10">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            Daftar Kendaraan
        </h2>
        <p class="text-gray-600">
            Pilih kendaraan yang paling sesuai dengan gaya perjalanan dan budget Anda.
        </p>
    </div>
    <!-- Filter Component -->
    <x-filter-bar />
    <!-- List Vehicles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6 justify-items-center">
        @forelse ($vehicles as $vehicle)
            <x-vehicle-card :vehicle="$vehicle" />
        @empty
            <p class="text-center w-full text-gray-500">
                Kendaraan tidak tersedia.
            </p>
        @endforelse
    </div>
    <!-- Pagination -->
    <div class="d-flex justify-center my-16">
        {{ $vehicles->links() }}
    </div>
    {{-- Terms and Conditions --}}
    <x-terms-conditions />
</div>
@endsection