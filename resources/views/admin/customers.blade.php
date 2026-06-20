@extends('layouts.main')
@section('title', 'Customers')
@section('content')
    <main id="main" class="main d-flex flex-column min-vh-100">
        <div class="pagetitle">
            <h1>Customers</h1>
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
                            <h5 class="card-title">Customer Data</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#addCustomerModal">
                                Add Customer
                            </button>
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($message = Session::get('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
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
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Whatsapp</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $index => $c)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $c->name }}</td>
                                                <td>{{ $c->username }}</td>
                                                <td>{{ $c->email }}</td>
                                                <td>{{ $c->no_telp }}</td>
                                                <td>
                                                    <span
                                                        class="badge bg-{{ $c->status === 'active' ? 'success' : ($c->status === 'non-active' ? 'warning' : 'danger') }}">
                                                        {{ ucfirst($c->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <button class="badge bg-primary px-3 py-2 border-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCustomerModal{{ $c->id }}">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <form action="{{ route('customers.destroy', $c->id) }}" method="POST"
                                                        style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="badge bg-danger px-3 py-2 border-0"
                                                            onclick="return confirm('Are you sure?')"><i
                                                                class="bi bi-trash-fill"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $customers->links('pagination::bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Add Customer Modal -->
    <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        {{-- GLOBAL ERROR ALERT --}}
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Validation Error!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control  @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="no_telp" class="form-label">Whatsapp</label>
                                <input type="text" class="form-control  @error('no_telp') is-invalid @enderror"
                                    id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
                                @error('no_telp')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ktp_number" class="form-label">KTP</label>
                                <input type="text" class="form-control  @error('ktp_number') is-invalid @enderror"
                                    id="ktp_number" name="ktp_number" value="{{ old('ktp_number') }}" required>
                                @error('ktp_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>

                                    <option value="">
                                        -- Select Status --
                                    </option>

                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="non-active" {{ old('status') == 'non-active' ? 'selected' : '' }}>
                                        Non-Active
                                    </option>

                                    <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>
                                        Blocked
                                    </option>

                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control  @error('password') is-invalid @enderror"
                                    id="password" name="password" value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    @foreach ($customers as $c)
        <div class="modal fade" id="editCustomerModal{{ $c->id }}" tabindex="-1"
            aria-labelledby="editCustomerModalLabel{{ $c->id }}" aria-hidden="true">

            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="editCustomerModalLabel{{ $c->id }}">
                            Edit Customer
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('customers.update', $c->id) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="modal-body">

                            {{-- GLOBAL ERROR ALERT --}}
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Validation Error!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                            @endif

                            {{-- HIDDEN ID --}}
                            <input type="hidden" name="edit_id" value="{{ $c->id }}">

                            <div class="row">

                                {{-- NAME --}}
                                <div class="col-md-6 mb-3">
                                    <label for="name{{ $c->id }}" class="form-label">
                                        Name
                                    </label>

                                    <input type="text"
                                        class="form-control @if (old('edit_id') == $c->id) @error('name') is-invalid @enderror @endif"
                                        id="name{{ $c->id }}" name="name"
                                        value="{{ old('edit_id') == $c->id ? old('name') : $c->name }}" required>

                                    @if (old('edit_id') == $c->id)
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- USERNAME --}}
                                <div class="col-md-6 mb-3">
                                    <label for="username{{ $c->id }}" class="form-label">
                                        Username
                                    </label>

                                    <input type="text"
                                        class="form-control @if (old('edit_id') == $c->id) @error('username') is-invalid @enderror @endif"
                                        id="username{{ $c->id }}" name="username"
                                        value="{{ old('edit_id') == $c->id ? old('username') : $c->username }}" required>

                                    @if (old('edit_id') == $c->id)
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- EMAIL --}}
                                <div class="col-md-6 mb-3">
                                    <label for="email{{ $c->id }}" class="form-label">
                                        Email
                                    </label>

                                    <input type="email"
                                        class="form-control @if (old('edit_id') == $c->id) @error('email') is-invalid @enderror @endif"
                                        id="email{{ $c->id }}" name="email"
                                        value="{{ old('edit_id') == $c->id ? old('email') : $c->email }}" required>

                                    @if (old('edit_id') == $c->id)
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- PHONE --}}
                                <div class="col-md-6 mb-3">
                                    <label for="no_telp{{ $c->id }}" class="form-label">
                                        Whatsapp
                                    </label>

                                    <input type="text"
                                        class="form-control @if (old('edit_id') == $c->id) @error('no_telp') is-invalid @enderror @endif"
                                        id="no_telp{{ $c->id }}" name="no_telp"
                                        value="{{ old('edit_id') == $c->id ? old('no_telp') : $c->no_telp }}" required>

                                    @if (old('edit_id') == $c->id)
                                        @error('no_telp')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- KTP --}}
                                <div class="col-md-6 mb-3">
                                    <label for="ktp_number{{ $c->id }}" class="form-label">
                                        KTP
                                    </label>

                                    <input type="text"
                                        class="form-control @if (old('edit_id') == $c->id) @error('ktp_number') is-invalid @enderror @endif"
                                        id="ktp_number{{ $c->id }}" name="ktp_number"
                                        value="{{ old('edit_id') == $c->id ? old('ktp_number') : $c->ktp_number }}"
                                        required>

                                    @if (old('edit_id') == $c->id)
                                        @error('ktp_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- STATUS --}}
                                <div class="col-md-6 mb-3">
                                    <label for="status{{ $c->id }}" class="form-label">
                                        Status
                                    </label>

                                    <select
                                        class="form-select @if (old('edit_id') == $c->id) @error('status') is-invalid @enderror @endif"
                                        id="status{{ $c->id }}" name="status" required>

                                        <option value="active"
                                            {{ (old('edit_id') == $c->id ? old('status') : $c->status) == 'active' ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="non-active"
                                            {{ (old('edit_id') == $c->id ? old('status') : $c->status) == 'non-active' ? 'selected' : '' }}>
                                            Non-Active
                                        </option>

                                        <option value="blocked"
                                            {{ (old('edit_id') == $c->id ? old('status') : $c->status) == 'blocked' ? 'selected' : '' }}>
                                            Blocked
                                        </option>

                                    </select>

                                    @if (old('edit_id') == $c->id)
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- ADDRESS --}}
                                <div class="col-md-12 mb-3">
                                    <label for="address{{ $c->id }}" class="form-label">
                                        Address
                                    </label>

                                    <textarea class="form-control @if (old('edit_id') == $c->id) @error('address') is-invalid @enderror @endif"
                                        id="address{{ $c->id }}" name="address" rows="3">{{ old('edit_id') == $c->id ? old('address') : $c->address }}</textarea>

                                    @if (old('edit_id') == $c->id)
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>

                                {{-- PASSWORD --}}
                                <div class="col-md-12 mb-3">
                                    <label for="password{{ $c->id }}" class="form-label">
                                        Password
                                    </label>

                                    <input type="password"
                                        class="form-control @if (old('edit_id') == $c->id) @error('password') is-invalid @enderror @endif"
                                        id="password{{ $c->id }}" name="password"
                                        placeholder="Leave blank to keep current password">

                                    @if (old('edit_id') == $c->id)
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection

{{-- AUTO OPEN ADD MODAL --}}
@if ($errors->any() && !old('edit_id'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let modal = new bootstrap.Modal(
                document.getElementById('addCustomerModal')
            );

            modal.show();
        });
    </script>
@endif
{{-- AUTO OPEN EDIT MODAL IF VALIDATION ERROR --}}
@if ($errors->any() && old('edit_id'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let editModal = new bootstrap.Modal(
                document.getElementById(
                    'editCustomerModal{{ old('edit_id') }}'
                )
            );

            editModal.show();
        });
    </script>
@endif
