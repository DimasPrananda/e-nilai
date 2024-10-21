<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="container mx-auto p-4" x-data="{ formValid: true, scores: {} }">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Penilaian Subkriteria untuk {{ $employee->name }}</h1>
            <form action="{{ route('rankings.storeSubcriteriaEvaluation', ['employee' => $employee->id, 'period' => $period->id]) }}" method="POST" @submit.prevent="if (formValid) $el.submit()">
                @csrf
                @foreach($subcriterias as $criteriaName => $criteriaSubcriterias)
                    <div class="mb-6 border-b border-gray-300 dark:border-gray-600">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">{{ $criteriaName }}</h2>
                        @foreach($criteriaSubcriterias as $subcriteria)
                            <div class="mb-4">
                                <label for="score_{{ $subcriteria->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ $subcriteria->detail }} 
                                    @if($subcriteria->ranking_criteria && $subcriteria->ranking_criteria->nilai_max)
                                        (Max: {{ $subcriteria->ranking_criteria->nilai_max }})
                                    @endif
                                </label>
                                <input type="number" name="scores[{{ $subcriteria->id }}]" id="score_{{ $subcriteria->id }}"
                                       x-model="scores[{{ $subcriteria->id }}]" 
                                       @input="formValid = scores[{{ $subcriteria->id }}] <= {{ $subcriteria->ranking_criteria->nilai_max }}; if (!formValid) { alert('Nilai tidak boleh melebihi nilai maksimal: {{ $subcriteria->ranking_criteria->nilai_max }}') }" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" 
                                       required max="{{ $subcriteria->nilai_max }}" min="0">
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" :disabled="!formValid">Simpan</button>
            </form>
        </div>
    </div>
</x-app-layout>
