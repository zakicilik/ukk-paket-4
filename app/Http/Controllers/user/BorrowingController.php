<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function books(Request $request)
    {
        $search = $request->get('search');

        // ✅ Gunakan paginate() untuk mendukung pencarian
        $books = Book::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%');
        })->paginate(12);

        $borrowings = Borrowing::where('user_id', Auth::id())->get();

        return view('user.books.index', compact('books', 'borrowings'));
    }

    public function index()
    {
        $borrowings = Borrowing::with('book')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.borrowings.index', compact('borrowings'));
    }

    public function pinjam($id)
    {
        $book = Book::findOrFail($id);

        // ✅ 1. Cek stok (tidak dikurangi dulu)
        if ($book->stock <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        // ✅ 2. Cek apakah sudah meminjam buku yang sama
        $existing = Borrowing::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah meminjam atau menunggu konfirmasi buku ini!');
        }

        // ✅ 3. Buat peminjaman dengan borrowed_date (stok TIDAK dikurangi dulu)
        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'borrowed_date' => now(),
            'status' => 'menunggu'
            // stock TIDAK dikurangi di sini
        ]);

        return back()->with('success', 'Pengajuan peminjaman dikirim! Silakan tunggu verifikasi admin.');
    }

    /**
     * Kembalikan buku yang dipinjam
     */
    public function kembali($id)
    {
        // Cari data peminjaman yang sedang dipinjam
        $borrowing = Borrowing::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->first();

        if (!$borrowing) {
            return back()->with('error', 'Data peminjaman tidak ditemukan atau buku sudah dikembalikan!');
        }

        // Update status menjadi dikembalikan
        $borrowing->update([
            'return_date' => now(),
            'status' => 'dikembalikan'
        ]);

        // Kembalikan stok buku
        $book = Book::find($borrowing->book_id);
        if ($book) {
            $book->increment('stock');
        }

        return redirect()->route('user.borrowings')->with('success', 'Buku berhasil dikembalikan! Terima kasih.');
    }
}
