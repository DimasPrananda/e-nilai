<x-app-layout>
    <div class="p-4 md:p-12 flex-1">
        <div class="p-5 md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Formulir Penilaian Karyawan {{ $employee->name }}</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="javascript:void(0);" onclick="history.back();" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ Kelola Data Penilaian</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold">/ Formulir Penilaian Karyawan</a>
        </div>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Formulir Penilaian</h2>
            <form action="{{ route('employees.storeSubcriteriaEvaluation', ['employee' => $employee->id, 'period' => $period->id]) }}" method="POST">
                @csrf
                @foreach($subcriterias as $criteriaName => $criteriaSubcriterias)
                    <div class="mb-6 border-b border-gray-300 dark:border-gray-600">
                        <h2 class="text-xl font-semibold mb-2 text-gray-800 dark:text-gray-200">{{ $criteriaName }}</h2>
                        @foreach($criteriaSubcriterias as $subcriteria)
                            <div class="mb-4">
                                <label for="score_{{ $subcriteria->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $subcriteria->detail }}:</label>
                                <input type="number" name="scores[{{ $subcriteria->id }}]" id="score_{{ $subcriteria->id }}" value="{{ old('scores.'.$subcriteria->id) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <div class="flex justify-end gap-4">
                    <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Reset
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
