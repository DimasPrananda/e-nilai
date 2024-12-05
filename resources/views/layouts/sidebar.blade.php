<!-- Admin Sidebar -->
@if(Auth::user()->usertype === 'admin')
<div class="hidden md:block">
    <div x-data="{ 
        openSubmenu: {{ Route::is('admin.departments') || Route::is('admin.positions') || Route::is('admin.golongans') ? 'true' : 'false'}},
        openEmployeeSubmenu: {{ Route::is('admin.karyawan.employees') ? 'true' : 'false' }},
        openEvaluationSubmenu: {{
            Route::is('admin.penilaian.criterias') || 
            Route::is('admin.penilaian.subcriterias') || 
            Route::is('admin.penilaian.periods') ||
            Route::is('admin.penilaian.select-periods') 
        ? 'true' : 'false' }},
        openRankingSubmenu: {{ 
            Route::is('admin.ranking.criterias') || 
            Route::is('admin.ranking.subcriterias') ||
            Route::is('admin.ranking.select-periods')
        ? 'true' : 'false' }}
    }" class="h-full w-64 p-4 bg-white dark:bg-gray-800 text-white ">
        <nav>
            <ul>
                <!-- Dashboard Menu Item -->
                <li>
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <div class="flex justify-between items-center text-gray-800 dark:text-white">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            Dashboard
                        </div>
                    </x-nav-link>
                </li>
    
                <!-- Perusahaan Menu with Submenu -->
                <li class="px-4 py-2 hover:bg-gray-200 hover:dark:bg-gray-700" @click="openSubmenu = !openSubmenu">
                    <div class="flex justify-between text-gray-800 dark:text-white items-center cursor-pointer">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7v14h6v-7h8v7h6V7L12 2zm0 2.2l7 3.8v10h-2v-4H7v4H5v-10l7-3.8zM11 10v2h2v-2h-2zm0 4v2h2v-2h-2zm4-4v2h2v-2h-2zm0 4v2h2v-2h-2z"/>
                        </svg>
                        <span class="flex-1">Perusahaan</span>
                        <svg :class="{ 'rotate-180': openSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </li>
    
                <ul x-show="openSubmenu" x-cloak class="pl-8 relative"><div class="absolute inset-y-0 w-1 border-l-2 border-dashed text-gray-800 dark:text-white border-gray-300 dark:border-gray-600"></div>
                    <li>
                        <x-nav-link :href="route('admin.departments')" :active="request()->routeIs('admin.departments')">
                            Departemen
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.positions')" :active="request()->routeIs('admin.positions')">
                            Jabatan
                        </x-nav-link>
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.golongans')" :active="request()->routeIs('admin.golongans')">
                            Golongan
                        </x-nav-link>
                    </li>
                </ul>
            
                <!-- Karyawan Menu with Submenu -->
                <li class="px-4 py-2 hover:bg-gray-200 hover:dark:bg-gray-700" @click="openEmployeeSubmenu = !openEmployeeSubmenu">
                    <div class="flex items-center cursor-pointer text-gray-800 dark:text-white">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.32 0-6 2.68-6 6v2h12v-2c0-3.32-2.68-6-6-6zm6-4c0 3.31-2.69 6-6 6s-6-2.69-6-6S8.69 4 12 4s6 2.69 6 6z"/>
                        </svg>
                        <span class="flex-1">Karyawan</span>
                        <svg :class="{ 'rotate-180': openEmployeeSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </li>
            
                <!-- Submenu Karyawan -->
                <ul x-show="openEmployeeSubmenu" x-cloak class=" pl-8 relative">
                    <div class="absolute inset-y-0 w-1 border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                    <li>
                        <x-nav-link :href="route('admin.karyawan.employees')" :active="request()->routeIs('admin.karyawan.employees')">
                            Data Karyawan
                        </x-nav-link>    
                    </li>
                </ul>
            
            <!-- Penilaian Menu with Submenu -->
                <li class="px-4 py-2 hover:bg-gray-200 hover:dark:bg-gray-700" @click="openEvaluationSubmenu = !openEvaluationSubmenu">
                    <div class="flex items-center text-gray-800 dark:text-white cursor-pointer">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 11l-2-2-1.5 1.5L9 14l7-7-1.5-1.5L9 11zm-7-9h18v18H2V2zm16 16V4H4v14h14z"/>
                        </svg>
                        <span class="flex-1">Penilaian</span>                                      
                        <svg :class="{ 'rotate-180': openEvaluationSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </li>
            
            <!-- Submenu Penilaian -->
                <ul x-show="openEvaluationSubmenu" x-cloak class=" pl-8 relative">
                    <div class="absolute inset-y-0 w-1 border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                    <li>
                        <x-nav-link :href="route('admin.penilaian.criterias')" :active="request()->routeIs('admin.penilaian.criterias')">
                            Kriteria
                        </x-nav-link>    
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.penilaian.subcriterias')" :active="request()->routeIs('admin.penilaian.subcriterias')">
                            Sub Kriteria
                        </x-nav-link>    
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.penilaian.periods')" :active="request()->routeIs('admin.penilaian.periods')">
                            Periode
                        </x-nav-link>    
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.penilaian.select-periods')" :active="request()->routeIs('admin.penilaian.select-periods')">
                            Penilaian
                        </x-nav-link>    
                    </li>
                </ul>
                
                <li class="px-4 py-2 hover:bg-gray-200 hover:dark:bg-gray-700" @click="openRankingSubmenu = !openRankingSubmenu">
                    <div class="flex items-center text-gray-800 dark:text-white cursor-pointer">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.32 0-6 2.68-6 6v2h12v-2c0-3.32-2.68-6-6-6zm6-4c0 3.31-2.69 6-6 6s-6-2.69-6-6S8.69 4 12 4s6 2.69 6 6z"/>
                        </svg>
                        <span class="flex-1">Karyawan Terbaik</span>
                        <svg :class="{ 'rotate-180': openRankingSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                    </div>
                </li>
                
                <!-- Submenu Karyawan -->
                <ul x-show="openRankingSubmenu" x-cloak class=" pl-8 relative">
                    <div class="absolute inset-y-0 w-1 border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                    <li>
                        <x-nav-link :href="route('admin.ranking.criterias')" :active="request()->routeIs('admin.ranking.criterias')">
                            Kriteria
                        </x-nav-link>    
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.ranking.subcriterias')" :active="request()->routeIs('admin.ranking.subcriterias')">
                            SubKriteria
                        </x-nav-link>    
                    </li>
                    <li>
                        <x-nav-link :href="route('admin.ranking.select-periods')" :active="request()->routeIs('admin.ranking.select-periods')">
                            Penilaian
                        </x-nav-link>    
                    </li>
                </ul>
            </ul>
        </nav>
    </div>
