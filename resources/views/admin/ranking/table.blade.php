<x-app-layout>
    <div class="p-4 md:p-12 flex-1 w-screen md:w-full" x-data="{ open: false }">
        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Kelola Data Penilaian Karyawan Terbaik</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="{{ route('admin.ranking.select-periods') }}"class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ {{ $selectedPeriod->period }}</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold ">/ Kelola Data Penilaian Karyawan Terbaik</a>
        </div> 

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4" x-show="open" x-transition>
            <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Data Karyawan Terbaik Departemen</h2>
            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class=" border-b-2 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-center">
                                Nama Karyawan
                            </th>
                            <th class="px-6 py-3 text-center">
                                Departemen
                            </th>
                            <th class="px-6 py-3 text-center">
                                Total Skor
                            </th>
                            <th class="px-6 py-3 text-center">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        @foreach($unassessedEmployees as $department)
                            @foreach($department->employees as $index => $employee)
                                <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        {{ $employee->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $department->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        {{ $employee->total_score ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('rankings.subcriteriaEvaluation', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-lg transition transform hover:-translate-y-1 hover:shadow-xl duration-200 ease-in-out flex items-center justify-center space-x-2">
                                           <i class="fas fa-edit"></i>
                                            <span>Nilai</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>       
            </div>    
        </div>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <div class="flex flex-1 justify-between items-center mb-4">
                <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200">Data Karyawan Terbaik</h2>
                <button @click="open = !open" class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <svg class="w-4 h-4 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5"/>
                    </svg>
                    <span x-text="open ? 'Tutup' : 'Tambah'"></span>
                </button>
            </div>
            <div class="flex overflow-x-auto">
                <table class="flex-1">
                    <thead class=" border-b-2 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class=" text-center py-2">No</th>
                            <th class=" text-center py-2">Nama Karyawan</th>
                            <th class=" text-center py-2">Departemen</th>
                            <th class=" text-center py-2">Total Nilai</th>
                            <th class=" text-center py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                        @forelse($assessedEmployees as $index => $employee)
                            <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-200">
                                <td class=" text-center py-2">{{ $loop->iteration }} .</td>
                                <td class=" text-left py-2 ">{{ $employee->name }}</td>
                                <td class=" text-center py-2">{{ $employee->department->name }}</td>
                                <td class=" text-center py-2">
                                    {{ number_format($employee->total_score * 100, 2) }}
                                </td>
                                <td class="flex justify-center space-x-2 px-6 py-4 whitespace-no-wrap text-center text-sm leading-4 font-medium text-gray-700 dark:text-gray-300">
                                    <form action="{{ route('ranking.detail', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" method="GET" class="inline-block relative group">
                                        @csrf
                                        <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 hover:bg-green-700 text-white transition duration-150 ease-in-out">
                                            <i class="fas fa-info"></i>
                                        </button>
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            Detail
                                        </div>
                                    </form>
                
                                    <form action="{{ route('ranking.delete', ['employeeId' => $employee->id, 'periodId' => $selectedPeriod->id]) }}" method="POST" class="inline-block relative group">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-500 hover:bg-red-700 text-white transition duration-150 ease-in-out">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                            Delete
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-2 text-center">Tidak ada karyawan yang sudah dinilai di periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table> 
            </div>              
        </div>
    </div>
</x-app-layout>
