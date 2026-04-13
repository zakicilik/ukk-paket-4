<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $users = User::count();
        $borrowings = Borrowing::count();
        $activeBorrowings = Borrowing::where('status', 'dipinjam')->count();


        return view('admin.dashboard', compact('books', 'users', 'borrowings', 'activeBorrowings'));
    }
}