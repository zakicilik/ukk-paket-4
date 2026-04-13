<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'stock',
        'description'
    ];

    protected $casts = [
        'publication_year' => 'integer',
        'stock' => 'integer',
    ];

    // RELATION
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // HELPER
    public function isAvailable()
    {
        return $this->stock > 0;
    }

    // ACCESSOR (opsional)
    public function getCoverUrlAttribute()
    {
        return $this->cover 
            ? asset('storage/' . $this->cover) 
            : asset('default-book.png');
    }
}
