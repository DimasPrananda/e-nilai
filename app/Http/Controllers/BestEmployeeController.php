<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\RankingEvaluation;
use App\Models\RankingTotalScore;
use App\Models\RankingSubcriteria;

class BestEmployeeController extends Controller
{

    public function showDetailEvaluation($employeeId, $periodId)
    {
        // Ambil data karyawan dan periode berdasarkan ID
        $employee = Employee::findOrFail($employeeId);
        $period = Period::findOrFail($periodId);

        // Mengambil semua subkriteria beserta kriteria yang terkait
        $subcriterias = RankingSubcriteria::with('ranking_criteria')->get()->groupBy('ranking_criteria.name');

        // Ambil nilai untuk setiap subkriteria yang sudah dinilai
        $scores = RankingEvaluation::where('employee_id', $employeeId)
            ->where('period_id', $periodId)
            ->pluck('score', 'subcriteria_id');

        // Siapkan variabel totalScore untuk menghitung total skor keseluruhan
        $totalScore = 0;

        // Menyiapkan data kriteria yang akan di-pass ke view
        $criterias = [];
        $criteriaDetails = []; // Array untuk rincian evaluasi kriteria

        foreach ($subcriterias as $criteriaName => $subcriteriaGroup) {
            $criteria = [
                'name' => $criteriaName,
                'subcriterias' => [],
                'totalSubcriteriaScore' => 0, // Inisialisasi total subkriteria per kriteria
            ];

            foreach ($subcriteriaGroup as $subcriteria) {
                $score = $scores[$subcriteria->id] ?? 0;
                $criteria['subcriterias'][] = [
                    'detail' => $subcriteria->detail,
                    'score' => $score,
                ];

                // Tambahkan nilai ke total subkriteria per kriteria
                $criteria['totalSubcriteriaScore'] += $score;
            }

            // Tambahkan totalSubcriteriaScore ke totalScore untuk semua kriteria
            $totalScore += $criteria['totalSubcriteriaScore'];

            // Tambahkan kriteria ke array criterias
            $criterias[] = $criteria;

            // Hitung evaluations factor dan weight evaluation
            $totalSubcriteriaScore = $criteria['totalSubcriteriaScore'];
            $totalSubcriteriaMax = $subcriteriaGroup->sum(function ($subcriteria) {
                return $subcriteria->ranking_criteria->nilai_max; // Ambil nilai max dari ranking_criterias
            });

            $factorWeight = $subcriteriaGroup->first()->ranking_criteria->evaluations; // Ambil nilai evaluations dari kriteria pertama

            // Hitung evaluations factor dan weight evaluation
            $evaluationsFactor = $totalSubcriteriaMax > 0 ? $totalSubcriteriaScore / $totalSubcriteriaMax : 0;
            $weightEvaluation = $evaluationsFactor * $factorWeight;

            $criteriaDetails[] = [
                'name' => $criteriaName,
                'evaluations_factor' => $evaluationsFactor,
                'factor_weight' => $factorWeight,
                'weight_evaluation' => $weightEvaluation,
            ];
        }

        $totalWeightEvaluation = collect($criteriaDetails)->sum('weight_evaluation');
        // Return view dengan data yang dibutuhkan
        return view('admin.ranking.detail', compact('employee', 'period', 'criterias', 'scores', 'totalScore', 'criteriaDetails', 'totalWeightEvaluation'));
    }


    public function deleteScore($employeeId, $periodId)
    {
        // Find and delete all scores for the employee in the given period
        $deleted = RankingEvaluation::where('employee_id', $employeeId)
                    ->where('period_id', $periodId)
                    ->delete();

        if ($deleted) {
            // Also delete total score record if necessary
            RankingTotalScore::where('employee_id', $employeeId)
                    ->where('period_id', $periodId)
                    ->delete();

            return redirect()->route('rankings.showEmployee', ['period_id' => $periodId])
                            ->with('success', 'Nilai berhasil dihapus.');
        } else {
            return redirect()->route('rankings.showEmployee', ['period_id' => $periodId])
                            ->with('error', 'Gagal menghapus nilai.');
        }
    }

    public function select()
    {
        $periods = Period::all(); // Mendapatkan semua periode
        return view('admin.ranking.select-periods', compact('periods'));
    }

