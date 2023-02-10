<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Water extends Model {
    protected $table = 'water_qualities';
    protected $fillable = [
        'pond_id', 'pH', 'temperature', 'salinity', 'DO', 'brightness', 'water_color'
    ];
    protected $hidden = [
        'pond_id'
    ];
}