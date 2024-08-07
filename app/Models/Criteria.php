<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'detail'];

    /**
     * Get the subcriterias for the criteria.
     */
    public function subcriterias()
    {
        return $this->hasMany(SubCriteria::class);
    }
}
