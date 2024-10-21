<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\RankingTotalScore;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function admin()
    {
        $user = Auth::user();
        $departments = Department::all();
        $latestPeriod = Period::latest()->first();

        $averageScores = [];

        // Menghitung rata-rata skor untuk setiap departemen berdasarkan periode terbaru
        foreach ($departments as $department) {
            $averageScore = Evaluation::join('employees', 'evaluations.employee_id', '=', 'employees.id')
                ->where('employees.department_id', $department->id)
                ->where('evaluations.period_id', $latestPeriod->id) // Tambahkan kondisi periode terbaru
                ->avg('evaluations.score');

            // Jika rata-rata tidak null, tambahkan ke array
            $averageScores[$department->name] = $averageScore ? round($averageScore, 2) : 0;
        }   

        // Ambil skor berdasarkan periode terbaru
        $scores = RankingTotalScore::with('employee.position', 'employee.department')
            ->where('period_id', $latestPeriod->id)
            ->get();

        $rankedScores = RankingTotalScore::with('employee.position', 'employee.department')
            ->where('period_id', $latestPeriod->id)
            ->orderBy('score', 'desc') // Urutkan berdasarkan skor tertinggi
            ->get();

        $employeesNotScored = Employee::whereDoesntHave('totalScores', function($query) use ($latestPeriod) {
            $query->where('period_id', $latestPeriod->id);
        })->count();

        $employeesScored = Employee::whereHas('totalScores', function ($query) use ($latestPeriod) {
            $query->where('period_id', $latestPeriod->id);
        })->count();

        $comments = Comment::with('user')->latest()->get();

        return view('admin.dashboard', compact('user', 'scores', 'averageScores', 'latestPeriod', 'rankedScores', 'employeesNotScored', 'employeesScored', 'comments'));
    }

    public function penilai()
    {
        return view('penilai.dashboard');
    }
}
