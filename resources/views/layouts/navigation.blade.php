@if(Auth::user()->usertype === 'admin')
<nav x-data="{ 
    open: false,
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
}" class="sticky top-0 z-10 w-full bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                {{-- <div class="hidden space-x-8 md:-my-px md:ms-10 md:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div> --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden md:flex md:items-center md:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 focus:outline-none focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden">
        <div class="py-3 ">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link class="px-4 py-2 hover:bg-gray-700" @click="openSubmenu = !openSubmenu">
                <div class="flex justify-between items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 7v14h6v-7h8v7h6V7L12 2zm0 2.2l7 3.8v10h-2v-4H7v4H5v-10l7-3.8zM11 10v2h2v-2h-2zm0 4v2h2v-2h-2zm4-4v2h2v-2h-2zm0 4v2h2v-2h-2z"/>
                    </svg>
                    <span class="flex-1">Perusahaan</span>
                    <svg :class="{ 'rotate-180': openSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </x-responsive-nav-link>

            <ul x-show="openSubmenu" x-cloak class="pl-8 relative"><div class="absolute inset-y-0 w-1 border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
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

            <x-responsive-nav-link class="px-4 py-2 hover:bg-gray-700" @click="openEmployeeSubmenu = !openEmployeeSubmenu">
                <div class="flex items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.32 0-6 2.68-6 6v2h12v-2c0-3.32-2.68-6-6-6zm6-4c0 3.31-2.69 6-6 6s-6-2.69-6-6S8.69 4 12 4s6 2.69 6 6z"/>
                    </svg>
                    <span class="flex-1">Karyawan</span>
                    <svg :class="{ 'rotate-180': openEmployeeSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </x-responsive-nav-link>
        
            <!-- Submenu Karyawan -->
            <ul x-show="openEmployeeSubmenu" x-cloak class=" pl-8 relative">
                <div class="absolute inset-y-0 w-1 border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                <li>
                    <x-nav-link :href="route('admin.karyawan.employees')" :active="request()->routeIs('admin.karyawan.employees')">
                        Data Karyawan
                    </x-nav-link>    
                </li>
            </ul>

            <x-responsive-nav-link class="px-4 py-2 hover:bg-gray-700" @click="openEvaluationSubmenu = !openEvaluationSubmenu">
                <div class="flex items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 11l-2-2-1.5 1.5L9 14l7-7-1.5-1.5L9 11zm-7-9h18v18H2V2zm16 16V4H4v14h14z"/>
                    </svg>
                    <span class="flex-1">Penilaian</span>                                      
                    <svg :class="{ 'rotate-180': openEvaluationSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </x-responsive-nav-link>
        
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

            <x-responsive-nav-link class="px-4 py-2 hover:bg-gray-700" @click="openRankingSubmenu = !openRankingSubmenu">
                <div class="flex items-center cursor-pointer">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.32 0-6 2.68-6 6v2h12v-2c0-3.32-2.68-6-6-6zm6-4c0 3.31-2.69 6-6 6s-6-2.69-6-6S8.69 4 12 4s6 2.69 6 6z"/>
                    </svg>
                    <span class="flex-1">Karyawan Terbaik</span>
                    <svg :class="{ 'rotate-180': openRankingSubmenu, 'transition-transform': true }" class="w-4 h-4 fill-current text-gray-300 ml-2 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M5.293 7.293a1 1 0 011.414 0L10 9.586l3.293-2.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                </div>
            </x-responsive-nav-link>
            
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
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
@endif
