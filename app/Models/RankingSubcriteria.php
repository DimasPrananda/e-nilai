<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingSubcriteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'detail', 'ranking_criteria_id'];

    public function ranking_criteria()
    {
        return $this->belongsTo(RankingCriteria::class, 'ranking_criteria_id');
    }
}
