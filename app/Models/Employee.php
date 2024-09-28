<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'employee_number', 
        'department_id', 
        'position_id', 
        'golongan_id'
    ];

    /**
     * Get the department that owns the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the position that owns the employee.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Get the golongan that owns the employee.
     */
    public function golongan()
    {
        return $this->belongsTo(Golongan::class);
    }

    public function totalScores()
    {
        return $this->hasOne(TotalScore::class, 'employee_id');
    }
    
    public function RankingTotalScores()
    {
        return $this->hasOne(RankingTotalScore::class, 'employee_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
