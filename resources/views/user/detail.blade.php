<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full">
        <div class="p-5 md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Detail Penilaian</h1>
            <a href="{{ route('user.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="javascript:void(0);" onclick="history.back();" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ {{ $selectedPeriod->period }}</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold">/ Detail Penilaian</a>
        </div>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="overflow-x-auto flex">
                <table class="flex-1">
                    <thead class="border-b dark:text-gray-200 text-gray-800">
                        <tr>
                            <th class=" py-2 text-center ">No</th>
                            <th class=" py-2 text-center ">Kriteria</th>
                            <th class=" py-2 text-center ">Subkriteria</th>
                            <th class=" py-2 text-center ">Nilai</th>
                            <th class=" py-2 text-center ">Predikat</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white ">
                        @php $totalScore = 0; @endphp
                        @foreach($criterias as $criteria)
                            @foreach($criteria->subcriterias as $subcriteria)
                                @if(isset($scores[$subcriteria->id]))
                                    <tr class="border-b border-gray-300 dark:border-gray-700 ">
                                        @if ($loop->first)
                                            <td class="py-2 text-center " rowspan="{{ count($criteria->subcriterias) }}">
                                                {{ $loop->parent->iteration }}.
                                            </td>
                                        @endif
                                        @if ($loop->first)
                                            <td class="py-2 " rowspan="{{ $criteria->subcriterias->count() }}">
                                                {{ $criteria->name }}
                                            </td>
                                        @endif
                                        <td class="py-2 ">
                                            {{ $subcriteria->detail }}
                                        </td>
                                        <td class="py-2  text-center ">
                                            @php
                                                $score = $scores[$subcriteria->id] ?? 0;
                                                $totalScore += $score;
                                            @endphp
                                            {{ $score }}
                                        </td>
                                        <td class="py-2 text-center">
                                            @php
                                                $grade = match (true) {
                                                    $score >= 80 => 'A',
                                                    $score >= 70 => 'B',
                                                    $score >= 60 => 'C',
                                                    $score >= 50 => 'D',
                                                    default => 'E',
                                                };
                                            @endphp
                                            {{ $grade }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-center text-gray-800 dark:text-gray-200 py-2">Total Skor</td>
                            <td class="text-center text-gray-800 dark:text-gray-200 py-2">{{ $totalScore }}</td>
                            <td class="text-center text-gray-800 dark:text-gray-200 py-2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
