<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full" x-data="{ open: false }">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Kelola Data Golongan</h1>
            <a href="{{ route('admin.dashboard') }}"
                class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">dashboard </a><a
                class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Golongan</a>
        </div>

        <!-- Formulir Input Golongan -->
        <form class="mb-4" action="{{ route('golongan.store') }}" method="POST" x-show="open" x-transition>
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                    Golongan:</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200"
                    required>
            </div>

            <div class="mb-4">
                <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih
                    Jabatan:</label>
                <select name="position_id" id="position_id"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200"
                    required>
                    <option value="">Pilih Jabatan</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </form>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-1 justify-between items-center mb-4">
                <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Golongan</h2>
                <button @click="open = !open"
                    class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>
                    <span x-text="open ? 'Tutup' : 'Tambah'"></span>
                </button>
            </div>

            <div class="flex items-center space-x-2 mb-4">
                <select id="entries_per_page"
                    class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                </select>
                <span class="text-gray-800 dark:text-gray-200">entri per halaman</span>
            </div>

            <div class="flex flex-col md:flex-row gap-2 justify-between mb-4">
                <form method="GET" id="formFilter">
                    <select id="filter_position_id" name="position_id"
                        class=" border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                        <option value="">Semua Jabatan</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}"
                                {{ request('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <input type="text" id="search_golongan" placeholder="Cari Golongan..."
                    class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
            </div>

            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class=" border-b-2 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="golongan-list" class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">
                        @include('admin.golongans-list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('filter_position_id').addEventListener('change', function() {
        const positionId = this.value;
        fetch(`http://e-nilai.test/admin/golongans?position_id=${positionId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const golonganList = document.getElementById('golongan-list');
                golonganList.innerHTML = data.html;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.getElementById('search_golongan').addEventListener('input', function() {
        const searchQuery = this.value;
        const positionId = document.getElementById('filter_position_id').value;

        fetch(`http://e-nilai.test/admin/golongans?position_id=${positionId}&search=${searchQuery}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const golonganList = document.getElementById('golongan-list');
                golonganList.innerHTML = data.html;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.getElementById('entries_per_page').addEventListener('change', function() {
        const entriesPerPage = this.value;
        const positionId = document.getElementById('position_id').value;
        const searchQuery = document.getElementById('search_golongan').value;

        fetch(`http://e-nilai.test/admin/golongans?position_id=${positionId}&search=${searchQuery}&entries_per_page=${entriesPerPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const employeeList = document.getElementById('golongan-list');
                employeeList.innerHTML = data.html;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.addEventListener('click', function(event) {
        // Cek jika link pagination diklik
        if (event.target.closest('#pagination-links a')) {
            event.preventDefault();

            // Dapatkan URL dari link pagination yang diklik
            const url = event.target.closest('#pagination-links a').href;

            // Ambil nilai filter yang ada
            const positionId = document.getElementById('position_id').value;
            const searchQuery = document.getElementById('search_golongan').value;
            const entriesPerPage = document.getElementById('entries_per_page')?.value || 10;

            // Buat URL dengan query parameters
            const paginationUrl = new URL(url);
            paginationUrl.searchParams.set('position_id', positionId);
            paginationUrl.searchParams.set('search', searchQuery);
            paginationUrl.searchParams.set('entries_per_page', entriesPerPage);

            // Fetch data menggunakan AJAX
            fetch(paginationUrl.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Update isi tabel dan pagination links tanpa refresh
                    document.getElementById('golongan-list').innerHTML = data.html;
                    document.getElementById('pagination-links').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>
