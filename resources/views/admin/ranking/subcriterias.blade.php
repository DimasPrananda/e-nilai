<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Data Sub Kriteria</h1>

                <!-- Formulir Input Sub Kriteria -->
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

                <!-- Filter Form -->
                <div class="mt-8 mb-4">
                    <form method="GET" action="{{ route('admin.ranking.subcriterias') }}">
                        <label for="filter_ranking_criteria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter Kriteria:</label>
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
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full border divide-y divide-gray-200 dark:divide-gray-700 border-gray-700 dark:border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Nama Sub Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Penjelasan/Detail</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @forelse($ranking_subcriterias as $index => $ranking_subcriteria)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->detail }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->ranking_criteria->name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">
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

