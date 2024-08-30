<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $periods = Period::all();
        return view('admin.penilaian.periods', compact('periods'));
    }

    public function SelectIndex()
    {
        $periods = Period::all();
        return view('admin.penilaian.select-periods', compact('periods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.penilaian.periods');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_year' => 'required|integer|min:1900|max:2099',
            'end_year' => 'required|integer|min:1900|max:2099',
        ]);
    
        // Pastikan end_year tidak kurang dari start_year
        if ($request->input('end_year') < $request->input('start_year')) {
            return redirect()->back()->withErrors(['end_year' => 'End year must be greater than or equal to start year.']);
        }
    
        // Gabungkan start_year dan end_year
        $period = $request->input('start_year') . '-' . $request->input('end_year');
    
        Period::create(['period' => $period]);
    
        return redirect()->route('admin.penilaian.periods')
                         ->with('success', 'Period successfully added.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Period $period)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Period $period)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Period $period)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Period $period)
    {
        $period->delete();

        return redirect()->route('admin.penilaian.periods')->with('success', 'Period deleted successfully.');
    }

    public function showEmployee(Request $request)
    {
        $periodId = $request->input('period_id');
        $departmentId = $request->input('department_id') ?? Department::first()->id;
        $selectedPeriod = Period::find($periodId);

        if (!$selectedPeriod) {
            abort(404, 'Period not found');
        }

        // Mengambil daftar karyawan yang sudah dinilai di periode yang dipilih
        $assessedEmployees = Employee::whereHas('totalScores', function($query) use ($periodId) {
            $query->where('period_id', $periodId);
        });

        // Mengambil daftar karyawan yang belum dinilai di periode yang dipilih
        $unassessedEmployees = Employee::whereDoesntHave('totalScores', function($query) use ($periodId) {
            $query->where('period_id', $periodId);
        });

        // Filter berdasarkan departemen jika dipilih
        if ($departmentId) {
            $assessedEmployees->where('department_id', $departmentId);
            $unassessedEmployees->where('department_id', $departmentId);
        }

        // Mengambil data karyawan yang sudah dinilai
        $assessedEmployees = $assessedEmployees->get();

        // Mengambil data karyawan yang belum dinilai
        $unassessedEmployees = $unassessedEmployees->get();

        // Mengambil daftar departemen untuk filter
        $departments = Department::all();

        // Menghitung total skor semua karyawan dalam departemen dan periode yang sama
        $totalDepartmentScores = [];

        foreach ($assessedEmployees as $employee) {
            $totalScore = Evaluation::where('employee_id', $employee->id)
                ->where('period_id', $periodId)
                ->sum('score');

            $employee->totalScore = $totalScore;

            // Menghitung total skor per departemen
            if (!isset($totalDepartmentScores[$employee->department_id])) {
                $totalDepartmentScores[$employee->department_id] = 0;
            }
            $totalDepartmentScores[$employee->department_id] += $totalScore;
        }   

        // Menghitung skor relatif setiap karyawan berdasarkan total skor departemen
        foreach ($assessedEmployees as $employee) {
            $departmentTotalScore = $totalDepartmentScores[$employee->department_id];
            $employee->relativeScore = $departmentTotalScore > 0 ? ($employee->totalScore / $departmentTotalScore) * 100 : 0;
        }
        return view('admin.penilaian.table', compact('assessedEmployees', 'unassessedEmployees', 'selectedPeriod', 'departments', 'departmentId'));
    }
}
