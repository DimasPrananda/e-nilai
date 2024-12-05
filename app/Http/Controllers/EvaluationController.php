<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\TotalScore;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function SelectIndex()
    {
        $periods = Period::all();
        return view('admin.penilaian.select-periods', compact('periods'));
    }

    public function showEmployee(Request $request)
    {
        $periodId = $request->input('period_id');
        $departmentId = $request->input('department_id') ?? session('last_department_id', Department::first()->id);
        $search = $request->input('search');
        $selectedPeriod = Period::find($periodId);
        $entriesPerPage = $request->input('entries_per_page', 10); // default to 10 per page

        if (!$selectedPeriod) {
            abort(404, 'Period not found');
        }

        session(['last_department_id' => $departmentId]);

        // Calculate total score of all employees in the department before pagination
        $allEmployeesInDept = Employee::whereHas('totalScores', function ($query) use ($periodId) {
            $query->where('period_id', $periodId);
        })
            ->when($departmentId, function ($query) use ($departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->get();

        $totalDepartmentScore = $allEmployeesInDept->reduce(function ($carry, $employee) use ($periodId) {
            $employeeTotalScore = Evaluation::where('employee_id', $employee->id)
                ->where('period_id', $periodId)
                ->sum('score');
            return $carry + $employeeTotalScore;
        }, 0);

        // Query for assessed employees, paginated
        $assessedEmployees = Employee::whereHas('totalScores', function ($query) use ($periodId) {
            $query->where('period_id', $periodId);
        })
            ->when($departmentId, function ($query) use ($departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->with('totalScores') // Eager load for better performance
            ->paginate($entriesPerPage);

        foreach ($assessedEmployees as $employee) {
            $employee->totalScore = Evaluation::where('employee_id', $employee->id)
                ->where('period_id', $periodId)
                ->sum('score');
            $employee->relativeScore = $totalDepartmentScore > 0 ? ($employee->totalScore / $totalDepartmentScore) * 100 : 0;
        }

        // Pagination for unassessed employees
        $unassessedEmployees = Employee::whereDoesntHave('totalScores', function ($query) use ($periodId) {
            $query->where('period_id', $periodId);
        })
            ->when($departmentId, function ($query) use ($departmentId) {
                return $query->where('department_id', $departmentId);
            })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate($entriesPerPage);

        $departments = Department::all();

        // AJAX response for pagination
        if ($request->ajax()) {
            $html = view('admin.penilaian.employees-list', compact(
                'assessedEmployees',
                'unassessedEmployees',
                'departments',
                'selectedPeriod',
                'departmentId'
            ))->render();

            $paginationLinks = $assessedEmployees->links()->render();

            return response()->json([
                'html' => $html,
                'pagination' => $paginationLinks,
            ]);
        }

        return view('admin.penilaian.table', compact(
            'assessedEmployees',
            'unassessedEmployees',
            'selectedPeriod',
            'departments',
            'departmentId'
        ))->with([
            'currentPage' => $assessedEmployees->currentPage(),
            'perPage' => $assessedEmployees->perPage(),
        ]);;
    }


    public function showLatestPeriod()
    {
        // Ambil periode terbaru
        $latestPeriod = Period::latest()->first();

        // Redirect ke halaman penilaian untuk periode terbaru
        return redirect()->route('periods.showEmployee', ['period_id' => $latestPeriod->id]);
    }

    public function deleteScore($employeeId, $periodId)
    {
        // Find and delete all scores for the employee in the given period
        $deleted = Evaluation::where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->delete();

        if ($deleted) {
            // Also delete total score record if necessary
            TotalScore::where('employee_id', $employeeId)
                ->where('period_id', $periodId)
                ->delete();

            return redirect()->route('periods.showEmployee', ['period_id' => $periodId])
                ->with('success', 'Nilai berhasil dihapus.');
        } else {
            return redirect()->route('periods.showEmployee', ['period_id' => $periodId])
                ->with('error', 'Gagal menghapus nilai.');
        }
    }

    public function showSubcriteriaEvaluation($employeeId, $periodId)
    {
        $employee = Employee::findOrFail($employeeId);
        $period = Period::findOrFail($periodId);

        $subcriterias = SubCriteria::with(['criteria'])
            ->get()
            ->groupBy('criteria.name'); // Kelompokkan berdasarkan nama kriteria

        return view('admin.penilaian.evaluate', compact('employee', 'period', 'subcriterias'));
    }

    public function storeSubcriteriaEvaluation(Request $request, $employeeId, $periodId)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0|max:100'
        ]);

        $totalScore = 0;

        foreach ($request->scores as $subcriteriaId => $score) {
            $subcriteria = SubCriteria::findOrFail($subcriteriaId);
            $evaluation = Evaluation::updateOrCreate(
                [
                    'employee_id' => $employeeId,
                    'period_id' => $periodId,
                    'subcriteria_id' => $subcriteriaId
                ],
                [
                    'score' => $score,
                    'subcriteria_snapshot' => json_encode($subcriteria)
                ]

            );

            $totalScore += $score;
        }

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

    public function editScore($employeeId, $periodId)
    {
        $employee = Employee::find($employeeId);
        $period = Period::find($periodId);

        if (!$employee || !$period) {
            return redirect()->route('periods.showEmployee', ['period_id' => $periodId])
                ->with('error', 'Karyawan atau periode tidak ditemukan.');
        }

        $subcriterias = SubCriteria::all(); // Mendapatkan semua subkriteria
        $scores = Evaluation::where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->pluck('score', 'subcriteria_id'); // Mendapatkan skor saat ini

        return view('admin.penilaian.edit', compact('employee', 'period', 'subcriterias', 'scores'));
    }

    public function updateScore(Request $request, $employeeId, $periodId)
    {
        $validated = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0',
        ]);

        foreach ($validated['scores'] as $subcriteriaId => $score) {
            Evaluation::updateOrCreate(
                ['employee_id' => $employeeId, 'period_id' => $periodId, 'subcriteria_id' => $subcriteriaId],
                ['score' => $score]
            );
        }

        // Update total score
        $totalScore = Evaluation::where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->sum('score');

        TotalScore::updateOrCreate(
            ['employee_id' => $employeeId, 'period_id' => $periodId],
            ['total_score' => $totalScore]
        );

        return redirect()->route('periods.showEmployee', ['period_id' => $periodId])
            ->with('success', 'Nilai berhasil diperbarui.');
    }

    public function showDetail($employeeId, $periodId)
    {
        $employee = Employee::find($employeeId);
        $period = Period::find($periodId);
        $selectedPeriod = Period::find($periodId);

        if (!$employee || !$period) {
            return redirect()->route('periods.showEmployee', ['period_id' => $periodId])
                ->with('error', 'Karyawan atau periode tidak ditemukan.');
        }

        // Mendapatkan semua kriteria dan subkriteria
        $criterias = Criteria::with('subcriterias')->get();

        // Mendapatkan nilai evaluasi
        $scores = Evaluation::where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->pluck('score', 'subcriteria_id')
            ->toArray();

        return view('admin.penilaian.detail', compact('employee', 'selectedPeriod', 'period', 'criterias', 'scores'));
    }
}
