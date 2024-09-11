<?php

namespace App\Http\Controllers;

use App\Models\RankingCriteria;
use Illuminate\Http\Request;

class RankingCriteriaController extends Controller
{
    // Menampilkan daftar kriteria
    public function index()
    {
        $ranking_criterias = RankingCriteria::all();
        $total_intensity = $ranking_criterias->sum('intensity');
        $evaluations = [];
        $total_evaluation_weight = 0; // Inisialisasi variabel untuk total evaluasi faktor

        // Menghitung evaluasi faktor untuk setiap kriteria
        foreach ($ranking_criterias as $ranking_criteria) {
            $evaluasi = $total_intensity > 0 ? $ranking_criteria->intensity / $total_intensity : 0;
            $evaluations[$ranking_criteria->id] = $evaluasi;
            $ranking_criteria->evaluations = $evaluasi; // Menyimpan nilai evaluasi ke model
            $ranking_criteria->save(); // Simpan perubahan ke database
            $total_evaluation_weight += $evaluasi; // Menambahkan ke total evaluasi faktor
        }

        return view('admin.ranking.criterias', compact('ranking_criterias', 'total_intensity', 'evaluations', 'total_evaluation_weight'));
    }

    // Menyimpan kriteria baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'intensity' => 'required|integer',
            'nilai_max' => 'required|integer',
            'evaluations' => 'nullable|numeric', // Tambahkan validasi untuk evaluations
        ]);

        RankingCriteria::create([
            'name' => $validated['name'],
            'intensity' => $validated['intensity'],
            'nilai_max' => $validated['nilai_max'],
            'evaluations' => $validated['evaluations'] ?? 0, // Set default jika evaluations tidak ada
        ]);

        return redirect()->route('admin.ranking.criterias')->with('success', 'Kriteria berhasil ditambahkan');
    }

    // Menghitung hasil evaluasi
    public function calculate()
    {
        $ranking_criterias = RankingCriteria::all();
        $total_intensity = $ranking_criterias->sum('intensity');
        $evaluations = [];

        foreach ($ranking_criterias as $ranking_criteria) {
            $evaluations[$ranking_criteria->name] = $total_intensity > 0 ? $ranking_criteria->intensity / $total_intensity : 0;
        }

        return view('criterias.result', compact('evaluations'));
    }

    // Menghapus kriteria
    public function destroy($id)
    {
        $ranking_criteria = RankingCriteria::findOrFail($id);
        $ranking_criteria->delete();

        return redirect()->route('admin.ranking.criterias')->with('success', 'Kriteria berhasil dihapus');
    }
}
