<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kimia extends Model {
    protected $table = 'kimias';
    protected $fillable = [
        'pond_id', 'amoniak', 'nitrat', 'nitrit', 'alkanitas'
    ];
    protected $hidden = [
        'pond_id'
    ];
}