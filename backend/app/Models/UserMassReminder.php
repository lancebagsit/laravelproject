<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserMassReminder extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'start_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
    ];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function schedule(): BelongsTo { return $this->belongsTo(Schedule::class); }
}

