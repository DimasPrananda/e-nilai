<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcriteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'detail', 'criteria_id'];

    /**
     * Get the criteria that owns the subcriteria.
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
