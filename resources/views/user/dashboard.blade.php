<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-4 md:p-10 flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4 text-center">
                <h2 class="text-lg sm:text-xl md:text-2xl font-medium text-gray-900 dark:text-gray-100">
                    {{ $latestPeriod->period }}
                </h2>
            </div>

            <div class="flex flex-col md:flex-row md:gap-5">
                <div class="flex-1 bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                        Top 3 Karyawan Terbaik
                    </h2>
                    <div class="flex overflow-x-auto">
                        <table class="flex-1">
                            <thead class="border-b-2 text-gray-800 dark:text-gray-200">
                                <tr>
                                    <th class=" py-2 text-center">No</th>
                                    <th class=" py-2 text-center">Nama</th>
                                    <th class=" py-2 text-center">Departemen</th>
                                    <th class=" py-2 text-center">Total Skor</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                                @php $rank = 1; @endphp
                                @foreach ($rankedScores->take(3) as $score)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-200 cursor-pointer">
                                        <td class="py-2 "># {{ $rank++ }}</td>
                                        <td class="py-2 text-left">{{ $score->employee->name }}</td>
                                        <td class="py-2 text-center">{{ $score->employee->department->name }}</td>
                                        <td class="py-2 text-center">
                                            @php
                                                $finalScore = $score->score * 100;
                                            @endphp
                                            {{ $finalScore == round($finalScore) ? round($finalScore) : number_format($finalScore, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>    
                </div>

                <div class="flex-1 bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                        Top 3 {{ $employeeDepartment->name }}
                    </h2>
                    <div class="overflow-x-auto flex">
                        <table class="flex-1">
                            <thead class="border-b-2 text-gray-800 dark:text-gray-200">
                                <tr>
                                    <th class=" py-2 text-center ">No</th>
                                    <th class=" py-2 text-center ">Nama</th>
                                    <th class=" py-2 text-center ">Jabatan</th>
                                    <th class=" py-2 text-center ">Total Skor</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                                @php $rank = 1; @endphp
                                @foreach ($departmentScores->take(3) as $total_score)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-200 cursor-pointer">
                                        <td class=" py-2 text-center "># {{ $rank++ }}</td>
                                        <td class=" py-2 text-left ">{{ $total_score->employee->name }}</td>
                                        <td class=" py-2 text-center ">{{ $total_score->employee->position->name }}</td>
                                        <td class=" py-2 text-center ">
                                            @php
                                                $finalScore = $total_score->total_score;
                                            @endphp
                                            {{ $finalScore == round($finalScore) ? round($finalScore) : number_format($finalScore, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mb-4 p-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Perkembangan Skor Karyawan</h2>
                <canvas id="scoreChart"></canvas>
            </div>

            <div class="mb-4">
                <div class="flex-1 p-4 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 border-b overflow-hidden shadow-sm sm:rounded-lg sm:rounded-b-none sm:mb-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Komentar</h3>
                </div>
                <div class="flex-1 p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:rounded-t-none sm:mb-0">
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-4 flex flex-col">
                        @csrf
                        <h2 class=" text-center text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Berapa rating penilaian ini?</h2>
                        <div class="flex justify-center mt-2">
                            <div class="flex text-4xl" id="rating-stars">
                                <input type="radio" id="star1" name="rating" value="1" class="hidden" />
                                <label for="star1" class="star-label cursor-pointer text-gray-400 hover:text-yellow-500">&#9733;</label>
                        
                                <input type="radio" id="star2" name="rating" value="2" class="hidden" />
                                <label for="star2" class="star-label cursor-pointer text-gray-400 hover:text-yellow-500">&#9733;</label>
                        
                                <input type="radio" id="star3" name="rating" value="3" class="hidden" />
                                <label for="star3" class="star-label cursor-pointer text-gray-400 hover:text-yellow-500">&#9733;</label>
                        
                                <input type="radio" id="star4" name="rating" value="4" class="hidden" />
                                <label for="star4" class="star-label cursor-pointer text-gray-400 hover:text-yellow-500">&#9733;</label>
                        
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" />
                                <label for="star5" class="star-label cursor-pointer text-gray-400 hover:text-yellow-500">&#9733;</label>
                            </div>
                        </div>

                        <textarea name="text" rows="3" class=" mt-4 w-full p-2 border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded" placeholder="Tulis komentar..."></textarea>
                        
                        <div class="flex justify-end mt-4">
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold rounded-lg shadow-lg hover:from-blue-600 hover:to-indigo-600 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition duration-300 ease-in-out">
                                Kirim
                            </button>
                        </div>
                    </form>
                    <div class="flex items-end justify-between mt-14">
                        <div class="text-lg text-gray-600 dark:text-gray-300">
                            {{ $comments->count() }} Komentar
                        </div>
                        <form action="{{ route('comments.destroyAll') }}" method="POST" x-data="{ userType: '{{ auth()->user()->usertype ?? '' }}' }" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua komentar?');">
                            @csrf
                            @method('DELETE')
                            <button x-show="userType === 'admin'" type="submit" class="px-4 py-2 bg-red-500 text-white font-bold rounded-lg shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 transition duration-300 ease-in-out mb-2">
                                Hapus Semua Komentar
                            </button>
                        </form>
                    </div>          
                    <div class="w-full mb-10 border-b-2 border-gray-400 dark:border-gray-600"></div>
                    
                    @foreach ($comments as $comment)
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-2 pb-2">
                        <p class="flex flex-col text-gray-800 dark:text-gray-300">
                            <strong>{{ $comment->user->name }}</strong> 
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $comment->rating ? 'text-yellow-500' : 'text-gray-400' }}">
                                    &#9733;
                                </span>
                                @endfor
                            </div>
                        </p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $comment->text }}</p>
                    </div>
                    @endforeach
                </div>            
            </div>

        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('scoreChart').getContext('2d');
            const data = {
                labels: @json($scoreHistory->pluck('period.period')),
                datasets: [{
                    label: 'Total Skor',
                    data: @json($scoreHistory->pluck('total_score')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Skor'
                            },
                            ticks: {
                                padding: 15
                            }
                        }
                    }
                }
            };

            new Chart(ctx, config);
        });
    </script>
    @endpush
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const starLabels = document.querySelectorAll('.star-label');
            const ratingInputs = document.querySelectorAll('input[name="rating"]');

            // Menyimpan nilai rating yang dipilih
            let selectedRating = 0;

            starLabels.forEach((label, index) => {
                label.addEventListener('mouseover', () => {
                    // Set semua bintang hingga yang di-hover menjadi kuning
                    for (let i = 0; i <= index; i++) {
                        starLabels[i].classList.remove('text-gray-400');
                        starLabels[i].classList.add('text-yellow-500');
                    }
                });

                label.addEventListener('mouseout', () => {
                    // Reset warna bintang sesuai dengan rating yang dipilih
                    updateStars();
                });

                label.addEventListener('click', () => {
                    // Set bintang yang diklik dan semua bintang sebelumnya ke warna kuning
                    selectedRating = index + 1; // Simpan rating yang dipilih
                    updateStars(); // Perbarui tampilan bintang
                });
            });

            // Fungsi untuk memperbarui warna bintang
            function updateStars() {
                starLabels.forEach((star, i) => {
                    if (i < selectedRating) {
                        star.classList.remove('text-gray-400');
                        star.classList.add('text-yellow-500');
                    } else {
                        star.classList.remove('text-yellow-500');
                        star.classList.add('text-gray-400');
                    }
                });
            }
        });
    </script>
</x-app-layout>
