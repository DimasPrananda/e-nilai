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
                <form action="{{ route('subcriteria.store') }}" method="POST">
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
                        <label for="criteria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pilih Kriteria:</label>
                        <select name="criteria_id" id="criteria_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                            <option value="">Pilih Kriteria</option>
                            @foreach($criterias as $criteria)
                                <option value="{{ $criteria->id }}">{{ $criteria->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </form>

                <!-- Filter Form -->
                <div class="mt-8 mb-4">
                    <form method="GET" action="{{ route('admin.penilaian.subcriterias') }}">
                        <label for="filter_criteria_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter Kriteria:</label>
                        <select id="filter_criteria_id" name="criteria_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" onchange="this.form.submit()">
                            <option value="">Semua Kriteria</option>
                            @foreach($criterias as $criteria)
                                <option value="{{ $criteria->id }}" {{ request('criteria_id') == $criteria->id ? 'selected' : '' }}>
                                    {{ $criteria->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <!-- Tabel Data Sub Kriteria -->
                <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Data Sub Kriteria</h2>
                <table class="min-w-full bg-white dark:bg-gray-800 border-gray-300 border shadow-sm mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">No</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Nama Sub Kriteria</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Penjelasan/Detail</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Kriteria</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subcriterias as $index => $subcriteria)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-left text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->detail }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->criteria->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">                                <!-- Tombol Delete -->
                                <form action="{{ route('subcriteria.destroy', $subcriteria->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcriteria?');" class="inline-block">
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
</x-app-layout>

