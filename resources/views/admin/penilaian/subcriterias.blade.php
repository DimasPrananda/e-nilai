<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="container mx-auto p-4" x-data="{ showForm: false }">
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Data Sub Kriteria</h1>

            <!-- Tombol untuk Menampilkan/Menyembunyikan Formulir Input Sub Kriteria -->
            <button @click="showForm = !showForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                <span x-text="showForm ? 'Sembunyikan Formulir' : 'Tampilkan Formulir'"></span>
            </button>

            <!-- Formulir Input Sub Kriteria -->
            <div x-show="showForm" x-transition>
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
            </div>

            <!-- Filter Form -->
            <div class="mt-4 mb-4">
                <form method="GET" action="{{ route('admin.penilaian.subcriterias') }}">
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
            <div class="overflow-x-auto w-full">
                <table class="min-w-full mt-4">
                    <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-3 md:px-0 py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">No</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nama Sub Kriteria</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Penjelasan/Detail</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Kriteria</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border border-t-0 bg-white dark:bg-gray-900">
                        @forelse($subcriterias as $index => $subcriteria)
                        <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }} .</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-left text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->detail }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->criteria->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">                                
                                <!-- Tombol Delete -->
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
