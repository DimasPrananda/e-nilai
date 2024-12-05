<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RankingCriteria;
use App\Models\RankingSubcriteria;

class RankingSubcriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ranking_criterias = RankingCriteria::all();
        $query = RankingSubcriteria::query();

        if ($request->filled('ranking_criteria_id')) {
            $query->where('ranking_criteria_id', $request->input('ranking_criteria_id'));
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $entriesPerPage = $request->input('entries_per_page', 10); 

        $ranking_subcriterias = $query->paginate($entriesPerPage);

        if ($request->ajax()) {
            $html = view('admin.ranking.subcriterias-list', compact('ranking_criterias', 'ranking_subcriterias'))->render();
            $paginationLinks = $ranking_subcriterias->appends(request()->query())->links()->render();

            return response()->json([
                'html' => $html,
                'pagination' => $paginationLinks,
            ]);
        }

        return view('admin.ranking.subcriterias', compact('ranking_criterias', 'ranking_subcriterias'));
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
            'ranking_criteria_id' => 'required|exists:ranking_criterias,id',
        ]);

        RankingSubcriteria::create($request->only('name', 'detail', 'ranking_criteria_id'));
        return redirect()->route('admin.ranking.subcriterias')->with('success', 'Subcriteria created successfully');
    }
    
    public function destroy(RankingSubcriteria $ranking_subcriteria)
    {
        $ranking_subcriteria->delete();
        return redirect()->route('admin.ranking.subcriterias')->with('success', 'Subcriteria deleted successfully');
    }
}
