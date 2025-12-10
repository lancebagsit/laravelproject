<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priest extends Model
{
    protected $fillable = ['name', 'image', 'description', 'archived'];
}
