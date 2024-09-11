<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Input Penilaian Karyawan</h1>
                <form action="{{ route('penilaian.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="employee_id" value="{{ $employeeId }}">
                    <input type="hidden" name="period_id" value="{{ $periodId }}">

                    @foreach($ranking_criterias as $ranking_criteria)
                        <div class="mb-4">
                            <label for="criteria_{{ $ranking_criteria->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_criteria->name }} ({{ $ranking_criteria->intensity }}):</label>
                            @foreach($ranking_criteria->ranking_subcriterias as $ranking_subcriteria)
                                <div class="mb-2">
                                    <label for="subcriteria_{{ $ranking_subcriteria->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $ranking_subcriteria->name }}:</label>
                                    <input type="number" name="ranking_criteria[{{ $ranking_subcriteria->id }}]" id="ranking_subcriteria_{{ $ranking_subcriteria->id }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" min="1" max="4" step="1" required>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
