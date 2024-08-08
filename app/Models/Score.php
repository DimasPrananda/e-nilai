<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'sub_criteria_id', 'value'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function subcriteria()
    {
        return $this->belongsTo(Subcriteria::class, 'sub_criteria_id');
    }
}
