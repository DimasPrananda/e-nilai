<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'position_id'];

    /**
     * Get the position that owns the golongan.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
