<x-app-layout>
    <div class="p-12 flex-1">
        <div class="container mx-auto p-4">
            <h2 class="text-2xl font-bold mt-8 text-gray-800 dark:text-gray-200">Penilaian Karyawan: {{ $employee->name }}</h2>

            <form action="{{ route('admin.penilaian.scores.store', $employee->id) }}" method="POST">
                @csrf
                @foreach($criterias as $criteria)
                    <div class="mt-4">
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">{{ $criteria->name }}</h3>
                        @foreach($criteria->subcriterias as $subcriteria)
                            <div class="flex items-center mb-2">
                                <label for="score_{{ $subcriteria->id }}" class="w-1/3 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->name }}</label>
                                <input type="hidden" name="scores[{{ $subcriteria->id }}][sub_criteria_id]" value="{{ $subcriteria->id }}">
                                <input type="number" id="score_{{ $subcriteria->id }}" name="scores[{{ $subcriteria->id }}][value]" class="w-1/2 border-gray-300 rounded-md shadow-sm dark:bg-gray-800 dark:text-gray-200" min="0">
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <div class="mt-4">
                    <a href="{{ route('admin.penilaian.assessments') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
