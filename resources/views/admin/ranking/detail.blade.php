<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                <!-- Informasi Karyawan -->
                <div class="mb-6 bg-white dark:bg-gray-900">
                    <h2 class="text-xl mb-4 font-semibold text-gray-800 dark:text-gray-200">Informasi Karyawan</h2>
                    <div class="flex gap-4">
                        <div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">Periode</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">Nama</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">Nomor Pegawai</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span class="font-semibold">Jabatan</span>
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span>: {{ $period->period }}</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span>: {{ $employee->name }}</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span>: {{ $employee->employee_number }}</span>
                            </div>
                            <div class="text-gray-700 dark:text-gray-300">
                                <span>: {{ $employee->position->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Penilaian -->
                <h2 class="text-xl mb-4 font-semibold text-gray-800 dark:text-gray-300">Detail Penilaian</h2>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full border divide-y divide-gray-200 dark:divide-gray-700 border-gray-700 dark:border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">
                                    No
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">
                                    Kriteria
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">
                                    Subkriteria
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">
                                    Nilai
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">
                                    Total Subkriteria
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach($criterias as $criteria)
                                @foreach($criteria['subcriterias'] as $subcriteria)
                                    <tr>
                                        @if ($loop->first)
                                            <td class="px-6 py-4 whitespace-nowrap border-r text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700" rowspan="{{ count($criteria['subcriterias']) }}">
                                                {{ $loop->parent->iteration }}
                                            </td>
                                        @endif
                                        @if ($loop->first)
                                            <td class="px-6 py-4 whitespace-nowrap border-r text-sm font-medium text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700" rowspan="{{ count($criteria['subcriterias']) }}">
                                                {{ $criteria['name'] }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap border-r text-sm text-gray-500 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                            {{ $subcriteria['detail'] }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-r text-center text-sm text-gray-500 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700">
                                            {{ $subcriteria['score'] }}
                                        </td>
                                        @if ($loop->first)
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300 border-b border-gray-200 dark:border-gray-700" rowspan="{{ count($criteria['subcriterias']) }}">
                                                {{ $criteria['totalSubcriteriaScore'] }}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
                                    Total Skor Semua Kriteria
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
                                    <!-- Kosong karena tidak ada total lain -->
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
                                    {{ $totalScore }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <h2 class="text-xl font-bold mt-8 text-gray-800 dark:text-gray-200">Detail Evaluasi Kriteria</h2>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full bg-white dark:bg-gray-800 border-gray-300 border shadow-sm mt-4">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">No</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Nama Kriteria</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Evaluations Factor</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Factor Weight</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Weight Evaluation</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @foreach ($criteriaDetails as $index => $criteriaDetail)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-b border-gray-300 dark:border-gray-600 text-left text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $criteriaDetail['name'] }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ number_format($criteriaDetail['evaluations_factor'], 2) }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-r border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ $criteriaDetail['factor_weight'] }}</td>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">{{ number_format($criteriaDetail['weight_evaluation'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
                                    Total Hasil Bobot Evaluasi
                                </td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-t border-gray-200 dark:border-gray-700">
                                    {{ number_format($totalWeightEvaluation, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
