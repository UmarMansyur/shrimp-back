<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model {
    protected $table = 'feeds';
    protected $fillable = [
        'pond_id', 'amount', 'accumulative', 'description'
    ];
    protected $hidden = [
        'pond_id'
    ];
}