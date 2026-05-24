@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <!--main-->
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Kendaraan</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-car-front"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalVehicles }}</h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pendapatan </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>Rp {{ number_format($totalPaid, 0, ',', '.') }}</h6>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-xxl-4 col-xl-12">
                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Total Customers</h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ $totalCustomers }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Pendapatan</h5>

                                    <form method="GET" action="{{ route('home.admin') }}">
                                        <select name="filter" onchange="this.form.submit()" class="form-select w-auto">
                                            <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>
                                                Harian
                                            </option>

                                            <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>
                                                Bulanan
                                            </option>

                                            <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>
                                                Tahunan
                                            </option>
                                        </select>
                                    </form>

                                    <!-- Pie Chart -->
                                    <div id="reportsChart"></div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {

                                            new ApexCharts(document.querySelector("#reportsChart"), {

                                                series: [{
                                                    name: 'Pendapatan',
                                                    data: @json($totals)
                                                }],

                                                chart: {
                                                    height: 350,
                                                    type: 'area',
                                                    toolbar: {
                                                        show: false
                                                    }
                                                },

                                                markers: {
                                                    size: 4
                                                },

                                                colors: ['#2eca6a'],

                                                fill: {
                                                    type: "gradient",
                                                    gradient: {
                                                        shadeIntensity: 1,
                                                        opacityFrom: 0.3,
                                                        opacityTo: 0.4,
                                                        stops: [0, 90, 100]
                                                    }
                                                },

                                                dataLabels: {
                                                    enabled: false
                                                },

                                                stroke: {
                                                    curve: 'smooth',
                                                    width: 2
                                                },

                                                xaxis: {
                                                    categories: @json($labels)
                                                },

                                                tooltip: {
                                                    y: {
                                                        formatter: function(val) {
                                                            return "Rp " + val.toLocaleString('id-ID');
                                                        }
                                                    }
                                                }

                                            }).render();

                                        });
                                    </script>
                                    <!-- End Pie Chart -->

                                </div>

                            </div>
                        </div><!-- End Reports -->
                    </div>
                </div><!-- End Left side columns -->

        </section>
        </div>

    </main><!-- End #main -->
@endsection
