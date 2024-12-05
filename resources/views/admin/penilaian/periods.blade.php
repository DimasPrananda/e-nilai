<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full" x-data="{ open: false }">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="p-5 md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Kelola Data Periode</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">dashboard </a><a class="text-gray-800 dark:text-gray-200 font-bold">/ Kelola Data Periode</a>
        </div>

        <!-- Formulir Input Periode -->
        <form class="mb-4" action="{{ route('admin.periods.store') }}" method="POST" x-show="open" x-transition>
            @csrf
            <div class="flex items-center  space-x-4 mb-4">
                <div>
                    <h4 class=" text-gray-700 dark:text-gray-300">Tahun dari :</h4>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <select name="start_month" id="start_month" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200">
                                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <input type="number" name="start_year" id="start_year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200" required min="1900" max="2099">
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class=" text-gray-700 dark:text-gray-300">Tahun dari :</h4>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <select name="end_month" id="end_month" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200">
                                @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                    <option value="{{ $month }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex-1">
                            <input type="number" name="end_year" id="end_year" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200" required min="1900" max="2099">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
        </form>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-1 justify-between items-center mb-4">
                <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Periode</h2>
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
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        @forelse($periods as $index => $period)
                        <tr class=" border-b border-gray-300 dark:border-gray-700">
                            <td class="text-center py-2">{{ $index + 1 }} .</td>
                            <td class="py-2">{{ $period->period }}</td>
                            <td class="text-center py-2">
                                <form action="{{ route('admin.periods.destroy', $period->id) }}" class="inline-block relative group" method="POST" onsubmit="return confirm('Are you sure you want to delete this period?');">
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
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada periode ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
