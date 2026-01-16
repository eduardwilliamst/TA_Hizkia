<?php

namespace App\Http\Controllers;

use App\Models\Diskon;
use Illuminate\Http\Request;

class DiskonController extends Controller
{
    /**
     * Menampilkan daftar diskon.
     */
    public function index()
    {
        $diskons = Diskon::orderBy('tanggal_awal', 'desc')->get();
        return view('diskon.index', compact('diskons'));
    }

    /**
     * Menampilkan form untuk membuat diskon baru.
     */
    public function create()
    {
        return view('diskon.create');
    }

    /**
     * Menyimpan diskon baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'presentase' => 'required|integer|min:1|max:100',
            'keterangan' => 'required|string|max:255',
        ]);

        // Simpan diskon baru
        Diskon::create([
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'presentase' => $request->presentase,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit diskon.
     */
    public function edit($id)
    {
        $diskon = Diskon::findOrFail($id);
        return view('diskon.edit', compact('diskon'));
    }

    /**
     * Get edit form via AJAX
     */
    public function getEditForm(Request $request)
    {
        $diskon = Diskon::findOrFail($request->id);

        $html = view('diskon.modal', compact('diskon'))->render();

        return response()->json(['msg' => $html]);
    }

    /**
     * Memperbarui diskon yang ada di database.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'presentase' => 'required|integer|min:1|max:100',
            'keterangan' => 'required|string|max:255',
        ]);

        // Temukan diskon dan update data
        $diskon = Diskon::findOrFail($id);
        $diskon->update([
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'presentase' => $request->presentase,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui!');
    }

    /**
     * Menghapus diskon dari database.
     */
    public function destroy($id)
    {
        $diskon = Diskon::findOrFail($id);
        $diskon->delete();

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus!');
    }

    /**
     * Get active discount percentage
     */
    public static function getActiveDiscount()
    {
        $now = now();
        $diskon = Diskon::where('tanggal_awal', '<=', $now)
            ->where('tanggal_akhir', '>=', $now)
            ->orderBy('presentase', 'desc')
            ->first();

        return $diskon ? $diskon->presentase : 0;
    }
}
