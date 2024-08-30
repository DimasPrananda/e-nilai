<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Employee;
use App\Models\Golongan;
use App\Models\Position;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\TotalScore;
use App\Models\SubCriteria;
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
            'email' => 'required|string|email|max:255|unique:employees',
            'password' => 'required|string|min:8',
            'employee_number' => 'required|string|max:255|unique:employees',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'golongan_id' => 'required|exists:golongans,id',
        ]);

        Employee::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'employee_number' => $request->input('employee_number'),
            'department_id' => $request->input('department_id'),
            'position_id' => $request->input('position_id'),
            'golongan_id' => $request->input('golongan_id'),
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
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'password' => 'nullable|string|min:8',
            'employee_number' => 'required|string|max:255|unique:employees,employee_number,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'golongan_id' => 'required|exists:golongans,id',
        ]);

        $employee->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->filled('password') ? Hash::make($request->input('password')) : $employee->password,
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
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('admin.karyawan.employees')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function showSubcriteriaEvaluation($employeeId, $periodId)
    {
        $employee = Employee::find($employeeId);
        $period = Period::find($periodId);
        $subcriterias = SubCriteria::with('criteria')->get()->groupBy('criteria.name');

        return view('admin.penilaian.evaluate', compact('employee', 'period', 'subcriterias'));
    }

    public function storeSubcriteriaEvaluation(Request $request, $employeeId, $periodId)
    {
        $request->validate([
            'scores' => 'required|array', // Memastikan 'scores' adalah array
            'scores.*' => 'required|numeric|min:0|max:100' // Validasi nilai setiap subkriteria
        ]);
    
        $totalScore = 0;
    
        foreach ($request->scores as $subcriteriaId => $score) {
            // Simpan setiap penilaian subkriteria
            $evaluation = Evaluation::updateOrCreate(
                [
                    'employee_id' => $employeeId,
                    'period_id' => $periodId,
                    'subcriteria_id' => $subcriteriaId
                ],
                ['score' => $score]
            );
    
            // Tambahkan skor ke total
            $totalScore += $score;
        }
    
        // Simpan atau update total skor ke tabel total_scores
        TotalScore::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'period_id' => $periodId
            ],
            ['total_score' => $totalScore]
        );
    
        return redirect()->route('periods.showEmployee', ['period_id' => $periodId])
            ->with('success', 'Penilaian berhasil disimpan dan total skor diperbarui.');
    }
}
