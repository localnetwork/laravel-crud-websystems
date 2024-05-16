<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'age',
        'province',
        'city',
        'barangay',
        'department'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
