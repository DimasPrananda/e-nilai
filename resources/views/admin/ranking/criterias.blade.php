<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full" x-data="{ open: false, showModal: false, selectedCriteria: null }">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="p-5 md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Kelola Data Kriteria Karyawan Terbaik</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Kriteria Karyawan Terbaik</a>
        </div>

        <form action="{{ route('ranking_criterias.store') }}" method="POST" x-show="open" x-transition class="mb-8">
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

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-1 justify-between items-center mb-4">
                <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Kriteria</h2>
                <button @click="open = !open" class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                    <span x-text="open ? 'Tutup' : 'Tambah'"></span>
                </button>
            </div>

            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class="border-b-2 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Nama Kriteria</th>
                            <th>Nilai Maksimal</th>
                            <th>Intensitas</th>
                            <th>Evaluasi Faktor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        @forelse($ranking_criterias as $index => $ranking_criteria)
                        <tr class=" border-b border-gray-300 dark:border-gray-700">
                            <td class="text-center py-2">{{ $index + 1 }} .</td>
                            <td class="py-2">{{ $ranking_criteria->name }}</td>
                            <td class="text-center py-2">{{ $ranking_criteria->nilai_max }}</td>
                            <td class="text-center py-2">{{ $ranking_criteria->intensity }}</td>
                            <td class="text-center py-2">{{ $ranking_criteria->evaluations }}</td>
                            <td class="flex justify-center gap-2 text-center py-2">
                                <button @click="selectedCriteria = {{ $ranking_criteria }}; showModal = true" class="flex items-center justify-center w-8 h-8 rounded-full bg-yellow-500 hover:bg-yellow-700 text-white">
                                    <i class="fas fa-edit"></i>
                                </button>
                            
                                <form action="{{ route('ranking_criterias.destroy', $ranking_criteria->id) }}" class="inline-block relative group" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" items-center justify-center w-8 h-8 rounded-full bg-red-500 hover:bg-red-700 text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                                        Delete
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada kriteria ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class=" text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        <tr>
                            <td colspan="3" class="py-4 text-center ">
                                <strong>Total</strong>
                            </td>
                            <td class="py-4 text-center ">
                                <strong>{{ $total_intensity }}</strong>
                            </td>
                            <td class="py-4 text-center ">
                                <strong>{{ number_format($total_evaluation_weight, 4) }}</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click.self="showModal = false">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
                <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">Edit Kriteria</h2>
                <form action="{{ route('ranking_criterias.update', 'update') }}" method="POST" @submit.prevent="updateCriteria">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" x-model="selectedCriteria.id">
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-200">Nama Kriteria</label>
                        <input type="text" name="name" id="name" x-model="selectedCriteria.name" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label for="intensity" class="block text-gray-700 dark:text-gray-200">Nilai Intensitas</label>
                        <input type="number" name="intensity" id="intensity" x-model="selectedCriteria.intensity" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="mb-4">
                        <label for="nilai_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Maksimal</label>
                        <input type="number" name="nilai_max" id="nilai_max" x-model="selectedCriteria.nilai_max" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" @click="showModal = false" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
