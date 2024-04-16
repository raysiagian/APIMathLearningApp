<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data level
        $levels = Level::all();

        // Mengembalikan data level sebagai respons JSON
        return response()->json(['data' => $levels]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_unit' => 'required|exists:unit,id_unit',
            'level_number' => 'required|integer', // Perbaikan: tambahkan tanda kutip yang hilang di sini
        ]);

        // Membuat record baru dalam database
        $level = Level::create($request->all());

        // Mengembalikan level yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Level created successfully', 'data' => $level], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data level berdasarkan ID
        $level = Level::find($id);

        // Jika level ditemukan, kembalikan sebagai respons JSON
        if ($level) {
            return response()->json(['data' => $level]);
        }

        // Jika level tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Level not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_unit' => 'required|required|exists:unit,id_unit',
            'level_number' => 'required|integer',
        ]);

        // Mengambil data level berdasarkan ID
        $level = Level::find($id);

        // Jika level ditemukan, update data
        if ($level) {
            $level->update($request->all());

            // Mengembalikan level yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Level updated successfully', 'data' => $level]);
        }

        // Jika level tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Level not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Mengambil data level berdasarkan ID
        $level = Level::find($id);

        // Jika level ditemukan, hapus
        if ($level) {
            $level->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Level deleted successfully']);
        }

        // Jika level tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Level not found'], 404);
    }
}
