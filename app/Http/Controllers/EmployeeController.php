<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Golongan;
use App\Models\Position;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = Department::all();
        $query = Employee::query();

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        $employees = $query->get();
        return view('admin.karyawan.employees', compact('departments', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        $golongans = Golongan::all();

        return view('admin.karyawan.form-employees', compact('departments', 'positions', 'golongans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'employee_number' => 'required|string|max:255|unique:employees',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'golongan_id' => 'required|exists:golongans,id',
            'usertype' => 'required|in:user,penilai,admin',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'usertype' => $request->input('usertype'),
        ]);

        Employee::create([
            'name' => $request->input('name'),
            'employee_number' => $request->input('employee_number'),
            'department_id' => $request->input('department_id'),
            'position_id' => $request->input('position_id'),
            'golongan_id' => $request->input('golongan_id'),
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.karyawan.employees')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('admin.karyawan.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        $golongans = Golongan::all();

        return view('admin.karyawan.edit-form', compact('employee', 'departments', 'positions', 'golongans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $employee->id,
            'password' => 'nullable|string|min:8',
            'employee_number' => 'required|string|max:255|unique:employees,employee_number,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'golongan_id' => 'required|exists:golongans,id',
            'usertype' => 'required|string|in:user,penilai,admin',
        ]);

        $user = User::find($employee->user_id); // Misalkan Anda punya relasi ke User
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $user->password,
            'usertype' => $request->input('usertype') ?? $user->usertype,
        ]);

        $employee->update([
            'name' => $request->input('name'),
            'employee_number' => $request->input('employee_number'),
            'department_id' => $request->input('department_id'),
            'position_id' => $request->input('position_id'),
            'golongan_id' => $request->input('golongan_id'),
        ]);

        return redirect()->route('admin.karyawan.employees')->with('success', 'Karyawan berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan karyawan berdasarkan ID
        $employee = Employee::findOrFail($id);
    
        // Temukan pengguna berdasarkan employee_number
        $user = User::where('name', $employee->name)->first(); // Ganti ini jika Anda menggunakan metode lain untuk mengaitkan employee dengan user
    
        // Hapus pengguna jika ada
        if ($user) {
            $user->delete();
        }
    
        // Hapus karyawan
        $employee->delete();
    
        return redirect()->route('admin.karyawan.employees')->with('success', 'Karyawan berhasil dihapus.');
    }
}
