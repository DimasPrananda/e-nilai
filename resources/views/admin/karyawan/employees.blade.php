<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif
            <!-- Tombol Tambah Karyawan -->
            <div class="mt-4 md:mt-0">
                <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Karyawan
                </a>
            </div>

            <!-- Filter Berdasarkan Departemen -->
            <div class="mb-4 mt-4">
                <form method="GET" action="{{ route('admin.karyawan.employees') }}">
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
            <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Karyawan</h2>
            <div class="overflow-x-auto w-full"> 
                <table class="min-w-full mt-4 bg-white dark:bg-gray-900">
                    <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-3 md:px-0 py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">No</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nama Karyawan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nomor Karyawan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Departemen</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Jabatan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Golongan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border border-t-0 bg-white dark:bg-gray-900">
                        @forelse($employees as $index => $employee)
                            <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class="py-4 w-12 whitespace-nowrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }} .</td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-300 dark:border-gray-700 text-left text-sm font-medium text-gray-700 dark:text-gray-300">{{ $employee->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $employee->employee_number }}</td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $employee->department->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $employee->position->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $employee->golongan->name }}</td>
                                <td class="flex justify-center space-x-2 px-6 py-4 whitespace-nowrap border-b border-gray-300 dark:border-gray-700 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                                    <form action="{{ route('admin.karyawan.edit', $employee->id) }}" method="GET" class="inline-block relative group">
                                        @csrf
                                        <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 hover:bg-blue-700 text-white">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                                            Edit
                                        </div>
                                    </form>

                                    <form action="{{ route('admin.karyawan.destroy', $employee->id) }}" method="POST" class="inline-block relative group">
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
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada karyawan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
