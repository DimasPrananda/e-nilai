<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RankingEvaluation extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'subcriteria_id', 'score', 'period_id'];

    // Relasi ke model Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relasi ke model RankingSubcriteria
    public function subcriteria()
    {
        return $this->belongsTo(RankingSubcriteria::class);
    }

    // Relasi ke model Period
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
