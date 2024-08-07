<x-app-layout>
    <div class="p-12 flex-1">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-200">Edit Data Karyawan</h1>

            <form action="{{ route('admin.karyawan.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Karyawan -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Karyawan:</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>

                <!-- Email Karyawan -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Karyawan:</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $employee->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password:</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <!-- Nomor Pegawai -->
                <div class="mb-4">
                    <label for="employee_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Pegawai:</label>
                    <input type="text" name="employee_number" id="employee_number" value="{{ old('employee_number', $employee->employee_number) }}" pattern="\d{6}" maxlength="6" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                </div>

                <!-- Dropdown Departemen -->
                <div class="mb-4">
                    <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departemen:</label>
                    <select name="department_id" id="department_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        <option value="">Pilih Departemen</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ $employee->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Posisi -->
                <div class="mb-4">
                    <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Posisi:</label>
                    <select name="position_id" id="position_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        <option value="">Pilih Posisi</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ $employee->position_id == $position->id ? 'selected' : '' }}>{{ $position->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Golongan -->
                <div class="mb-4">
                    <label for="golongan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Golongan:</label>
                    <select name="golongan_id" id="golongan_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-gray-200" required>
                        <option value="">Pilih Golongan</option>
                        @foreach($golongans as $golongan)
                            <option value="{{ $golongan->id }}" {{ $employee->golongan_id == $golongan->id ? 'selected' : '' }}>{{ $golongan->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Kembali dan Simpan -->
                <div class="flex justify-between">
                    <a href="{{ route('admin.karyawan.employees') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>