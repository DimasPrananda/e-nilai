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

    public function store(Request $request)
    {
    $request->validate([
        'start_year' => 'required|integer|min:1900|max:2099',
        'end_year' => 'required|integer|min:1900|max:2099',
        'start_month' => 'required|string',
        'end_month' => 'required|string',
    ]);

    // Pastikan end_year dan end_month tidak kurang dari start_year dan start_month
    if (($request->input('end_year') < $request->input('start_year')) || 
        ($request->input('end_year') == $request->input('start_year') && array_search($request->input('end_month'), ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']) < array_search($request->input('start_month'), ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']))) {
        return redirect()->back()->withErrors(['end_year' => 'End period must be greater than or equal to start period.']);
    }

    // Gabungkan bulan dan tahun untuk membuat periode
    $start_period = $request->input('start_month') . ' ' . $request->input('start_year');
    $end_period = $request->input('end_month') . ' ' . $request->input('end_year');
    $period = $start_period . ' - ' . $end_period;

    Period::create(['period' => $period]);

    return redirect()->route('admin.penilaian.periods')
                     ->with('success', 'Period successfully added.');
}

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
