<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1" x-data="{ open: false }">
            <div class="container mx-auto p-4">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Data Kriteria</h1>
                
                <!-- Tombol untuk toggle form input kriteria -->
                <button @click="open = !open" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    <span x-text="open ? 'Sembunyikan Formulir' : 'Tampilkan Formulir'"></span>
                </button>

                <!-- Formulir Input Kriteria -->
                <form action="{{ route('criterias.store') }}" method="POST" x-show="open" x-transition>
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Kriteria:</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label for="detail" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penjelasan/Detail:</label>
                        <textarea name="detail" id="detail" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200"></textarea>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </form>

                <!-- Tabel Data Kriteria -->
                <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Kriteria</h2>
                <table class="min-w-full mt-4">
                    <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">NO</th>
                            <th class="px-6 py-3 w-1/4 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nama Kriteria</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Penjelasan/Detail</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border bg-white dark:bg-gray-900">
                        @forelse($criterias as $index => $criteria)
                        <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }} .</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-left text-sm font-medium text-gray-700 dark:text-gray-300">{{ $criteria->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-left text-sm font-medium text-gray-700 dark:text-gray-300">{{ $criteria->detail }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                <form action="{{ route('criterias.destroy', $criteria->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this criteria?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada kriteria ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
