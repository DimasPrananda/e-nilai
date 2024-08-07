<x-app-layout>
    <div class="p-12 flex-1">
        <div class="container mx-auto p-4">
            <!-- Tombol Tambah Karyawan -->
            <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                Tambah Karyawan
            </a>

            <!-- Filter Berdasarkan Departemen -->
            <div class="mb-4 mt-4">
                <form method="GET" action="{{ route('admin.karyawan.employees') }}">
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
            <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Karyawan</h2>
            <table class="min-w-full bg-white dark:bg-gray-800 border-gray-300 border shadow-sm mt-4">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">No</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Nama Karyawan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Nomor Karyawan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Departemen</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Jabatan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Golongan</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $index => $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->employee_number }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->department->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->position->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $employee->golongan->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                            <a href="{{ route('admin.karyawan.edit', $employee->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                            <form action="{{ route('admin.karyawan.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
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
</x-app-layout>
