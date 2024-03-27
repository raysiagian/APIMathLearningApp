<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posttest;

class PosttestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data posttest
        $posttests = Posttest::all();

        // Mengembalikan data posttest sebagai respons JSON
        return response()->json(['data' => $posttests]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_level' => 'required|exists:level,id_level',
            'score_posttest' => 'nullable|integer',
        ]);

        // Membuat record baru dalam database
        $posttest = Posttest::create($request->all());

        // Mengembalikan posttest yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Posttest created successfully', 'data' => $posttest], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data posttest berdasarkan ID
        $posttest = Posttest::find($id);

        // Jika posttest ditemukan, kembalikan sebagai respons JSON
        if ($posttest) {
            return response()->json(['data' => $posttest]);
        }

        // Jika posttest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Posttest not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_level' => 'required|exists:level,id_level',
            'score_posttest' => 'nullable|integer',
        ]);

        // Mengambil data posttest berdasarkan ID
        $posttest = Posttest::find($id);

        // Jika posttest ditemukan, update data
        if ($posttest) {
            $posttest->update($request->all());

            // Mengembalikan posttest yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Posttest updated successfully', 'data' => $posttest]);
        }

        // Jika posttest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Posttest not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Mengambil data posttest berdasarkan ID
        $posttest = Posttest::find($id);

        // Jika posttest ditemukan, hapus
        if ($posttest) {
            $posttest->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Posttest deleted successfully']);
        }

        // Jika posttest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Posttest not found'], 404);
    }
}

