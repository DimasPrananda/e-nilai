<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <!-- Formulir Input Periode -->
                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Tambah Periode</h1>
                <form action="{{ route('admin.periods.store') }}" method="POST">
                    @csrf
                    <div class="flex space-x-4 mb-4">
                        <div class="flex-1">
                            <label for="start_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Dari:</label>
                            <input type="number" name="start_year" id="start_year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required min="1900" max="2099">
                        </div>
                        <div class="flex-1">
                            <label for="end_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Sampai:</label>
                            <input type="number" name="end_year" id="end_year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required min="1900" max="2099">
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </form>
                                
                <!-- Tabel Data Periode -->
                <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Daftar Periode</h2>
                <table class="min-w-full mt-4">
                    <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">No</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Periode</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class=" border border-t-0 bg-white dark:bg-gray-900">
                        @forelse($periods as $index => $period)
                        <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}.</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $period->period }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <form action="{{ route('admin.periods.destroy', $period->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this period?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" aria-label="Delete period">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada periode ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
