<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full" x-data="{ open: false }">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Kelola Data Sub Kriteria Karyawan Terbaik</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Sub Kriteria Karyawan Terbaik</a>
        </div>

        <!-- Formulir Input Sub Kriteria -->
        <form action="{{ route('ranking_subcriteria.store') }}" method="POST" x-show="open" x-transition>
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Sub Kriteria:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
            </div>

            <div class="mb-4">
                <label for="detail" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penjelasan/Detail:</label>
                <textarea name="detail" id="detail" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200"></textarea>
            </div>

            <div class="mb-4">
                <label for="ranking_criteria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kriteria:</label>
                <select name="ranking_criteria_id" id="ranking_criteria_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    <option value="">Pilih Kriteria</option>
                    @foreach($ranking_criterias as $ranking_criteria)
                        <option value="{{ $ranking_criteria->id }}">{{ $ranking_criteria->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Simpan</button>
        </form>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-1 justify-between items-center mb-4">
                <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Departemen</h2>
                <button @click="open = !open" class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                    <span x-text="open ? 'Tutup' : 'Tambah'"></span>
                </button>
            </div>

            <div class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 mb-4">
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
                    <select id="filter_ranking_criteria_id" name="ranking_criteria_id" class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                        <option value="">Semua Kriteria</option>
                        @foreach($ranking_criterias as $ranking_criteria)
                            <option value="{{ $ranking_criteria->id }}" {{ request('ranking_criteria_id') == $ranking_criteria->id ? 'selected' : '' }}>
                                {{ $ranking_criteria->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <input type="text" id="search_ranking_subkriteria" placeholder="Cari Sub Kriteria..." class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
            </div>

            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class=" border-b-2 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Nama Sub Kriteria</th>
                            <th>Penjelasan / Detail</th>
                            <th>Kriteria</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="ranking-subkriteria-list" class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">
                        @include('admin.ranking.subcriterias-list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('filter_ranking_criteria_id').addEventListener('change', function () {
    const rankingCriteriaId = this.value;
    fetch(`http://e-nilai.test/admin/ranking/subcriterias?ranking_criteria_id=${rankingCriteriaId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
            const rankingSubcriteriaList = document.getElementById('ranking-subkriteria-list');
            rankingSubcriteriaList.innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.getElementById('search_ranking_subkriteria').addEventListener('input', function () {
    const searchQuery = this.value;
    const rankingCriteriaId = document.getElementById('filter_ranking_criteria_id').value;

    fetch(`http://e-nilai.test/admin/ranking/subcriterias?ranking_criteria_id=${rankingCriteriaId}&search=${searchQuery}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
            const rankingSubcriteriaList = document.getElementById('ranking-subkriteria-list');
            rankingSubcriteriaList.innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.getElementById('entries_per_page').addEventListener('change', function() {
        const entriesPerPage = this.value;
        const rankingCriteriaId = document.getElementById('ranking_criteria_id').value;
        const searchQuery = document.getElementById('search_ranking_subkriteria').value;

        fetch(`http://e-nilai.test/admin/ranking/subcriterias?ranking_criteria_id=${rankingCriteriaId}&search=${searchQuery}&entries_per_page=${entriesPerPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const rankingSubcriteriaList = document.getElementById('ranking-subkriteria-list');
                rankingSubcriteriaList.innerHTML = data.html;
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
            const rankingCriteriaId = document.getElementById('ranking_criteria_id').value;
            const searchQuery = document.getElementById('search_ranking_subkriteria').value;
            const entriesPerPage = document.getElementById('entries_per_page')?.value || 10;

            // Buat URL dengan query parameters
            const paginationUrl = new URL(url);
            paginationUrl.searchParams.set('ranking_criteria_id', rankingCriteriaId);
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
                    document.getElementById('ranking-subkriteria-list').innerHTML = data.html;
                    document.getElementById('pagination-links').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>