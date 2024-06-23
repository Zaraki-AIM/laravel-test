<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'genre',
        'published_date',
        'status'
    ];

    // bookインスタンスを生成する
    public static function createInstance(array $attributes = [])
    {
        return new static(array_merge([
            'title' => 'Default Title',
            'author' => 'Default Author',
            'genre' => 'Default Genre',
            'published_date' => now(),
            'status' => 'available'
        ], $attributes));
    }
}
