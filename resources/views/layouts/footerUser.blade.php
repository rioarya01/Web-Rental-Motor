<footer class="bg-dark text-white py-5 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-8">
                <!-- Logo -->
                <a href="{{ route('home.user') }}" class="navbar-brand d-flex align-items-center mb-3">
                    <img 
                        src="{{ asset('img/logo/horizontal-white.svg') }}" 
                        alt="Logo"
                        class="img-fluid"
                        style="height: 60px; width: auto;"
                    >
                </a>
                <p class="mb-0">Pilihan terlengkap, harga transparan, dan layanan 24 jam. Siap menemani setiap petualangan Anda.</p>
            </div>
            <div class="col-6 col-md-2">
                <h5 class="text-white fw-semibold mb-3">About</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="#" class="text-white text-decoration-none">Chat Admin</a></li>
                </ul>
            </div>
            <div class="col-6 col-md-2">
                <h5 class="text-white fw-semibold mb-3">Socials</h5>
                <ul class="list-unstyled mb-0">
                    <li><a href="#" class="text-white text-decoration-none">Discord</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Instagram</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Twitter</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Facebook</a></li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="fw-semibold small">
            &copy; {{ date('Y') }} Sewa Motor ID. All rights reserved.
        </div>
    </div>
</footer>
