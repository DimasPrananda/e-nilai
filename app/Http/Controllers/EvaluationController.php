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

        if (!$selectedPeriod) {
            abort(404, 'Period not found');
        }

        session(['last_department_id' => $departmentId]);

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

        if ($search) {
            $assessedEmployees->where('name', 'like', '%' . $search . '%');
            $unassessedEmployees->where('name', 'like', '%' . $search . '%');
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

        $assessedEmployees = $assessedEmployees->sortByDesc('totalScore');

        $assessedEmployees = $assessedEmployees->values(); 
        foreach ($assessedEmployees as $index => $employee) {
            $employee->index = $index + 1;
        }

        return view('admin.penilaian.table', compact('assessedEmployees', 'unassessedEmployees', 'selectedPeriod', 'departments', 'departmentId'));
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

        return view('admin.penilaian.detail', compact('employee', 'period', 'criterias', 'scores'));    
    }
}
