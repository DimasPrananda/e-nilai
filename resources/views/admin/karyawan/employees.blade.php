<x-app-layout>
    <div class="p-4 md:p-12 flex-1">
        <div class="">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                    class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <div class="md:p-0 mb-4">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Kelola Data Karyawan</h1>
                <a href="{{ route('admin.dashboard') }}"
                    class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">dashboard </a><a
                    class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Karyawan</a>
            </div>

            <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
                <div class="flex-1 flex justify-between items-center mb-4">
                    <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Karyawan</h2>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('admin.karyawan.create') }}"
                            class="flex items-center justify-between bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg class="w-4 h-4 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M5 12h14m-7 7V5" />
                            </svg>
                            Tambah
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-2 mb-4">
                    <select id="entries_per_page"
                        class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                        <option value="2">5</option>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                    </select>
                    <span class="text-gray-800 dark:text-gray-200">entri per halaman</span>
                </div>

                <div class="flex flex-col md:flex-row gap-2 justify-between mb-4">
                    <form id="filterForm">
                        <select id="department_id" name="department_id"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                            <option value="">Semua Departemen</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                    <input type="text" id="search_employee" placeholder="Cari Karyawan..."
                        class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                </div>

                {{-- Tabel Data Karyawan --}}
                <div class="flex overflow-x-auto">
                    <table class="flex-1">
                        <thead class=" border-b-2 text-gray-800 dark:text-gray-200">
                            <tr>
                                <th class="w-12">No</th>
                                <th class="w-32">Nama</th>
                                <th class="w-24">Nomor</th>
                                <th class="w-32">Departemen</th>
                                <th class="w-32">Jabatan</th>
                                <th class="w-16">Golongan</th>
                                <th class="w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="employee-list" class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">
                            @include('admin.karyawan.employees-list')
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('department_id').addEventListener('change', function() {
        const departmentId = this.value;
        fetch(`http://e-nilai.test/admin/karyawan?department_id=${departmentId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const employeeList = document.getElementById('employee-list');
                employeeList.innerHTML = data.html;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.getElementById('search_employee').addEventListener('input', function() {
        const searchQuery = this.value;
        const departmentId = document.getElementById('department_id').value;

        fetch(`http://e-nilai.test/admin/karyawan?department_id=${departmentId}&search=${searchQuery}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const employeeList = document.getElementById('employee-list');
                employeeList.innerHTML = data.html;
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.getElementById('entries_per_page').addEventListener('change', function() {
        const entriesPerPage = this.value;
        const departmentId = document.getElementById('department_id').value;
        const searchQuery = document.getElementById('search_employee').value;

        fetch(`http://e-nilai.test/admin/karyawan?department_id=${departmentId}&search=${searchQuery}&entries_per_page=${entriesPerPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const employeeList = document.getElementById('employee-list');
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
            const departmentId = document.getElementById('department_id').value;
            const searchQuery = document.getElementById('search_employee').value;
            const entriesPerPage = document.getElementById('entries_per_page')?.value || 15;

            // Buat URL dengan query parameters
            const paginationUrl = new URL(url);
            paginationUrl.searchParams.set('department_id', departmentId);
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
                    document.getElementById('employee-list').innerHTML = data.html;
                    document.getElementById('pagination-links').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
        }
    });
</script>