</div>
@endif

<!-- Penilai Sidebar -->
@if(Auth::user()->usertype === 'penilai')
<div class="hidden md:block">
    <div x-data="{ 
        openEmployeeSubmenu: {{ Route::is('admin.karyawan.employees') ? 'true' : 'false' }},
        openEvaluationSubmenu: {{ Route::is('admin.penilaian.select-periods') ? 'true' : 'false' }},
        openRankingSubmenu: {{ Route::is('admin.ranking.select-periods') ? 'true' : 'false' }}
    }" class="fixed h-screen w-64 p-4 bg-gray-800 text-white ">
        <nav>
            <ul>
                <!-- Dashboard Menu Item -->
                <li>
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <div class="flex justify-between items-center">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            Dashboard
                        </div>
                    </x-nav-link>
                </li>

                <li>
                    <x-nav-link :href="route('admin.karyawan.employees')" :active="request()->routeIs('admin.karyawan.employees')">
                        <div class="flex justify-between items-center">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>                            
                            Data Karyawan
                        </div>
                    </x-nav-link>
                </li>
                
                <li>
                    <x-nav-link :href="route('admin.penilaian.select-periods')" :active="request()->routeIs('admin.penilaian.select-periods')">
                        <div class="flex justify-between items-center">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19 3H5c-1.1 0-1.99.9-1.99 2L3 19c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 12H8v-2h4v2zm0-4H8V9h4v2zm4 4h-2v-2h2v2zm0-4h-2V9h2v2z"/>
                            </svg>                            
                            Penilaian
                        </div>
                    </x-nav-link>
                </li>
                
                <li>
                    <x-nav-link :href="route('admin.ranking.select-periods')" :active="request()->routeIs('admin.ranking.select-periods')">
                        <div class="flex justify-between items-center">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>                            
                            Karyawan Terbaik
                        </div>
                    </x-nav-link>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endif

@if(Auth::user()->usertype === 'user')
<div class="hidden md:block">
    <div x-data="{ 
        openEvaluationSubmenu: {{ Route::is('user.select-periods') ? 'true' : 'false' }},
    }" class="h-full w-64 p-4 bg-white dark:bg-gray-800 text-white ">
        <nav>
            <ul>
                <!-- Dashboard Menu Item -->
                <li>
                    <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <div class="flex justify-between items-center">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                            Dashboard
                        </div>
                    </x-nav-link>
                </li>

                <li>
                    <x-nav-link :href="route('user.select-periods')" :active="request()->routeIs('user.select-periods')">
                        <div class="flex justify-between items-center">
                            <svg class="w-4 h-4 ml-1 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>                            
                            Nilai
                        </div>
                    </x-nav-link>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endif
