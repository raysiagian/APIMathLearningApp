<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unit;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data unit
        $units = Unit::all();

        // Mengembalikan data unit sebagai respons JSON
        return response()->json(['data' => $units]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'title' => 'required',
            'explanation' => 'required',
        ]);

        // Membuat record baru dalam database
        $unit = Unit::create([
            'id_materi' => $request->id_materi,
            'title' => $request->title,
            'explanation' => $request->explanation,
        ]);

        // Mengembalikan unit yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Unit created successfully', 'data' => $unit]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data unit berdasarkan ID
        $unit = Unit::findOrFail($id);

        // Mengembalikan data unit sebagai respons JSON
        return response()->json(['data' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'id_materi' => 'required|exists:materi,id_materi',
            'title' => 'required',
            'explanation' => 'required',
        ]);

        // Mengambil data unit berdasarkan ID
        $unit = Unit::find($id);

        // Jika unit ditemukan, update data
        if ($unit) {
            $unit->id_materi = $request->id_materi;
            $unit->title = $request->title;
            $unit->explanation = $request->explanation;

            // Simpan perubahan
            $unit->save();

            // Mengembalikan unit yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Unit updated successfully', 'data' => $unit]);
        }

        // Jika unit tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Unit not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mengambil data unit berdasarkan ID
        $unit = Unit::find($id);

        // Jika unit ditemukan, hapus
        if ($unit) {
            $unit->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Unit deleted successfully']);
        }

        // Jika unit tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Unit not found'], 404);
    }
}
