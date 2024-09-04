<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Penilaian di Periode {{ $selectedPeriod->period }}</h1>
                
                <!-- Filter Departemen -->
                <form x-data="{ departmentId: '{{ old('department_id', session('last_department_id', $departmentId)) }}' }" x-ref="form" action="{{ route('periods.showEmployee') }}" method="GET" class="mb-4">
                    <div class="flex items-center mb-4">
                        <select name="department_id" id="department_id" x-model="departmentId" @change="$refs.form.submit()" class="form-select block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ $department->id == old('department_id', session('last_department_id', $departmentId)) ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center mb-4">
                        <input type="text" name="search" x-model="search" placeholder="Cari Nama Karyawan..." class="form-input block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                        <button type="submit" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cari</button>
                    </div>
                    
                    <input type="hidden" name="period_id" value="{{ $selectedPeriod->id }}">
                </form>                

                <!-- Tabel Data Karyawan Belum Dinilai -->
                <h2 class="text-xl font-bold mt-8 text-gray-800 dark:text-gray-200">Karyawan Belum Dinilai</h2>
                <table class="min-w-full bg-white dark:bg-gray-800 border-gray-300 border shadow-sm mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">NO</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">NAMA KARYAWAN</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">EMAIL</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($unassessedEmployees as $index => $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->email }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                                <a href="{{ route('employees.subcriteriaEvaluation', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Nilai</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada karyawan yang belum dinilai di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Tabel Data Karyawan Sudah Dinilai -->
                <h2 class="text-xl font-bold mt-8 text-gray-800 dark:text-gray-200">Karyawan Sudah Dinilai</h2>
                <table class="min-w-full border-t border-r border-l bg-white dark:bg-gray-800 border-gray-300 shadow-sm mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">No</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Nama Karyawan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Email</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Total Nilai</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assessedEmployees as $index => $employee)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-700 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-700 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-700 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->email }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-700 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                                {{ number_format($employee->relativeScore, 2) ?? 'N/A' }}%
                            </td>
                            <td class="flex justify-center space-x-2 px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-700 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                                <form action="{{ route('scores.detail', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" method="GET" class="inline-block relative group">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 hover:bg-green-700 text-white">
                                        <i class="fas fa-info"></i>
                                    </button>
                                    <!-- Tooltip untuk Detail -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                                        Detail
                                    </div>
                                </form>
                                
                                <form action="{{ route('scores.edit', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" method="GET" class="inline-block relative group">
                                    @csrf
                                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 hover:bg-blue-700 text-white">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                                        Edit
                                    </div>
                                </form>

                                <form action="{{ route('scores.delete', ['employeeId' => $employee->id, 'periodId' => $selectedPeriod->id]) }}" method="POST" class="inline-block relative group">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-500 hover:bg-red-700 text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                                        Delete
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada karyawan yang sudah dinilai di periode ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

