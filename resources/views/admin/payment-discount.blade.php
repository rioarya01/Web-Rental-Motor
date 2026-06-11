@extends('layouts.main')
@section('title', 'Atur Diskon & Pembayaran')
@section('content')
    <main id="main" class="main d-flex flex-column min-vh-100">
        <div class="pagetitle">
            <h1>Atur Diskon & Pembayaran</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.admin') }}">Home</a></li>
                    <li class="breadcrumb-item active">Pengaturan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <div class="row">
                <!-- Payment Settings (WhatsApp) -->
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pengaturan Konfirmasi WhatsApp</h5>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            <form action="{{ route('admin.payment-discount.updatePayment') }}" method="POST">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="whatsapp_number" class="form-label">No. WhatsApp Konfirmasi</label>
                                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $paymentSetting->whatsapp_number ?? '') }}" placeholder="628xxxxxxxx">
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button class="btn btn-primary" type="submit">Simpan Pengaturan WhatsApp</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Payment Accounts Management -->
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Rekening Pembayaran</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPaymentAccountModal">
                                Tambah Rekening Baru
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Bank</th>
                                            <th scope="col">Nomor Rekening</th>
                                            <th scope="col">Atas Nama</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($paymentAccounts as $index => $pa)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $pa->bank_name }}</td>
                                                <td>{{ $pa->account_number }}</td>
                                                <td>{{ $pa->account_name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $pa->is_active ? 'success' : 'danger' }}">
                                                        {{ $pa->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="badge bg-primary px-3 py-2 border-0" data-bs-toggle="modal" data-bs-target="#editPaymentAccountModal{{ $pa->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('admin.payment-discount.destroyPaymentAccount', $pa->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger px-3 py-2 border-0" onclick="return confirm('Apakah Anda yakin menghapus rekening ini?')">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Discount Management -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Diskon Tersedia</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addDiscountModal">
                                Tambah Diskon Baru
                            </button>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-borderless">
                                        <tr>
                                            <th scope="col">No</th>
                                            <th scope="col">Nama Diskon</th>
                                            <th scope="col">Persentase</th>
                                            <th scope="col">Target</th>
                                            <th scope="col">Status Aktif</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($discounts as $index => $d)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $d->name }}</td>
                                                <td>{{ $d->percentage }}%</td>
                                                <td>
                                                    @if ($d->vehicle_id)
                                                        <span class="badge bg-info">Produk: {{ $d->vehicle->name ?? '-' }}</span>
                                                    @elseif ($d->brand_id)
                                                        <span class="badge bg-primary">Brand: {{ $d->brand->name ?? '-' }}</span>
                                                    @elseif ($d->category_id)
                                                        <span class="badge bg-secondary">Kategori: {{ $d->category->name ?? '-' }}</span>
                                                    @else
                                                        <span class="badge bg-success">Global (Semua Produk)</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $d->is_active ? 'success' : 'danger' }}">
                                                        {{ $d->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="badge bg-primary px-3 py-2 border-0" data-bs-toggle="modal" data-bs-target="#editDiscountModal{{ $d->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('admin.payment-discount.destroyDiscount', $d->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger px-3 py-2 border-0" onclick="return confirm('Apakah Anda yakin menghapus diskon ini?')">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Add Payment Account Modal -->
    <div class="modal fade" id="addPaymentAccountModal" tabindex="-1" aria-labelledby="addPaymentAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentAccountModalLabel">Tambah Rekening Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payment-discount.storePaymentAccount') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" name="bank_name" required placeholder="Misal: BCA">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" name="account_number" required placeholder="Misal: 1234567890">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" name="account_name" required placeholder="Misal: John Doe">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Rekening</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Payment Account Modals -->
    @foreach ($paymentAccounts as $pa)
    <div class="modal fade" id="editPaymentAccountModal{{ $pa->id }}" tabindex="-1" aria-labelledby="editPaymentAccountModalLabel{{ $pa->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Rekening</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payment-discount.updatePaymentAccount', $pa->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" class="form-control" name="bank_name" value="{{ $pa->bank_name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" class="form-control" name="account_number" value="{{ $pa->account_number }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" class="form-control" name="account_name" value="{{ $pa->account_name }}" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="pa_is_active_{{ $pa->id }}" name="is_active" value="1" {{ $pa->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="pa_is_active_{{ $pa->id }}">Rekening Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Add Discount Modal -->
    <div class="modal fade" id="addDiscountModal" tabindex="-1" aria-labelledby="addDiscountModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDiscountModalLabel">Tambah Diskon Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payment-discount.storeDiscount') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Validation Error!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Diskon</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="percentage" class="form-label">Persentase Diskon (%)</label>
                            <input type="number" class="form-control" name="percentage" min="1" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="target_type" class="form-label">Target Diskon</label>
                            <select name="target_type" id="add_target_type" class="form-select" onchange="toggleAddTargetDropdowns()">
                                <option value="global">Global (Semua Produk)</option>
                                <option value="vehicle">Kendaraan</option>
                                <option value="brand">Brand Kendaraan</option>
                                <option value="category">Kategori Kendaraan</option>
                            </select>
                        </div>
                        <div class="mb-3" id="add_vehicle_container" style="display: none;">
                            <label for="vehicle_id" class="form-label">Pilih Kendaraan</label>
                            <select name="vehicle_id" id="add_vehicle_id" class="form-select">
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}">{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="add_brand_container" style="display: none;">
                            <label for="brand_id" class="form-label">Pilih Brand</label>
                            <select name="brand_id" id="add_brand_id" class="form-select">
                                <option value="">-- Pilih Brand --</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="add_category_container" style="display: none;">
                            <label for="category_id" class="form-label">Pilih Kategori</label>
                            <select name="category_id" id="add_category_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Diskon</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Discount Modals -->
    @foreach ($discounts as $d)
    <div class="modal fade" id="editDiscountModal{{ $d->id }}" tabindex="-1" aria-labelledby="editDiscountModalLabel{{ $d->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Diskon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.payment-discount.updateDiscount', $d->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Diskon</label>
                            <input type="text" class="form-control" name="name" value="{{ $d->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Persentase Diskon (%)</label>
                            <input type="number" class="form-control" name="percentage" value="{{ $d->percentage }}" min="1" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Target Diskon</label>
                            @php
                                $currentTarget = 'global';
                                if($d->vehicle_id) $currentTarget = 'vehicle';
                                elseif($d->brand_id) $currentTarget = 'brand';
                                elseif($d->category_id) $currentTarget = 'category';
                            @endphp
                            <select name="target_type" id="edit_target_type_{{ $d->id }}" class="form-select" onchange="toggleEditTargetDropdowns({{ $d->id }})">
                                <option value="global" {{ $currentTarget == 'global' ? 'selected' : '' }}>Global (Semua Produk)</option>
                                <option value="vehicle" {{ $currentTarget == 'vehicle' ? 'selected' : '' }}>Kendaraan</option>
                                <option value="brand" {{ $currentTarget == 'brand' ? 'selected' : '' }}>Brand Kendaraan</option>
                                <option value="category" {{ $currentTarget == 'category' ? 'selected' : '' }}>Kategori Kendaraan</option>
                            </select>
                        </div>
                        <div class="mb-3" id="edit_vehicle_container_{{ $d->id }}" style="display: {{ $currentTarget == 'vehicle' ? 'block' : 'none' }};">
                            <label class="form-label">Pilih Kendaraan</label>
                            <select name="vehicle_id" class="form-select">
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}" {{ $d->vehicle_id == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="edit_brand_container_{{ $d->id }}" style="display: {{ $currentTarget == 'brand' ? 'block' : 'none' }};">
                            <label class="form-label">Pilih Brand</label>
                            <select name="brand_id" class="form-select">
                                <option value="">-- Pilih Brand --</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}" {{ $d->brand_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3" id="edit_category_container_{{ $d->id }}" style="display: {{ $currentTarget == 'category' ? 'block' : 'none' }};">
                            <label class="form-label">Pilih Kategori</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ $d->category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_active_{{ $d->id }}" name="is_active" value="1" {{ $d->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active_{{ $d->id }}">Diskon Aktif</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        function toggleAddTargetDropdowns() {
            const type = document.getElementById('add_target_type').value;
            document.getElementById('add_vehicle_container').style.display = (type === 'vehicle') ? 'block' : 'none';
            document.getElementById('add_brand_container').style.display = (type === 'brand') ? 'block' : 'none';
            document.getElementById('add_category_container').style.display = (type === 'category') ? 'block' : 'none';
        }

        function toggleEditTargetDropdowns(id) {
            const type = document.getElementById('edit_target_type_' + id).value;
            document.getElementById('edit_vehicle_container_' + id).style.display = (type === 'vehicle') ? 'block' : 'none';
            document.getElementById('edit_brand_container_' + id).style.display = (type === 'brand') ? 'block' : 'none';
            document.getElementById('edit_category_container_' + id).style.display = (type === 'category') ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Add Dropdown
            toggleAddTargetDropdowns();
            
            // Initialize Edit Dropdowns
            @foreach ($discounts as $d)
                toggleEditTargetDropdowns({{ $d->id }});
            @endforeach
        });
    </script>
@endsection
