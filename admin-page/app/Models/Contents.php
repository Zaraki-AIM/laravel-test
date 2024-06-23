<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contents extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status', 'grade', 'image'];


    protected $casts = [
        'grade' => 'array',
    ];
}
