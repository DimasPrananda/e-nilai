<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1" x-data="{ open: false }">
            <div class="container mx-auto p-4">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Data Golongan</h1>

                <!-- Tombol untuk toggle form input golongan -->
                <button @click="open = !open" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    <span x-text="open ? 'Sembunyikan Formulir' : 'Tampilkan Formulir'"></span>
                </button>

                <!-- Formulir Input Golongan -->
                <form action="{{ route('golongan.store') }}" method="POST" x-show="open" x-transition>
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Golongan:</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>

                    <div class="mb-4">
                        <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Jabatan:</label>
                        <select name="position_id" id="position_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                            <option value="">Pilih Jabatan</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}">{{ $position->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </form>

                <!-- Filter Form -->
                <div class="mt-4 mb-4">
                    <form method="GET" action="{{ route('admin.golongans') }}">
                        <select id="filter_position_id" name="position_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" onchange="this.form.submit()">
                            <option value="">Semua Jabatan</option>
                            @foreach($positions as $position)
                                <option value="{{ $position->id }}" {{ request('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Tabel Data Golongan -->
                <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Golongan</h2>
                <table class="min-w-full mt-4">
                    <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">No</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nama Golongan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Jabatan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border border-t-0 bg-white dark:bg-gray-900">
                        @forelse($golongans as $index => $golongan)
                        <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">{{ $index + 1 }} .</td>
                            <td class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">{{ $golongan->name }}</td>
                            <td class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">{{ $golongan->position->name }}</td>
                            <td class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">
                                <form action="{{ route('golongan.destroy', $golongan->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this golongan?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada golongan ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>