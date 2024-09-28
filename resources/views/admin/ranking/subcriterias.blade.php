<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4" x-data="{ showForm: false }">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Data Sub Kriteria</h1>

                <!-- Tombol untuk Menampilkan/Menyembunyikan Formulir Input Sub Kriteria -->
                <button @click="showForm = !showForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    <span x-text="showForm ? 'Sembunyikan Formulir Input' : 'Tampilkan Formulir Input'"></span>
                </button>

                <!-- Formulir Input Sub Kriteria -->
                <div x-show="showForm" x-transition>
                    <form action="{{ route('ranking_subcriteria.store') }}" method="POST">
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

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    </form>
                </div>

                <!-- Filter Form -->
                <div class="mt-4 mb-4">
                    <form method="GET" action="{{ route('admin.ranking.subcriterias') }}">
                        <select id="filter_ranking_criteria_id" name="ranking_criteria_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" onchange="this.form.submit()">
                            <option value="">Semua Kriteria</option>
                            @foreach($ranking_criterias as $ranking_criteria)
                                <option value="{{ $ranking_criteria->id }}" {{ request('ranking_criteria_id') == $ranking_criteria->id ? 'selected' : '' }}>
                                    {{ $ranking_criteria->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Tabel Data Sub Kriteria -->
                <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Sub Kriteria</h2>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-4">
                    <table class="min-w-full">
                        <thead class=" border border-b-0 bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">No</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nama Sub Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Penjelasan/Detail</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border border-t-0 bg-white dark:bg-gray-900">
                            @forelse($ranking_subcriterias as $index => $ranking_subcriteria)
                            <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class="py-4 w-12 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }} .</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-left text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->detail }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->ranking_criteria->name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">
                                    <form action="{{ route('subcriteria.destroy', $ranking_subcriteria->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcriteria?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada subcriteria ditemukan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>