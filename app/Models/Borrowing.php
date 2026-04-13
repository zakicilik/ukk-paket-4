<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_date',
        'return_date',
        'status'
    ];

    protected $casts = [
        'borrowed_date' => 'date',
        'return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isPending()
    {
        return $this->status === 'menunggu';
    }

    public function isBorrowed()
    {
        return $this->status === 'dipinjam';
    }

    public function isReturned()
    {
        return $this->status === 'dikembalikan';
    }

    public function isRejected()
    {
        return $this->status === 'ditolak';
    }
}