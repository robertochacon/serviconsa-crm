<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Closing extends Model
{
    use HasFactory;

    protected $table = 'closings';

    protected $casts = [
        'services' => 'array',
        'payments' => 'array',
    ];

    protected $fillable = [
        'provider','services','meters','total_meters','total_do','payments','pending','date','status',
    ];
}
