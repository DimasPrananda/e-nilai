<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-12 flex-1">
            <div class="container mx-auto p-4">
                <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Karyawan Terbaik di Periode {{ $period->period }}</h1>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <table class="min-w-full border divide-y divide-gray-200 dark:divide-gray-700 border-gray-700 dark:border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Departemen</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Nama Karyawan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Total Nilai</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-b border-gray-700 dark:border-gray-300">Aksi</th>
                            </tr>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
                            @forelse($bestEmployees as $department)
                                @if($department->employees->isNotEmpty())
                                    @foreach($department->employees as $employee)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $department->name }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ $employee->name }}</td>
                                            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-300 dark:border-gray-600 text-center text-sm font-medium text-gray-700 dark:text-gray-300">{{ number_format($employee->total_score) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">Tidak ada karyawan terbaik yang ditemukan untuk periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
