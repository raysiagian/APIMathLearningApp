<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pretest;

class PretestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data pretest
        $pretests = Pretest::all();

        // Mengembalikan data pretest sebagai respons JSON
        return response()->json(['data' => $pretests]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_level' => 'required|exists:level,id_level',
            'score_pretest' => 'nullable|integer',
        ]);

        // Membuat record baru dalam database
        $pretest = Pretest::create($request->all());

        // Mengembalikan pretest yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Pretest created successfully', 'data' => $pretest], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data pretest berdasarkan ID
        $pretest = Pretest::find($id);

        // Jika pretest ditemukan, kembalikan sebagai respons JSON
        if ($pretest) {
            return response()->json(['data' => $pretest]);
        }

        // Jika pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_level' => 'required|exists:level,id_level',
            'score_pretest' => 'nullable|integer',
        ]);

        // Mengambil data pretest berdasarkan ID
        $pretest = Pretest::find($id);

        // Jika pretest ditemukan, update data
        if ($pretest) {
            $pretest->update($request->all());

            // Mengembalikan pretest yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Pretest updated successfully', 'data' => $pretest]);
        }

        // Jika pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Mengambil data pretest berdasarkan ID
        $pretest = Pretest::find($id);

        // Jika pretest ditemukan, hapus
        if ($pretest) {
            $pretest->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Pretest deleted successfully']);
        }

        // Jika pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found'], 404);
    }
}

