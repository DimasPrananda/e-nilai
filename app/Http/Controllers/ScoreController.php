<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Period;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $periods = Period::all();
        $departments = Department::all();
        $employees = Employee::with('scores')->get();

        if ($request->filled('department_id')) {
            $employees = $employees->where('department_id', $request->input('department_id'));
        }

        return view('admin.penilaian.assessments', compact('employees', 'departments', 'periods'));
    }

    public function edit(Employee $employee)
    {
        $criterias = Criteria::with('subcriterias')->get();
        return view('admin.penilaian.scores', compact('employee', 'criterias'));
    }

    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'scores.*.value' => 'required|integer|min:0',
            'scores.*.sub_criteria_id' => 'required|exists:subcriterias,id',
        ]);

        Score::where('employee_id', $employee->id)->delete();

        foreach ($request->input('scores') as $scoreData) {
            Score::create([
                'employee_id' => $employee->id,
                'sub_criteria_id' => $scoreData['sub_criteria_id'],
                'value' => $scoreData['value'],
            ]);
        }

        return redirect()->route('admin.penilaian.assessments')->with('success', 'Scores updated successfully');
    }
}
