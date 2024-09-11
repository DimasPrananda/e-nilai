<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Department;
use Illuminate\Http\Request;

class BestEmployeeController extends Controller
{
    public function index()
    {
        $periods = Period::all(); // Mendapatkan semua periode
        return view('admin.ranking.select-periods', compact('periods'));
    }

    public function show(Request $request)
    {
        $periodId = $request->input('period_id');
        $period = Period::find($periodId);

        // Mengambil total score tertinggi di setiap departemen pada periode yang dipilih
        $bestEmployees = Department::with(['employees' => function ($query) use ($periodId) {
            $query->join('total_scores', 'employees.id', '=', 'total_scores.employee_id')
                ->where('total_scores.period_id', $periodId)
                ->orderByDesc('total_scores.total_score')
                ->take(1);
        }])->get();

        return view('admin.ranking.table', compact('bestEmployees', 'period'));
    }
}