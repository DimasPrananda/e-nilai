<div x-data="{ openDropdown: null, selectedItem: null }" class="w-64 bg-white dark:bg-gray-800 shadow-md min-h-screen">
    <div class="p-4">
        <ul class="mt-4">
            <!-- Dashboard Link -->
            <li class="mt-2">
                <a href="#" class="flex py-2 items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 13h2v-2H3v2zm0 4h2v-2H3v2zm0 4h2v-2H3v2zm4 0h2v-2H7v2zm4 0h2v-2h-2v2zm4 0h2v-2h-2v2zm4 0h2v-2h-2v2zM3 5h18v10H3V5zm2 8h2v-2H5v2zm0-4h2V7H5v2zm4 4h10V7H9v6z"/>
                    </svg>
                    Dashboard
                </a>
            </li>
            
            <!-- Perusahaan Dropdown -->
            <li class="mt-2 relative">
                <button @click="openDropdown === 1 ? openDropdown = null : openDropdown = 1" class="w-full flex items-center justify-between text-left text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none">
                    <div class="flex py-2 items-center">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7v14h6v-7h8v7h6V7L12 2zm0 2.2l7 3.8v10h-2v-4H7v4H5v-10l7-3.8zM11 10v2h2v-2h-2zm0 4v2h2v-2h-2zm4-4v2h2v-2h-2zm0 4v2h2v-2h-2z"/>
                        </svg>
                        <span>Perusahaan</span>
                    </div>
                    <svg :class="{ 'transform rotate-180': openDropdown === 1 }" class="w-4 h-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.293l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <ul x-show="openDropdown === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-2 border-t border-b pl-4 border-gray-200 dark:border-gray-700">
                    <li @click="selectedItem = 'departemen'" class="relative">
                        <a href="#" class="py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center">
                            <div class="absolute -left-2.5 h-full border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                            <svg x-show="selectedItem === 'departemen'" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="ml-2">Departemen</span>
                        </a>
                    </li>
                    <li @click="selectedItem = 'jabatan'" class="relative">
                        <a href="#" class="py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center">
                            <div class="absolute -left-2.5 h-full border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                            <svg x-show="selectedItem === 'jabatan'" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="ml-2">Jabatan</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Karyawan Dropdown -->
            <li class="mt-2 relative">
                <button @click="openDropdown === 2 ? openDropdown = null : openDropdown = 2" class="w-full flex items-center justify-between text-left text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none">
                    <div class="flex py-2 items-center">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                        <span>Karyawan</span>
                    </div>
                    <svg :class="{ 'transform rotate-180': openDropdown === 2 }" class="w-4 h-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.293l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <ul x-show="openDropdown === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" class="mt-2 pl-4 border-t border-b border-gray-200 dark:border-gray-700">
                    <li @click="selectedItem = 'data-karyawan'" class="relative">
                        <a href="{{ route('admin.karyawan.index') }}" class="py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center">
                            <div class="absolute -left-2.5 h-full border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                            <svg x-show="selectedItem === 'data-karyawan'" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="ml-2">Data Karyawan</span>
                        </a>
                    </li>
                    <li @click="selectedItem = 'tambah-karyawan'" class="relative">
                        <a href="{{ route('admin.karyawan.create') }}" class="py-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 flex items-center">
                            <div class="absolute -left-2.5 h-full border-l-2 border-dashed border-gray-300 dark:border-gray-600"></div>
                            <svg x-show="selectedItem === 'tambah-karyawan'" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 5l7 7-7 7"/>
                            </svg>
                            <span class="ml-2">Tambah Karyawan</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
