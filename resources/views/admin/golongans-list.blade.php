@php
    $page = request()->get('page', 1); 
    $perPage = $golongans->perPage();
    $startIndex = ($page - 1) * $perPage; 
@endphp
@forelse($golongans as $index => $golongan)
    <tr class="border-b border-gray-300 dark:border-gray-700 dark:hover:bg-gray-800 hover:bg-gray-100 transition-colors duration-200">
        <td class="text-center py-2">{{ $startIndex + $index + 1 }} .</td>
        <td class="text-center">{{ $golongan->name }}</td>
        <td class="text-center py-2">{{ $golongan->position->name }}</td>
        <td class="flex justify-center text-center py-2">
            <form action="{{ route('golongan.destroy', $golongan->id) }}" class="inline-block relative group" method="POST" onsubmit="return confirm('Are you sure you want to delete this golongan?');">
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
        <td colspan="7" class="text-center py-4">Tidak ada Golongan ditemukan.</td>
    </tr>
@endforelse
<tr>
    <td colspan="7" class="text-center py-4" id="pagination-links">
        <!-- Render pagination links dengan mempertahankan query parameters -->
        {{ $golongans->appends(request()->query())->links() }}
    </td>
</tr>