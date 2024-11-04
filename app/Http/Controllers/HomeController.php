<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Comment;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Evaluation;
use App\Models\TotalScore;
use Illuminate\Http\Request;
use App\Models\RankingTotalScore;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function admin()
    {
        $user = Auth::user();
        $departments = Department::all();
        $latestPeriod = Period::latest()->first();

        $averageScores = [];

        foreach ($departments as $department) {
            $averageScore = Evaluation::join('employees', 'evaluations.employee_id', '=', 'employees.id')
                ->where('employees.department_id', $department->id)
                ->where('evaluations.period_id', $latestPeriod->id)
                ->avg('evaluations.score');

            $averageScores[$department->name] = $averageScore ? round($averageScore, 2) : 0;
        }   

        $scores = RankingTotalScore::with('employee.position', 'employee.department')
            ->where('period_id', $latestPeriod->id)
            ->get();

        $rankedScores = RankingTotalScore::with('employee.position', 'employee.department')
            ->where('period_id', $latestPeriod->id)
            ->orderBy('score', 'desc')
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

    public function user()
    {
        // Mendapatkan periode terbaru
        $latestPeriod = Period::latest()->first();
        $userId = Auth::id();
    
        // Mendapatkan nama pengguna yang login
        $userName = Auth::user()->name;
    
        // Cari employee yang cocok dengan nama user yang login
        $employee = Employee::where('name', $userName)->first();
    
        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }
    
        // Ambil department_id dari employee yang sesuai
        $departmentId = $employee->department_id;
        $employeeDepartment = $employee->department;
    
        // Ambil peringkat skor keseluruhan
        $rankedScores = RankingTotalScore::with('employee.position', 'employee.department')
            ->where('period_id', $latestPeriod->id)
            ->orderBy('score', 'desc')
            ->get();
    
        // Ambil peringkat skor khusus departemen user yang login
        $departmentScores = TotalScore::where('period_id', $latestPeriod->id)
            ->whereHas('employee', function ($query) use ($departmentId) {
                $query->where('department_id', $departmentId);
            })
            ->with(['employee.position', 'employee.department'])
            ->orderBy('total_score', 'desc')
            ->get();
    
        // Ambil data skor perkembangan untuk grafik
        $scoreHistory = TotalScore::where('employee_id', $employee->id)
            ->with('period')
            ->orderBy('period_id')
            ->get(['total_score', 'period_id']);

        $comments = Comment::with('user')->latest()->get();
    
        return view('user.dashboard', compact('latestPeriod', 'rankedScores', 'departmentScores', 'employeeDepartment', 'scoreHistory', 'comments'));
    }
}
