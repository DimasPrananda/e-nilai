<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingCriteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'intensity', 'nilai_max', 'evaluations'];

    public function ranking_subcriteria()
    {
        return $this->hasMany(RankingSubcriteria::class, 'ranking_criteria_id');
    }
}
