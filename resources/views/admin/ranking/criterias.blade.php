<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Daftar Kriteria</h1>

                <!-- Form Tambah Kriteria -->
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

                <!-- Tabel Daftar Kriteria -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full border divide-y divide-gray-200 dark:divide-gray-700 border-gray-700 dark:border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Nama Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Nilai Maksimal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Intensitas</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Evaluasi Faktor</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach($ranking_criterias as $ranking_criteria)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->name }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->nilai_max }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->intensity }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ number_format($evaluations[$ranking_criteria->id], 4) }}</td>
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
                        <tfoot>
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                    <strong>Total</strong>
                                </td>
                                <td class="px-6 py-4 whitespace-no-wrap border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
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
