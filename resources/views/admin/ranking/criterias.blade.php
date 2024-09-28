<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4" x-data="{ showForm: false }">
                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Daftar Kriteria</h1>

                <!-- Tombol untuk Menampilkan/Menyembunyikan Formulir Tambah Kriteria -->
                <button @click="showForm = !showForm" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                    <span x-text="showForm ? 'Sembunyikan Formulir Kriteria' : 'Tampilkan Formulir Kriteria'"></span>
                </button>

                <!-- Form Tambah Kriteria -->
                <div x-show="showForm" x-transition>
                    <form action="{{ route('ranking_criterias.store') }}" method="POST" class="mb-8">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 dark:text-gray-200">Nama Kriteria</label>
                            <input type="text" name="name" id="name" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label for="intensity" class="block text-gray-700 dark:text-gray-200">Nilai Intensitas</label>
                            <input type="number" name="intensity" id="intensity" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        </div>
                        <div class="mb-4">
                            <label for="nilai_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Maksimal</label>
                            <input type="number" name="nilai_max" id="nilai_max" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Tambahkan Kriteria</button>
                    </form>
                </div>

                <!-- Tabel Daftar Kriteria -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full">
                        <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                            <tr>
                                <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">N0</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nama Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Nilai Maksimal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Intensitas</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-r border-gray-300 dark:border-gray-700">Evaluasi Faktor</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-r border-l bg-white dark:bg-gray-900">
                            @foreach($ranking_criterias as $ranking_criteria)
                            <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class="py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $loop->iteration }} .</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->nilai_max }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->intensity }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-gray-300 dark:border-gray-700 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ number_format($evaluations[$ranking_criteria->id], 4) }}</td>
                                <td class="flex justify-center px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium">
                                    <form action="{{ route('ranking_criterias.destroy', $ranking_criteria->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?');">
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
                            @endforeach
                        </tbody>
                        <tfoot class="border border-t-0 border-gray-700 dark:border-gray-200">
                            <tr>
                                <td colspan="3" class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <strong>Total</strong>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <strong>{{ $total_intensity }}</strong>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <strong>{{ number_format($total_evaluation_weight, 4) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
