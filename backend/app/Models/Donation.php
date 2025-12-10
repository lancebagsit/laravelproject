<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'contact_number',
        'mode_of_payment',
        'reference_number',
        'donation_amount',
        'status',
        'proof_of_payment_base64',
        'archived_at',
        'archived_by',
    ];
}
