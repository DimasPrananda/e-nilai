<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Detail Penilaian Karyawan Terbaik</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="{{ route('admin.ranking.select-periods') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ {{ $selectedPeriod->period }}</a>
            <a href="javascript:void(0);" onclick="history.back();" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ Kelola Data Penilaian Karyawan Terbaik</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold">/ Detail Penilaian Karyawan</a>
        </div>
        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Informasi Karyawan</h2>
            <div class="flex overflow-x-auto">
                <table class=" flex-1 md:w-1/2">
                    <tbody class=" text-gray-800 dark:text-gray-200">
                        <tr class="py-2">
                            <td>Periode</td>
                            <td>: {{ $period->period }}</td>
                        </tr>
                        <tr class="py-2">
                            <td>Nama</td>
                            <td>: {{ $employee->name }}</td>
                        </tr>
                        <tr class="py-2">
                            <td>Nomor</td>
                            <td>: {{ $employee->employee_number }}</td>
                        </tr>
                        <tr class="py-2">
                            <td>Jabatan</td>
                            <td>: {{ $employee->position->name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Detail Penilaian</h2>
            <div class="overflow-x-auto flex mb-4">
                <table class="flex-1">
                    <thead class="border-b text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class=" py-3 text-center">
                                No
                            </th>
                            <th class=" py-3 text-center">
                                Kriteria
                            </th>
                            <th class=" py-3 text-center">
                                Subkriteria
                            </th>
                            <th class=" py-3 text-center">
                                Nilai
                            </th>
                            <th class=" py-3 text-center">
                                Total Subkriteria
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        @foreach($criterias as $criteria)
                            @foreach($criteria['subcriterias'] as $subcriteria)
                                <tr class="border-b border-gray-300 dark:border-gray-700 ">
                                    @if ($loop->first)
                                        <td class=" text-center py-2" rowspan="{{ count($criteria['subcriterias']) }}">
                                            {{ $loop->parent->iteration }} .
                                        </td>
                                    @endif
                                    @if ($loop->first)
                                        <td class="py-2" rowspan="{{ count($criteria['subcriterias']) }}">
                                            {{ $criteria['name'] }}
                                        </td>
                                    @endif
                                    <td class="py-2">
                                        {{ $subcriteria['detail'] }}
                                    </td>
                                    <td class=" text-center py-2">
                                        {{ $subcriteria['score'] }}
                                    </td>
                                    @if ($loop->first)
                                        <td class="py-2  text-center " rowspan="{{ count($criteria['subcriterias']) }}">
                                            {{ $criteria['totalSubcriteriaScore'] }}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="">
                        <tr>
                            <td colspan="4" class="py-2 text-center text-gray-800 dark:text-gray-300">
                                Total Skor Semua Kriteria
                            </td>
                            <td class="py-2 text-center text-gray-800 dark:text-gray-300">
                                {{ $totalScore }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Detail Evaluasi Kriteria</h2>
            <div class=" overflow-x-auto flex">
                <table class="flex-1">
                    <thead class="border-b text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class=" py-2 text-center">No</th>
                            <th class=" py-2 text-center">Nama Kriteria</th>
                            <th class=" py-2 text-center">Evaluations Factor</th>
                            <th class=" py-2 text-center">Factor Weight</th>
                            <th class=" py-2 text-center">Weight Evaluation</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">                            
                        @foreach ($criteriaDetails as $index => $criteriaDetail)
                        <tr class="border-b border-gray-300 dark:border-gray-700  hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                            <td class="py-2 text-center">{{ $index + 1 }} .</td>
                            <td class=" py-2 text-left">{{ $criteriaDetail['name'] }}</td>
                            <td class=" py-2 text-center">{{ number_format($criteriaDetail['evaluations_factor'], 2) }}</td>
                            <td class=" py-2 text-center">{{ $criteriaDetail['factor_weight'] }}</td>
                            <td class=" py-2 text-center">{{ number_format($criteriaDetail['weight_evaluation'], 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="">
                        <tr>
                            <td colspan="4" class="py-2 text-center dark:text-gray-300 text-gray-800">
                                Total Hasil Bobot Evaluasi
                            </td>
                            <td class="py-2 text-center dark:text-gray-300 text-gray-800">
                                {{ number_format($totalWeightEvaluation, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>    
        </div>
    </div>
</x-app-layout>
