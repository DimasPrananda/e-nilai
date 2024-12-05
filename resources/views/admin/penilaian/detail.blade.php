<x-app-layout>
    <div class="p-4 md:p-12 flex-1">
        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Detail Penilaian Karyawan</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="{{ route('admin.penilaian.select-periods') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ {{ $selectedPeriod->period }}</a>
            <a href="javascript:void(0);" onclick="history.back();" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ Kelola Data Penilaian</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold">/ Detail Penilaian Karyawan</a>
        </div>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Informasi Karyawan</h2>
            <div class="flex overflow-x-auto mb-4">
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
            
            
        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Detail Penilaian</h2>
            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class="border-b text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="">
                                No
                            </th>
                            <th class="">
                                Kriteria
                            </th>
                            <th class="">
                                Subkriteria
                            </th>
                            <th class="">
                                Nilai
                            </th>
                            <th class="">
                                Predikat
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">
                        @php
                            $totalScore = 0;
                        @endphp
                        @foreach($criterias as $criteria)
                            @foreach($criteria->subcriterias as $subcriteria)
                                <!-- Cek apakah subkriteria sudah dinilai -->
                                @if(isset($scores[$subcriteria->id]))
                                    <tr class="border-b border-gray-300 dark:border-gray-700 ">
                                        @if ($loop->first)
                                            <td class=" text-center py-2" rowspan="{{ count($criteria->subcriterias) }}">
                                                {{ $loop->parent->iteration }}.
                                            </td>
                                        @endif
                                        @if ($loop->first)
                                            <td class="py-2" rowspan="{{ $criteria->subcriterias->count() }}">
                                                {{ $criteria->name }}
                                            </td>
                                        @endif
                                        <td class="py-2">
                                            {{ $subcriteria->detail }}
                                        </td>
                                        <td class="text-center py-2">
                                            @php
                                                $score = $scores[$subcriteria->id] ?? 0;
                                                $totalScore += $score;
                                            @endphp
                                            {{ $score }}
                                        </td>
                                        <td class="text-center py-2">
                                            @php
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
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot class="">
                        <tr>
                            <td colspan="3" class="text-center text-gray-800 dark:text-gray-200 py-2">
                                Total Skor
                            </td>
                            <td class="text-center text-gray-800 dark:text-gray-200 py-2">
                                {{ $totalScore }}
                            </td>
                            <td class="text-center text-gray-800 dark:text-gray-200 py-2">
                                <!-- Kosong karena predikat tidak dihitung pada total -->
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
