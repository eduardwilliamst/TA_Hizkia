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
        $diskons = Diskon::all();
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
            'presentase' => 'required|numeric|min:0|max:100',
            'keterangan' => '',
        ]);

        // Buat diskon baru
        Diskon::create($request->only(['tanggal_awal', 'tanggal_akhir', 'presentase', 'keterangan']));

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit diskon.
     */
    public function edit(Diskon $diskon)
    {
        return view('diskon.edit', compact('diskon'));
    }

    /**
     * Memperbarui diskon yang ada di database.
     */
    public function update(Request $request, Diskon $diskon)
    {
        // Validasi input
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'presentase' => 'required|numeric|min:0|max:100',
            'keterangan' => '',
        ]);

        // Update diskon
        $diskon->update($request->only(['tanggal_awal', 'tanggal_akhir', 'presentase', 'keterangan']));

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil diperbarui!');
    }

    /**
     * Menghapus diskon dari database.
     */
    public function destroy(Diskon $diskon)
    {
        $diskon->delete();

        return redirect()->route('diskon.index')->with('success', 'Diskon berhasil dihapus!');
    }

    /**
     * Mengambil form edit diskon untuk modal.
     */
    public function getEditForm(Request $request)
    {
        $diskon = Diskon::find($request->id);
        
        // Cek apakah diskon ditemukan
        if (!$diskon) {
            return response()->json(['status' => 'error', 'msg' => 'Diskon tidak ditemukan.'], 404);
        }

        return response()->json([
            'status' => 'oke',
            'msg' => view('diskon.modal', compact('diskon'))->render()
        ]);
    }
}
