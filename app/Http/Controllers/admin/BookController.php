<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->get();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'stock' => 'required|integer|min:0'
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambah');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'stock' => 'required|integer|min:0'
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
    {
        Book::destroy($id);

        return back()->with('success', 'Buku dihapus');
    }
}