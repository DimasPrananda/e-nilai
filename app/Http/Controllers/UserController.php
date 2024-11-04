<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Criteria;
use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function selectPeriods()
    {
        $periods = Period::all();
        return view('user.select-periods', compact('periods'));
    }

    // Menampilkan detail penilaian berdasarkan periode
    public function showDetail($periodId)
    {
        // Mengambil nama pengguna yang sedang login
        $userName = Auth::user()->name;
        $period = Period::find($periodId);
    
        if (!$period) {
            return redirect()->route('user.select-periods')
                             ->with('error', 'Periode tidak ditemukan.');
        }
    
        // Cari data employee berdasarkan nama yang sama
        $employee = Employee::where('name', $userName)->first();
    
        if (!$employee) {
            return redirect()->route('user.select-periods')
                             ->with('error', 'Karyawan tidak ditemukan.');
        }
    
        // Mendapatkan semua kriteria dan subkriteria
        $criterias = Criteria::with('subcriterias')->get();
    
        // Mendapatkan nilai evaluasi berdasarkan employee_id yang ditemukan
        $scores = Evaluation::where('employee_id', $employee->id)
                            ->where('period_id', $periodId)
                            ->pluck('score', 'subcriteria_id')
                            ->toArray();
    
        return view('user.detail', compact('employee', 'period', 'criterias', 'scores'));
    }
}
