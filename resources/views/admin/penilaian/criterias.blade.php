<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot> --}}

    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Data Kriteria</h1>
                <!-- Formulir Input Kriteria -->
                <form action="{{ route('criterias.store') }}" method="POST">
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
                <table class="min-w-full bg-white dark:bg-gray-800 border-gray-300 border shadow-sm mt-4">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">ID</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Nama Kriteria</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Penjelasan/Detail</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($criterias as $index => $criteria)
                        <tr>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-left text-sm leading-4 font-medium text-gray-700 dark:text-gray-300 w-1/4">{{ $criteria->name }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-left text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $criteria->detail }}</td>
                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300 w-1/4">
                                <form action="{{ route('criterias.destroy', $criteria->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this criteria?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada kriteria ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>