@php
    $page = request()->get('page', 1); 
    $perPage = $subcriterias->perPage();
    $startIndex = ($page - 1) * $perPage; 
@endphp
@forelse($subcriterias as $index => $subcriteria)
    <tr class="border-b border-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 transition-colors duration-200">
        <td class="text-center py-2">{{ $startIndex + $index + 1 }} .</td>
        <td class="text-center">{{ $subcriteria->name }}</td>
        <td class="py-2">{{ $subcriteria->detail }}</td>
        <td class="text-center py-2">{{ $subcriteria->criteria->name }}</td>
        <td class="text-center py-2">
            <form action="{{ route('subcriterias.destroy', $subcriteria->id) }}" class="inline-block relative group" method="POST" onsubmit="return confirm('Are you sure you want to delete this sub kriteria?');">
                @csrf
                @method('DELETE')
                <button type="submit" class=" items-center justify-center w-8 h-8 rounded-full bg-red-500 hover:bg-red-700 text-white">
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
        <td colspan="7" class="text-center py-4">Tidak ada sub kriteria ditemukan.</td>
    </tr>
@endforelse
<tr>
    <td colspan="7" class="text-center py-4" id="pagination-links">
        <!-- Render pagination links dengan mempertahankan query parameters -->
        {{ $subcriterias->appends(request()->query())->links() }}
    </td>
</tr>