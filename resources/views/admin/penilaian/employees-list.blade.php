@php
    $allEmployees = $unassessedEmployees->merge($assessedEmployees);
@endphp
@php
    $currentPage = $assessedEmployees->currentPage() ?? 1;
    $perPage = $assessedEmployees->perPage();
@endphp
@forelse($allEmployees as $index => $employee)
    <tr class="border-b border-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 transition-colors duration-200">
        <td class="text-center py-2 px-6">{{ ($currentPage - 1) * $perPage + $index + 1 }} .</td>
        <td>{{ $employee->name }}</td>
        <td class="text-center py-2 px-6">{{ $employee->department->name }}</td>
        <td class="text-center py-2 px-6">{{ number_format($employee->relativeScore, 2) ?? 'N/A' }}%</td>
        <td class="text-center py-2 px-6">
            @if($employee->relativeScore)
                <span class="bg-green-200 text-green-800 font-semibold py-1 px-2 rounded-full">Dinilai</span>
            @else
                <span class="bg-yellow-200 text-yellow-800 font-semibold py-1 px-2 rounded-full">Belum</span>
            @endif
        </td>
        <td class="px-6 py-4 text-sm text-center text-gray-600 dark:text-gray-300 border-gray-200 dark:border-gray-700">
            @if($employee->relativeScore)
                <form action="{{ route('scores.detail', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" method="GET" class="inline-block relative group">
                    @csrf
                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-green-500 hover:bg-green-700 text-white">
                        <i class="fas fa-info"></i>
                    </button>
                    <!-- Tooltip untuk Detail -->
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                        Detail
                    </div>
                </form>
            
                <form action="{{ route('scores.edit', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" method="GET" class="inline-block relative group">
                @csrf
                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 hover:bg-blue-700 text-white">
                        <i class="fas fa-edit"></i>
                    </button>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                        Edit
                    </div>
                </form>
                <form action="{{ route('scores.delete', ['employeeId' => $employee->id, 'periodId' => $selectedPeriod->id]) }}" method="POST" class="inline-block relative group">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-500 hover:bg-red-700 text-white">
                        <i class="fas fa-trash"></i>
                    </button>
                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                        Delete
                    </div>
                </form>
            @else
                <a href="{{ route('employees.subcriteriaEvaluation', ['employee' => $employee->id, 'period' => $selectedPeriod->id]) }}" class="md:flex py-2 px-7 gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-lg shadow-lg transition transform hover:-translate-y-1 hover:shadow-xl duration-200 ease-in-out items-center justify-center">
                    <i class="fas fa-edit"></i>
                    <span class="hidden md:block">Nilai</span>
                </a>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4">Tidak ada karyawan di departemen ini.</td>
    </tr>
@endforelse
<tr>
    <td colspan="7" id="pagination-links" class="text-center py-4" >
        <!-- Pagination links will be injected here -->
    </td>
</tr>