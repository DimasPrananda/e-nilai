<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Pilih Periode Penilaian</h1>
            <!-- Formulir Pemilihan Periode -->
            <form action="{{ route('user.detail', ':period_id') }}" method="GET" onsubmit="this.action = this.action.replace(':period_id', document.getElementById('period').value);">
                @csrf
                <div class="mb-4">
                    <label for="period" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Periode:</label>
                    <select name="period_id" id="period" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                        @foreach($periods as $period)
                            <option value="{{ $period->id }}">{{ $period->period }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pilih</button>
            </form>
        </div>
    </div>
</x-app-layout>
