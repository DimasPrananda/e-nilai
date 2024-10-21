<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Edit Penilaian Subkriteria untuk {{ $employee->name }}</h1>
            <form action="{{ route('scores.update', ['employee' => $employee->id, 'period' => $period->id]) }}" method="POST">
                @csrf
                @foreach($subcriterias as $subcriteria)
                    @isset($subcriteria->id)
                        <div class="mb-4">
                            <label for="score_{{ $subcriteria->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->detail }}:</label>
                            <input type="number" name="scores[{{ $subcriteria->id }}]" id="score_{{ $subcriteria->id }}"
                                value="{{ old('scores.'.$subcriteria->id, $scores[$subcriteria->id] ?? '') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200"
                                required>
                        </div>
                    @endisset
                @endforeach
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
