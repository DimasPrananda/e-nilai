<x-app-layout>
    <div class="p-12 flex-1">
        <div class="container mx-auto p-4">
            <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Karyawan</h2>

            <!-- Filter Berdasarkan Periode -->
            <div class="mb-4 mt-4">
                <form method="GET" action="{{ route('admin.penilaian.assessments') }}">
                    <label for="period_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter Periode:</label>
                    <select id="period_id" name="period_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" onchange="this.form.submit()">
                        <option value="">Semua Periode</option>
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}" {{ request('period_id') == $period->id ? 'selected' : '' }}>
                                {{ $period->start_year }} - {{ $period->end_year }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Filter Berdasarkan Departemen -->
            <div class="mb-4 mt-4">
                <form method="GET" action="{{ route('admin.penilaian.assessments') }}">
                    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter Departemen:</label>
                    <select id="department_id" name="department_id" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" onchange="this.form.submit()">
                        <option value="">Semua Departemen</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- Tabel Data Karyawan -->
            <table class="min-w-full bg-white dark:bg-gray-800 border-gray-300 border shadow-sm mt-4">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">No</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Nama Karyawan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Departemen</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Total Nilai</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $index => $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->department->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                            <!-- Menghitung dan menampilkan total nilai -->
                            {{ $employee->scores->sum('value') ?? 0 }} <!-- Menggunakan null coalescing operator -->
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                            <a href="{{ route('admin.penilaian.scores', $employee->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nilai</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada data karyawan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>