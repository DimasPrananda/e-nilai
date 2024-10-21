<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="container mx-auto p-4">
            <!-- Informasi Karyawan -->
            <div class="mb-6 bg-white dark:bg-gray-900 rounded-lg shadow border-gray-200 dark:border-gray-700">
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
            <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow">
                <table class="min-w-full">
                    <thead class="border border-b-0 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-3 md:px-0 py-3 w-12 text-center text-xs font-medium border-r text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">
                                No
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium border-r text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">
                                Kriteria
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium border-r text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">
                                Subkriteria
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium border-r text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">
                                Nilai
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">
                                Predikat
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border border-t-0 border-b-0 bg-white dark:bg-gray-900 dark:divide-gray-700">
                        @php
                            $totalScore = 0;
                        @endphp
                        @foreach($criterias as $criteria)
                            @foreach($criteria->subcriterias as $subcriteria)
                                <tr class="border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                    @if ($loop->first)
                                        <td class=" py-4 whitespace-nowrap border-r text-center text-sm font-medium text-gray-900 dark:text-gray-100 border-gray-200 dark:border-gray-700" rowspan="{{ count($criteria['subcriterias']) }}">
                                            {{ $loop->parent->iteration }} .
                                        </td>
                                    @endif
                                    @if ($loop->first)
                                        <td class="px-6 py-4 whitespace-nowrap border-r text-sm font-medium text-gray-900 dark:text-gray-100 border-gray-200 dark:border-gray-700" rowspan="{{ $criteria->subcriterias->count() }}">
                                            {{ $criteria->name }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap border-r text-sm text-gray-500 dark:text-gray-300 border-gray-200 dark:border-gray-700">
                                        {{ $subcriteria->detail }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-r text-center text-sm text-gray-500 dark:text-gray-300 border-gray-200 dark:border-gray-700">
                                        @php
                                            $score = $scores[$subcriteria->id] ?? 0;
                                            $totalScore += $score;
                                        @endphp
                                        {{ $score }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-300 border-gray-200 dark:border-gray-700">
                                        @php
                                            $score = $scores[$subcriteria->id] ?? 0;
                                            if ($score >= 80) {
                                                $grade = 'A';
                                            } elseif ($score >= 70) {
                                                $grade = 'B';
                                            } elseif ($score >= 60) {
                                                $grade = 'C';
                                            } elseif ($score >= 50) {
                                                $grade = 'D';
                                            } else {
                                                $grade = 'E';
                                            }
                                        @endphp
                                        {{ $grade }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="border border-t-0 border-gray-700 dark:border-gray-200 bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                Total Skor
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $totalScore }}
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 dark:text-gray-100">
                                <!-- Kosong karena predikat tidak dihitung pada total -->
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
