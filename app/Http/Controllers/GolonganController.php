<?php

namespace App\Http\Controllers;

use App\Models\Golongan;
use App\Models\Position;
use Illuminate\Http\Request;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $positions = Position::all();
        $query = Golongan::query();

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->input('position_id'));
        }

        $golongans = $query->get();
        return view('admin.golongans', compact('positions', 'golongans'));
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
            'position_id' => 'required|exists:positions,id',
        ]);

        Golongan::create($request->only('name', 'position_id'));
        return redirect()->route('admin.golongans')->with('success', 'Golongan created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Golongan $golongan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Golongan $golongan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Golongan $golongan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Golongan $golongan)
    {
        $golongan->delete();
        return redirect()->route('admin.golongans')->with('success', 'Golongan deleted successfully');
    }
}