<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::where('stock', '>', 0)->get();
        $borrowings = Borrowing::where('user_id', Auth::id())->get();
        return view('user.dashboard', compact('books', 'borrowings'));
    }
}
