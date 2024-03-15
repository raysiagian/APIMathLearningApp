<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Materi;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data materi
        $materi = Materi::all();

        // Mengembalikan data materi sebagai response
        return response()->json(['data' => $materi]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            "title" => "required",
            "imageCard" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
            "imageBackground" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        // Mengambil file gambar dari request
        $imageCard = $request->file('imageCard')->store('public/images');
        $imageBackground = $request->file('imageBackground')->store('public/images');

        // Membuat record baru dalam database
        $materi = Materi::create([
            "title" => $request->title,
            "imageCard"=> $imageCard,
            "imageBackground"=> $imageBackground,
        ]);

        // Mengembalikan materi yang baru dibuat sebagai response
        return response()->json(['message' => 'Materi created successfully', 'data' => $materi]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data materi berdasarkan ID
        $materi = Materi::find($id);

        // Jika materi ditemukan, kembalikan sebagai response
        if ($materi) {
            return response()->json(['data' => $materi]);
        }

        // Jika materi tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Materi not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            "title" => "required",
            "imageCard" => "image|mimes:jpeg,png,jpg,gif|max:2048",
            "imageBackground" => "image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        // Mengambil data materi berdasarkan ID
        $materi = Materi::find($id);

        // Jika materi ditemukan, update data
        if ($materi) {
            $materi->title = $request->title;

            // Jika ada file gambar baru yang diupload, simpan dan perbarui nama file
            if ($request->hasFile('imageCard')) {
                $imageCard = $request->file('imageCard')->store('public/images');
                $materi->imageCard = $imageCard;
            }

            if ($request->hasFile('imageBackground')) {
                $imageBackground = $request->file('imageBackground')->store('public/images');
                $materi->imageBackground = $imageBackground;
            }

            // Simpan perubahan
            $materi->save();

            // Mengembalikan materi yang telah diperbarui sebagai response
            return response()->json(['message' => 'Materi updated successfully', 'data' => $materi]);
        }

        // Jika materi tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Materi not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mengambil data materi berdasarkan ID
        $materi = Materi::find($id);

        // Jika materi ditemukan, hapus
        if ($materi) {
            $materi->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Materi deleted successfully']);
        }

        // Jika materi tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Materi not found'], 404);
    }
}
