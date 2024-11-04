<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\SubCriteria;
use Illuminate\Http\Request;

class SubCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $criterias = Criteria::all();
        $query = SubCriteria::query();

        if ($request->filled('criteria_id')) {
            $query->where('criteria_id', $request->input('criteria_id'));
        }

        $subcriterias = $query->get();
        return view('admin.penilaian.subcriterias', compact('criterias', 'subcriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'criteria_id' => 'required|exists:criterias,id',
        ]);

        SubCriteria::create($request->only('name', 'detail', 'criteria_id'));
        return redirect()->route('admin.penilaian.subcriterias')->with('success', 'Subcriteria created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCriteria $subCriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCriteria $subCriteria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubCriteria $subCriteria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcriteria $subcriteria)
    {
        $subcriteria->delete();
        return redirect()->route('admin.penilaian.subcriterias')->with('success', 'Subcriteria deleted successfully');
    }
}
