<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailAnco extends Model {
    protected $table = 'ancos';
    protected $fillable = [
        'pond_id',
        'anco_type_id',	
        'started_time',
        'finished_time',
        'duration',
    ];
}