<script src="//unpkg.com/alpinejs" defer></script>

<form method="GET" action="{{ route('vehicles.index') }}">
    <div x-data="{ open: false }" class="w-full bg-white border-b rounded-md shadow">
        <!-- DESKTOP -->
        <div class="hidden lg:flex items-center gap-3 p-4">
            {{-- Type --}}
            <div class="flex items-center gap-2 border rounded-lg px-3 py-2 w-48">
                <span class="material-symbols-outlined text-gray-400">
                    motorcycle
                </span>
                <select :name="!open ? 'type' : null"
                    class="bg-transparent text-sm border-0 outline-none focus:outline-none focus:ring-0 w-full">
                    <option value="">Semua tipe</option>
                    <option value="matic" {{ request('type') == 'matic' ? 'selected' : '' }}>Matic</option>
                    <option value="manual" {{ request('type') == 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>
            {{-- Date --}}
            <div class="flex items-center gap-2 border rounded-lg px-3 py-2">
                <span class="material-symbols-outlined text-gray-400">
                    calendar_month
                </span>
                <span class="text-sm text-gray-600">{{ $date }}</span>
            </div>
            {{-- Time --}}
            <div class="flex items-center gap-2 border rounded-lg px-3 py-2">
                <span class="material-symbols-outlined text-gray-400">
                    timer
                </span>
                <span class="text-sm text-gray-600">{{ $time }}</span>
            </div>
            {{-- Duration --}}
            <div class="flex items-center gap-2 border rounded-lg px-3 py-2">
                <span class="material-symbols-outlined text-gray-400">
                    calendar_today
                </span>
                <span class="text-sm text-gray-600">{{ $duration }}</span>
                <span class="text-xs text-gray-400 ml-2">Durasi sewa 24 jam/hari</span>
            </div>
            {{-- Search --}}
            <div class="flex items-center border rounded-lg px-3 py-2 flex-1">
                <span class="material-symbols-outlined text-gray-400">
                    search
                </span>
                <input type="text"
                    :name="!open ? 'search' : null"
                    value="{{ request('search') }}"
                    placeholder="Nama motor"
                    class="ml-2 w-full text-sm border-0 outline-none focus:outline-none focus:ring-0" />
            </div>
            <div class="flex gap-2">
                <!-- Button Submit-->
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md">
                    Cari
                </button>
                <!-- Button Reset -->
                <a href="{{ route('vehicles.index') }}" class="bg-red-600 text-white px-4 py-2 rounded-md">
                    Reset
                </a>
            </div>
        </div>
    
        <!-- MOBILE HEADER -->
        <div class="lg:hidden p-4">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-gray-800">Cari kendaraan</h2>
                <button type="button" @click="open = !open" class="text-blue-600 text-sm">
                    <span x-show="!open">Edit filter</span>
                    <span x-show="open">Tutup filter</span>
                </button>
            </div>
        </div>
        <!-- MOBILE FILTER -->
        <div x-show="open" x-transition class="lg:hidden px-4 pb-4 space-y-3">
            {{-- Search --}}
            <div class="flex items-center border rounded-lg px-3 py-2">
                <span class="material-symbols-outlined text-gray-400">
                    search
                </span>
                <input type="text"
                    :name="open ? 'search' : null"
                    value="{{ request('search') }}"
                    placeholder="Nama motor"
                    class="w-full text-sm border-0 outline-none focus:outline-none focus:ring-0" />
            </div>
            {{-- Type --}}
            <div class="flex items-center gap-2 border rounded-lg px-3 py-2">
                <span class="material-symbols-outlined text-gray-400">
                    motorcycle
                </span>
                <select :name="open ? 'type' : null"
                    class="bg-transparent text-sm border-0 outline-none focus:outline-none focus:ring-0 w-full">
                    <option value="">Semua tipe</option>
                    <option value="matic" {{ request('type') == 'matic' ? 'selected' : '' }}>Matic</option>
                    <option value="manual" {{ request('type') == 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>
            {{-- Date and Time --}}
            <div class="flex items-center justify-between border rounded-lg px-3 py-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400">
                        calendar_month
                    </span>
                    <span class="text-sm text-gray-600">{{ $date }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400">
                        timer
                    </span>
                    <span class="text-sm text-gray-600">{{ $time }}</span>
                </div>
            </div>
            {{-- Duration --}}
            <div class="flex items-center justify-between border rounded-lg px-3 py-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400">
                        calendar_today
                    </span>
                    <span class="text-sm text-gray-600">{{ $duration }}</span>
                </div>
                <span class="text-xs text-gray-400">Durasi sewa 24 jam/hari</span>
            </div>
            {{-- Note --}}
            <p class="text-xs text-gray-500">
                Selesai Sewa: Min, 30 Nov • 23:59
            </p>
            {{-- Submit Button --}}
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-medium">
                Ayo Cari
            </button>
            {{-- Reset Button --}}
            <a href="{{ route('vehicles.index') }}" class="block text-center bg-red-600 text-white py-3 rounded-lg font-medium">
                Reset
            </a>
        </div>
    </div>
</form>