<x-app-layout>
    <div class="flex-1 flex">
        <div class="p-0 md:p-10 flex-1">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4 text-center">
                <h2 class="text-lg sm:text-xl md:text-2xl font-medium text-gray-900 dark:text-gray-100">
                    {{ $latestPeriod->period }}
                </h2>
            </div>
            
            <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg mb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">
                    Daftar Karyawan
                </h2>
                <div class="flex overflow-x-auto">
                    <table class="flex-1">
                        <thead class="border-b-2 text-gray-800 dark:text-gray-200">
                            <tr>
                                <th class="py-3">No</th>
                                <th class="px-2 py-3">Nama</th>
                                <th class="px-2 py-3">Jabatan</th>
                                <th class="px-2 py-3">Departemen</th>
                                <th class="px-2 py-3 text-center ">Total Skor</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 dark:text-gray-200 dark:bg-gray-800 bg-white">
                            @php $rank = 1; @endphp
                            @foreach ($rankedScores as $score)
                                <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-200 cursor-pointer"
                                    onclick="window.location='{{ route('ranking.detail', ['employee' => $score->employee->id, 'period' => $latestPeriod->id]) }}'">
                                    <td class=" py-2 text-center">{{ $rank++ }} .</td>
                                    <td class=" py-2 text-left">{{ $score->employee->name }}</td>
                                    <td class=" py-2 text-center">{{ $score->employee->position->name }}</td>
                                    <td class=" py-2 text-center">{{ $score->employee->department->name }}</td>
                                    <td class=" py-2 text-center">
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
            
            <div class="flex flex-col sm:flex-row mb-4 md:mb-4 md:gap-5">
                <div class="flex-1 bg-white p-5 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Karyawan belum dinilai</h2>
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-20 h-20 mr-10 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                            </svg>
                            <h2 class="text-gray-800 dark:text-white text-2xl">{{ $employeesNotScored }}</h2>
                        </div>
                        <td class="text-center">
                            @if ($employeesNotScored > 0)
                                <a href="{{ route('admin.penilaian.latest') }}" class="flex items-center justify-center rounded-lg py-3 px-6 bg-blue-500 text-white font-bold hover:bg-blue-600">
                                    <svg class="w-6 h-6 mr-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> 
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                    Lakukan Penilaian
                                </a>
                            @else
                                <a class="flex items-center justify-center py-3 px-6 bg-gray-600 text-white font-bold rounded-lg">
                                    <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"> 
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                    </svg>
                                </a>
                            @endif
                        </td>                                                                     
                    </div>
                </div>

                <div class="flex-1 bg-white p-5 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:mb-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Karyawan dinilai</h2>
                    <div class="flex flex-col md:flex-row justify-start">
                        <div class="flex items-center">
                            <svg class="w-20 h-20 mr-10 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd"/>
                            </svg>
                            <h2 class="text-gray-800 dark:text-white text-2xl">{{ $employeesScored }}</h2>
                        </div>                                                              
                    </div>
                </div>
            </div>
            {{-- <div class="flex-1 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4 sm:mb-0">
                <div class="flex flex-col h-full p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-lg text-center font-medium text-gray-900 dark:text-gray-100 mb-8">Penilaian Karyawan</h2>
                    <div class="flex-grow">
                        <table class="min-w-full">
                            <thead class="w-full border rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-600 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Belum di nilai</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 dark:text-gray-400 text-sm font-light">
                                <tr class="border border-gray-700 dark:border-gray-300">
                                    <td class="py-3 px-6 text-center">{{ $employeesNotScored }}</td>
                                </tr>
                            </tbody>
                            <tfoot class="w-full border border-gray-700 dark:border-gray-300">
                                <tr>
                                    <td class="flex text-center">
                                        @if ($employeesNotScored > 0)
                                        <a href="{{ route('admin.penilaian.latest') }}" class="w-full py-3 px-6 bg-blue-500 text-white font-bold hover:bg-blue-600">
                                            Lakukan Penilaian
                                        </a>
                                        @else
                                            <span class="w-full py-3 px-6 text-gray-600 dark:text-gray-300">Semua karyawan sudah dinilai</span>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <table class="min-w-full mt-4">
                        <thead class="w-full border rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-600 uppercase text-sm leading-normal">
                            <tr>
                                <th class="py-3 w-12 text-center text-xs font-medium text-gray-800 dark:text-gray-300 uppercase tracking-wider border-gray-300 dark:border-gray-700">Sudah di nilai</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 dark:text-gray-400 text-sm font-light">
                            <tr class="border border-gray-700 dark:border-gray-300">
                                <td class="py-3 px-6 text-center">{{ $employeesScored }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>    --}}

            <div class="flex-1 p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Rata-rata Skor Karyawan per Departemen</h2>
                <div class="p-6">
                    <canvas id="departmentChart" class="w-full"></canvas>
                </div>          
            </div>   

            <div class="mb-4">
                <div class="flex-1 p-4 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 border-b overflow-hidden shadow-sm sm:rounded-lg sm:rounded-b-none sm:mb-0">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Komentar</h3>
                </div>
                <div class="flex-1 p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg sm:rounded-t-none sm:mb-0">
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-4 flex flex-col" onsubmit="return validateForm()">
                        @csrf
                        <h2 class="text-xl text-center font-bold text-gray-800 dark:text-gray-200 mb-4">Berapa rating penilaian ini?</h2>
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
                        <small id="rating-error" class="text-red-500 hidden mt-2">Pilih rating terlebih dahulu!</small>

                        <textarea name="text" id="comment" rows="3" class=" mt-4 w-full p-2 border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 rounded" placeholder="Tulis komentar..."></textarea>
                        <small id="comment-error" class="text-red-500 hidden mt-2">Komentar harus diisi!</small>
                        
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
                
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function validateForm() {
            const rating = document.querySelector('input[name="rating"]:checked');
            const comment = document.getElementById('comment').value.trim();
            let isValid = true;
    
            // Check if rating is selected
            const ratingError = document.getElementById('rating-error');
            if (!rating) {
                ratingError.classList.remove('hidden');
                isValid = false;
            } else {
                ratingError.classList.add('hidden');
            }
    
            // Check if comment is filled
            const commentError = document.getElementById('comment-error');
            if (comment === "") {
                commentError.classList.remove('hidden');
                isValid = false;
            } else {
                commentError.classList.add('hidden');
            }
    
            return isValid;
        }
    </script>
    <script>
        const ctx = document.getElementById('departmentChart').getContext('2d');
    
        // Prepare data labels and values
        const labels = @json(array_keys($averageScores)); // Nama departemen
        const dataValues = @json(array_values($averageScores)); // Nilai rata-rata
    
        // Define colors for the chart
        const colors = [
            'rgba(255, 99, 132, 0.5)',  // Red
            'rgba(54, 162, 235, 0.5)',  // Blue
            'rgba(255, 206, 86, 0.5)',  // Yellow
            'rgba(75, 192, 192, 0.5)',  // Green
            'rgba(153, 102, 255, 0.5)', // Purple
            'rgba(255, 159, 64, 0.5)',  // Orange
            'rgba(201, 203, 207, 0.5)', // Gray
        ];
    
        const borderColor = colors.map(color => color.replace('0.5', '1'));
    
        // Chart configuration
        const data = {
            labels: labels,
            datasets: [{
                label: 'Rata-rata Skor',
                data: dataValues,
                backgroundColor: colors,
                borderColor: borderColor,
                borderWidth: 1.5,
                barThickness: 25,       // Consistent bar thickness
                maxBarThickness: 40,    // Max thickness to avoid oversized bars
                minBarLength: 2         // Minimum bar length for visibility
            }]
        };
    
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false, // More flexible for various screen sizes
                indexAxis: 'y',             // Horizontal bars for better comparison
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            font: {
                                size: 14
                            },
                            color: 'gray'
                        }
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: 'rgba(0,0,0,0.7)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 10
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(200, 200, 200, 0.2)',
                            lineWidth: 0.8
                        },
                        ticks: {
                            color: 'gray',
                            stepSize: 10,
                            max: 100,
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: 'gray',
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        };
    
        // Create the chart
        const departmentChart = new Chart(ctx, config);
    </script>
    
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
