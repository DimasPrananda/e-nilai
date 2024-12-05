<x-app-layout>
    <div class=" p-4 md:p-12 flex-1" x-data="{ open: false }">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class=" md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Kelola Data Departemen</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Departemen</a>
        </div>

        <!-- Formulir Input Departemen -->
        <form class="mb-4" action="{{ route('departments.store') }}" method="POST" x-show="open" x-transition>
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Departemen:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </form>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-1 justify-between items-center mb-4">
                <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Departemen</h2>
                <button @click="open = !open" class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                    <span x-text="open ? 'Tutup' : 'Tambah'"></span>
                </button>
            </div>
            <!-- Tabel Data Departemen -->
            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class="border-b-2 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th>No</th>
                            <th>Nama Departemen</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        @forelse($departments as $index => $department)
                        <tr class=" border-b border-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 transition-colors duration-200">
                            <td class="text-center py-2">{{ $index + 1 }} .</td>
                            <td class="py-2">{{ $department->name }}</td>
                            <td class="text-center py-2 ">
                                <form action="{{ route('departments.destroy', $department->id) }}" class="inline-block relative group" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
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
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada departemen ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>