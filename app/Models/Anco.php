<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anco extends Model {
    protected $table = 'anco_types';
    protected $fillable = [
        'name'
    ];
}