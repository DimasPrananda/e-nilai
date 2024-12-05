 <x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Kelola Data Penilaian</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="{{ route('admin.penilaian.select-periods') }}"class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ {{ $selectedPeriod->period }}</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold ">/ Kelola Data Penilaian</a>
        </div>     

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Data Penilaian</h2>

            <div class="flex items-center space-x-2 mb-4">
                <select id="entries_per_page" class="block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="15">15</option>
                </select>
                <span class="text-gray-800 dark:text-gray-200">entri per halaman</span>
            </div>

            <form id="filterForm" class="mb-4 flex flex-col md:flex-row justify-between">
                <div class="flex items-center mb-4 md:mb-0">
                    <select name="department_id" id="department_id" class="form-select block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $department->id == old('department_id', session('last_department_id', $departmentId)) ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <input type="text" id="search" name="search" placeholder="Cari Karyawan..." class="form-input block border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
        
                <input type="hidden" name="period_id" value="{{ $selectedPeriod->id }}">
            </form>
            
            <div class="flex overflow-x-auto">
                <table class=" flex-1">
                    <thead class=" border-b-2 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                        <tr>
                            <th class="px-6 py-3 text-center">No</th>
                            <th class="px-6 py-3 text-center">Nama</th>
                            <th class="px-6 py-3 text-center">Departemen</th>
                            <th class="px-6 py-3 text-center">Total Skor</th>                            
                            <th class="px-6 py-3 text-center">Status</th>                            
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="employee-list" class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">
                        @include('admin.penilaian.employees-list')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function fetchEmployees() {
        const departmentId = document.getElementById('department_id').value;
        const searchQuery = document.getElementById('search').value;
        const periodId = document.querySelector('input[name="period_id"]').value;

        fetch(`{{ route('periods.showEmployee') }}?department_id=${departmentId}&search=${searchQuery}&period_id=${periodId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('employee-list').innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    }

    document.addEventListener('DOMContentLoaded', fetchEmployees);

    document.getElementById('department_id').addEventListener('change', fetchEmployees);
    document.getElementById('search').addEventListener('input', fetchEmployees);
</script>

<script>
    function fetchEmployees(page = 1) {
    const departmentId = document.getElementById('department_id').value;
    const searchQuery = document.getElementById('search').value;
    const periodId = document.querySelector('input[name="period_id"]').value;
    const entriesPerPage = document.getElementById('entries_per_page').value;

    fetch(`{{ route('periods.showEmployee') }}?department_id=${departmentId}&search=${searchQuery}&period_id=${periodId}&entries_per_page=${entriesPerPage}&page=${page}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('employee-list').innerHTML = data.html;
        document.getElementById('pagination-links').innerHTML = data.pagination;
        
        // Attach click events to new pagination links
        document.querySelectorAll('#pagination-links a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const urlParams = new URLSearchParams(new URL(link.href).search);
                const page = urlParams.get('page');
                fetchEmployees(page);
            });
        });
    })
        .catch(error => console.error('Error:', error));
    }
    document.addEventListener('DOMContentLoaded', fetchEmployees);
    document.getElementById('department_id').addEventListener('change', fetchEmployees);
    document.getElementById('search').addEventListener('input', fetchEmployees);
    document.getElementById('entries_per_page').addEventListener('change', fetchEmployees);
</script>