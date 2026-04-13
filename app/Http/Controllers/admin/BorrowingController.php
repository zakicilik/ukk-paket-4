<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])->latest()->get();
        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        // ✅ 1. Cek apakah status masih 'menunggu'
        if ($borrowing->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman sudah diproses sebelumnya!');
        }

        // ✅ 2. Cek stok SEBELUM mengubah status
        $book = Book::find($borrowing->book_id);
        if (!$book || $book->stock <= 0) {
            return back()->with('error', 'Maaf, stok buku sedang habis!');
        }

        // ✅ 3. Kurangi stok
        $book->decrement('stock');

        // ✅ 4. Update status (borrowed_date TIDAK diubah, biarkan tanggal awal user pinjam)
        $borrowing->update([
            'status' => 'dipinjam'
            // borrowed_date tidak diubah, biarkan sesuai tanggal pengajuan user
        ]);

        return back()->with('success', 'Peminjaman berhasil disetujui! Stok buku telah dikurangi.');
    }


    public function update($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        // ✅ Cek apakah status sedang 'dipinjam'
        if ($borrowing->status !== 'dipinjam') {
            return back()->with('error', 'Buku ini tidak sedang dipinjam!');
        }

        $borrowing->update([
            'status' => 'dikembalikan',
            'return_date' => now()
        ]);

        // ✅ Kembalikan stok
        $book = Book::find($borrowing->book_id);
        if ($book) {
            $book->increment('stock');
        }

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    public function destroy($id)
    {
        $borrowing = Borrowing::findOrFail($id);

        // ✅ Jika status 'dipinjam', kembalikan stok dulu sebelum hapus
        if ($borrowing->status === 'dipinjam') {
            $book = Book::find($borrowing->book_id);
            if ($book) {
                $book->increment('stock');
            }
        }

        $borrowing->delete();
        return back()->with('success', 'Data peminjaman berhasil dihapus');
    }
}
