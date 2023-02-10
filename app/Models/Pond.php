<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pond extends Model {
    protected $table = 'ponds';
    protected $fillable = [
        'name', 'wide', 'stock_date'
    ];
}