@php
    $page = request()->get('page', 1); 
    $perPage = $employees->perPage();
    $startIndex = ($page - 1) * $perPage; 
@endphp
@forelse($employees as $index => $employee)
    <tr class="border-b border-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 transition-colors duration-200">
        <td class="text-center py-2">{{ $startIndex + $index + 1 }} .</td>
        <td>{{ $employee->name }}</td>
        <td class="text-center py-2">{{ $employee->employee_number }}</td>
        <td class="text-center py-2">{{ $employee->department->name }}</td>
        <td class="text-center py-2">{{ $employee->position->name }}</td>
        <td class="text-center py-2">{{ $employee->golongan->name }}</td>
        <td class="text-center py-2">
            <form action="{{ route('admin.karyawan.edit', $employee->id) }}" method="GET" class="inline-block relative group">
                @csrf
                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-500 hover:bg-blue-700 text-white">
                    <i class="fas fa-edit"></i>
                </button>
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                    Edit
                </div>
            </form>

            <form action="{{ route('admin.karyawan.destroy', $employee->id) }}" method="POST" class="inline-block relative group">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center justify-center w-8 h-8 rounded-full bg-red-500 hover:bg-red-700 text-white">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 px-2 py-1 text-xs text-white bg-gray-800 rounded opacity-0 group-hover:opacity-100">
                    Delete
                </div>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4">Tidak ada karyawan di departemen ini.</td>
    </tr>
@endforelse
<tr>
    <td colspan="7" class="text-center py-4" id="pagination-links">
        <!-- Render pagination links dengan mempertahankan query parameters -->
        {{ $employees->appends(request()->query())->links() }}
    </td>
</tr>