    public function showEmployee(Request $request)
{
    $periodId = $request->input('period_id');
    $selectedPeriod = Period::find($periodId);
    $departmentId = $request->input('department_id');

    // Mengambil daftar karyawan yang sudah dinilai di periode yang dipilih
    $assessedEmployeeIds = RankingEvaluation::where('period_id', $periodId)
        ->pluck('employee_id');

    // Mengambil daftar karyawan yang belum dinilai di periode yang dipilih
    $unassessedEmployees = Department::with(['employees' => function ($query) use ($periodId, $assessedEmployeeIds) {
        $query->join('total_scores', 'employees.id', '=', 'total_scores.employee_id')
            ->where('total_scores.period_id', $periodId)
            ->whereNotIn('employees.id', $assessedEmployeeIds)
            ->orderByDesc('total_scores.total_score')
            ->take(1);
    }])->get();

    // Mengambil data karyawan yang sudah dinilai
    $assessedEmployees = Employee::whereIn('id', $assessedEmployeeIds)->get();

    // Menyortir karyawan yang sudah dinilai berdasarkan skor total
    $assessedEmployees = $assessedEmployees->sortByDesc(function ($employee) use ($periodId) {
        return RankingTotalScore::where('employee_id', $employee->id)
            ->where('period_id', $periodId)
            ->value('score');
    });

    $assessedEmployees = $assessedEmployees->values(); // Reset keys setelah sort
    foreach ($assessedEmployees as $index => $employee) {
        $employee->index = $index + 1; // Set nomor urut mulai dari 1
        $employee->total_score = RankingTotalScore::where('employee_id', $employee->id)
            ->where('period_id', $periodId)
            ->value('score');
    }

    return view('admin.ranking.table', compact('assessedEmployees', 'unassessedEmployees', 'selectedPeriod', 'departmentId'));
}


    public function showSubcriteriaEvaluation($employeeId, $periodId)
    {
        $employee = Employee::find($employeeId);
        $period = Period::find($periodId);
        $subcriterias = RankingSubCriteria::with('ranking_criteria')->get()->groupBy('ranking_criteria.name');

        return view('admin.ranking.evaluations', compact('employee', 'period', 'subcriterias'));
    }

    public function storeSubcriteriaEvaluation(Request $request, $employeeId, $periodId)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'required|numeric|min:0|max:100'
        ]);
    
        // Ambil semua subkriteria dan kriteria terkait
        $subcriteriaIds = array_keys($request->scores);
        $subcriterias = RankingSubcriteria::with('ranking_criteria')->whereIn('id', $subcriteriaIds)->get();
        
        // Initialize total score
        $totalScore = 0;
        $criteriaScores = [];
    
        // Process each subcriteria
        foreach ($subcriterias as $subcriteria) {
            $criteria = $subcriteria->ranking_criteria; // Ambil kriteria terkait
            $subScore = $request->scores[$subcriteria->id];
    
            // Save subcriteria evaluation
            RankingEvaluation::updateOrCreate(
                [
                    'employee_id' => $employeeId,
                    'period_id' => $periodId,
                    'subcriteria_id' => $subcriteria->id
                ],
                ['score' => $subScore]
            );
    
            // Hitung score per kriteria
            if (!isset($criteriaScores[$criteria->id])) {
                $criteriaScores[$criteria->id] = [
                    'total_subcriteria_score' => 0,
                    'total_subcriteria_max' => 0,
                    'evaluations' => $criteria->evaluations
                ];
            }
    
            $criteriaScores[$criteria->id]['total_subcriteria_score'] += $subScore;
            $criteriaScores[$criteria->id]['total_subcriteria_max'] += $criteria->nilai_max;
        }
    
        // Sekarang hitung score akhir berdasarkan criteriaScores
        foreach ($criteriaScores as $criteriaId => $data) {
            $ratio = $data['total_subcriteria_max'] > 0
                ? ($data['total_subcriteria_score'] / $data['total_subcriteria_max'])
                : 0;
    
            $totalScore += $ratio * $data['evaluations'];
        }
    
        // Save or update the total score in ranking_total_scores
        RankingTotalScore::updateOrCreate(
            [
                'employee_id' => $employeeId,
                'period_id' => $periodId
            ],
            ['score' => $totalScore]
        );
    
        return redirect()->route('rankings.showEmployee', ['period_id' => $periodId])
            ->with('success', 'Penilaian berhasil disimpan dan total skor diperbarui.');
    }
}