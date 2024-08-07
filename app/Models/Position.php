<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the golongans for the position.
     */
    public function golongans()
    {
        return $this->hasMany(Golongan::class);
    }
}
