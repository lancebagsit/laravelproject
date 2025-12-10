<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'text',
        'definition',
        'image1',
        'image2',
        'image3',
        'archived',
    ];
}
