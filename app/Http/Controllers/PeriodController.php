<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\TotalScore;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::all();
        return view('admin.penilaian.periods', compact('periods'));
    }

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
}
