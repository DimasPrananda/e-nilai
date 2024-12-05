<x-app-layout>
    <div class="p-4 md:p-12 flex-1">
        <div class="md:p-0 mb-4">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">Formulir Data Karyawan</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">Dashboard </a>
            <a href="{{ route('admin.karyawan.employees') }}" class="text-gray-800 dark:text-gray-400 hover:dark:text-gray-200 hover:text-black">/ Kelola Data Karyawan</a>
            <a class="text-gray-800 dark:text-gray-200 font-bold">/ Formulir Data Karyawan</a>
        </div>

        <div class="flex flex-col bg-white p-5 dark:bg-gray-800 sm:rounded-lg">
            <h2 class=" text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Input Data Baru</h2>
            <form action="{{ route('admin.karyawan.store') }}" method="POST" x-data="{ userType: '{{ auth()->user()->usertype ?? '' }}' }">
                @csrf
    
                <!-- Nama Karyawan -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Karyawan:</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>
    
                <!-- Email Karyawan -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Karyawan:</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>
    
                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password:</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>
    
                <div class="mb-4">
                    <label for="usertype" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipe Pengguna:</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="usertype" value="user" x-model="userType" class="form-radio text-indigo-600 dark:bg-gray-800 dark:text-gray-200" required>
                            <span class="ml-2 text-gray-700 dark:text-gray-300">User</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="usertype" value="penilai" x-model="userType" class="form-radio text-indigo-600 dark:bg-gray-800 dark:text-gray-200">
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Penilai</span>
                        </label>
                        <label class="inline-flex items-center ml-6">
                            <input type="radio" name="usertype" value="admin" x-model="userType" class="form-radio text-indigo-600 dark:bg-gray-800 dark:text-gray-200">
                            <span class="ml-2 text-gray-700 dark:text-gray-300">Admin</span>
                        </label>
                    </div>
                </div>
    
                <!-- Nomor Pegawai -->
                <div class="mb-4">
                    <label for="employee_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Pegawai:</label>
                    <input type="text" name="employee_number" id="employee_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>
    
                <!-- Dropdown Departemen -->
                <div class="mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departemen:</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        <option value="">Pilih Departemen</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Dropdown Posisi -->
                <div class="mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Posisi:</label>
                    <select name="position_id" id="position_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        <option value="">Pilih Posisi</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}">{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Dropdown Golongan -->
                <div class="mb-4">
                    <label for="golongan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Golongan:</label>
                    <select name="golongan_id" id="golongan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        <option value="">Pilih Golongan</option>
                        @foreach($golongans as $golongan)
                            <option value="{{ $golongan->id }}">{{ $golongan->name }} - {{ $golongan->position->name }}</option>
                        @endforeach
                    </select>
                </div>
    
                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-end gap-4">
                    <button type="reset" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Reset
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

