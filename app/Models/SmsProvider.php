<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsProvider extends Model
{
    protected $fillable = ['name', 'driver', 'credentials', 'is_active'];

    protected $casts = [
        'credentials' => 'array',
        'is_active' => 'boolean',
    ];
}
