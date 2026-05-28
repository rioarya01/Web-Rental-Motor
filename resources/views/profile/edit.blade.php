@extends('layouts.main')
@section('title', 'Profile ' . Auth::user()->name)
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css">

<main class="container" style="margin-top: 150px;">
    {{-- Profile Updated Alert --}}
    @if (session('status') === 'profile-updated')
        <div 
            id="profile-alert"
            class="alert alert-success alert-dismissible fade show mt-3"
            role="alert"
        >
            Profile sudah diperbarui.
            <button 
                type="button" 
                class="btn-close" 
                data-bs-dismiss="alert" 
                aria-label="Close"
            ></button>
        </div>
        <script>
            setTimeout(function () {
                const alert = document.getElementById('profile-alert');

                if (alert) {
                    alert.classList.remove('show');

                    setTimeout(function () {
                        alert.remove();
                    }, 300);
                }
            }, 5000);
        </script>
    @endif
    {{-- Password Updated Alert --}}
    @if (session('status') === 'password-updated')
        <div 
            id="password-alert"
            class="alert alert-success alert-dismissible fade show mt-3"
            role="alert"
        >
            Password berhasil diperbarui.
            <button 
                type="button" 
                class="btn-close" 
                data-bs-dismiss="alert" 
                aria-label="Close"
            ></button>
        </div>

        <script>
            setTimeout(function () {
                const alert = document.getElementById('password-alert');

                if (alert) {
                    alert.classList.remove('show');

                    setTimeout(function () {
                        alert.remove();
                    }, 300);
                }
            }, 5000);
        </script>
    @endif
    <section class="section profile">
        <div class="card">
            <div class="card-body pt-3">
                <!-- Bordered Tabs -->
                <ul class="nav nav-tabs nav-tabs-bordered">
                    <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Ringkasan</button>
                    </li>
                    <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                    </li>
                    <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ubah Password</button>
                    </li>
                </ul>
                <div class="tab-content pt-2">
                    {{-- Overview --}}
                    <div class="tab-pane fade show active profile-overview" id="profile-overview">
                        <div class="row align-items-center">
                            {{-- Foto Profile --}}
                            <div class="col-lg-4 d-flex justify-content-center align-items-center mb-4 mb-lg-0">
                                <img 
                                    src="{{ Auth::user()->avatar_url ? asset('img/avatars/' . Auth::user()->avatar_url) : asset('nice/assets/img/profile-img.jpg') }}" 
                                    alt="Profile" 
                                    class="rounded-circle img-fluid mt-5 mt-lg-0"
                                    style="width: 200px; height: 200px; object-fit: cover;"
                                >
                            </div>
                            {{-- Detail Profile --}}
                            <div class="col-lg-8">
                                <h5 class="card-title">Detail Profile</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Nama</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->name }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->username }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">No. Telepon</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->no_telp ?? ' - ' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">KTP</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->ktp_number ?? ' - ' }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-3 col-md-4 label">SIM</div>
                                    <div class="col-lg-9 col-md-8">{{ Auth::user()->sim_number ?? ' - ' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Profile Edit --}}
                    <div class="tab-pane fade pt-3" id="profile-edit">
                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <input type="hidden" name="cropped_avatar" id="cropped_avatar">

                            <div class="row align-items-start">
                                {{-- Form Input --}}
                                <div class="col-lg-8 order-2 order-lg-1">
                                    <h5 class="card-title">Edit Profile</h5>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="name" 
                                                type="text" 
                                                class="form-control" 
                                                id="name" 
                                                value="{{ old('name', Auth::user()->name) }}" 
                                                required 
                                                autofocus 
                                                autocomplete="name"
                                            >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="username" 
                                                type="text" 
                                                class="form-control" 
                                                id="username" 
                                                value="{{ old('username', Auth::user()->username) }}" 
                                                required 
                                                autocomplete="username"
                                            >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="email" 
                                                type="email" 
                                                class="form-control" 
                                                id="email" 
                                                value="{{ old('email', Auth::user()->email) }}" 
                                                required 
                                                autocomplete="email"
                                            >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="no_telp" class="col-md-4 col-lg-3 col-form-label">No. Telepon</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="no_telp" 
                                                type="text" 
                                                class="form-control" 
                                                id="no_telp" 
                                                value="{{ old('no_telp', Auth::user()->no_telp) }}" 
                                                autocomplete="tel"
                                            >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="whatsapp" class="col-md-4 col-lg-3 col-form-label">WhatsApp</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="whatsapp" 
                                                type="text" 
                                                class="form-control" 
                                                id="whatsapp" 
                                                value="{{ old('whatsapp', Auth::user()->whatsapp) }}" 
                                                autocomplete="tel"
                                            >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="ktp_number" class="col-md-4 col-lg-3 col-form-label">KTP</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="ktp_number" 
                                                type="text" 
                                                class="form-control" 
                                                id="ktp_number" 
                                                value="{{ old('ktp_number', Auth::user()->ktp_number) }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="sim_number" class="col-md-4 col-lg-3 col-form-label">SIM</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input 
                                                name="sim_number" 
                                                type="text" 
                                                class="form-control" 
                                                id="sim_number" 
                                                value="{{ old('sim_number', Auth::user()->sim_number) }}"
                                            >
                                        </div>
                                    </div>

                                    <div class="text-center text-lg-start">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>

                                {{-- Avatar --}}
                                <div class="col-lg-4 order-1 order-lg-2 mb-4 mb-lg-0">
                                    <div class="d-flex flex-column align-items-center">
                                        <h5 class="card-title text-center">Foto Profile</h5>

                                        <img 
                                            id="avatar-preview"
                                            src="{{ Auth::user()->avatar_url ? asset('img/avatars/' . Auth::user()->avatar_url) : asset('nice/assets/img/profile-img.jpg') }}"
                                            alt="Profile"
                                            class="rounded-circle mb-3"
                                            style="width: 200px; height: 200px; object-fit: cover; object-position: center;"
                                        >

                                        <input 
                                            type="file" 
                                            id="avatar" 
                                            accept="image/*" 
                                            class="d-none"
                                        >

                                        <button 
                                            type="button" 
                                            class="btn btn-outline-primary btn-sm"
                                            onclick="document.getElementById('avatar').click()"
                                        >
                                            Ubah Foto
                                        </button>

                                        <small class="text-muted text-center mt-2">
                                            Pilih foto, lalu crop sebelum disimpan.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal fade" id="cropImageModal" tabindex="-1" aria-labelledby="cropImageModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cropImageModalLabel">Crop Foto Profile</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body text-center">
                                    <div id="upload-crop"></div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="button" class="btn btn-primary" id="crop-save">
                                        Gunakan Foto
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Change Password --}}
                    <div class="tab-pane fade pt-3" id="profile-change-password">
                        <h5 class="card-title">Ubah Password</h5>
                        <form method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label for="current_password" class="col-md-4 col-lg-3 col-form-label">
                                    Password Saat Ini
                                </label>
                                <div class="col-md-8 col-lg-9">
                                    <div style="position: relative;">
                                        <input 
                                            name="current_password" 
                                            type="password" 
                                            class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                            id="current_password"
                                            autocomplete="current-password"
                                            style="padding-right: 45px;"
                                        >

                                        <button 
                                            type="button" 
                                            class="toggle-password"
                                            data-target="current_password"
                                            style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); border: none; background: transparent; color: #6c757d; padding: 0; line-height: 1; cursor: pointer; z-index: 5;"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    @error('current_password', 'updatePassword')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-lg-3 col-form-label">
                                    Password Baru
                                </label>
                                <div class="col-md-8 col-lg-9">
                                    <div style="position: relative;">
                                        <input 
                                            name="password" 
                                            type="password" 
                                            class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                            id="password"
                                            autocomplete="new-password"
                                            style="padding-right: 45px;"
                                        >

                                        <button 
                                            type="button" 
                                            class="toggle-password"
                                            data-target="password"
                                            style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); border: none; background: transparent; color: #6c757d; padding: 0; line-height: 1; cursor: pointer; z-index: 5;"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>

                                    @error('password', 'updatePassword')
                                        <div class="text-danger small mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-md-4 col-lg-3 col-form-label">
                                    Konfirmasi Password Baru
                                </label>
                                <div class="col-md-8 col-lg-9">
                                    <div style="position: relative;">
                                        <input 
                                            name="password_confirmation" 
                                            type="password" 
                                            class="form-control" 
                                            id="password_confirmation"
                                            autocomplete="new-password"
                                            style="padding-right: 45px;"
                                        >

                                        <button 
                                            type="button" 
                                            class="toggle-password"
                                            data-target="password_confirmation"
                                            style="position: absolute; top: 50%; right: 14px; transform: translateY(-50%); border: none; background: transparent; color: #6c757d; padding: 0; line-height: 1; cursor: pointer; z-index: 5;"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');
        const croppedAvatarInput = document.getElementById('cropped_avatar');
        const cropSaveButton = document.getElementById('crop-save');
        const cropModalElement = document.getElementById('cropImageModal');

        const toggleButtons = document.querySelectorAll('.toggle-password');

        let cropModal = new bootstrap.Modal(cropModalElement);
        let croppieInstance = null;

        croppieInstance = new Croppie(document.getElementById('upload-crop'), {
            viewport: {
                width: 200,
                height: 200,
                type: 'circle'
            },
            boundary: {
                width: 300,
                height: 300
            },
            enableExif: true
        });

        avatarInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                return;
            }

            if (!file.type.match('image.*')) {
                alert('File harus berupa gambar.');
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                cropModal.show();

                setTimeout(function () {
                    croppieInstance.bind({
                        url: event.target.result
                    });
                }, 300);
            };

            reader.readAsDataURL(file);
        });

        cropSaveButton.addEventListener('click', function () {
            croppieInstance.result({
                type: 'base64',
                size: {
                    width: 400,
                    height: 400
                },
                format: 'png',
                quality: 1,
                circle: false
            }).then(function (base64) {
                avatarPreview.src = base64;
                croppedAvatarInput.value = base64;
                cropModal.hide();
            });
        });

        toggleButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        });
    });
</script>
@endsection