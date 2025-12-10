<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['time', 'language', 'start_at', 'priest_id'];

    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function priest() { return $this->belongsTo(Priest::class); }
}
