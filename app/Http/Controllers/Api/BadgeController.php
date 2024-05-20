<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Models\Badge;

class BadgeController extends Controller
{
    // Menampilkan semua badge
    public function index()
    {
        $badges = Badge::all();
        return response()->json(['data' => $badges]);
    }

    // Menampilkan detail badge berdasarkan ID
    public function show($id)
{
    $badge = Badge::findOrFail($id);
    return response()->json(['data' => $badge]);
}


    // Menyimpan badge baru
    public function store(Request $request)
    {
        // Validasi input menggunakan Validator
        $validator = Validator::make($request->all(), [
            'id_penggunaWeb' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'required',
            'explanation' => 'required',
            'id_posttest' => 'required|numeric',
            'id_materi' => 'required|numeric',
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Simpan file gambar langsung ke dalam direktori public/storage/images
        $imagePath = $request->file('image')->store('public/images');
        $imageName = basename($imagePath); // Ambil nama file dari path gambar

        $badge = Badge::create([
            'id_penggunaWeb' => $request->id_penggunaWeb,
            'image' => $imagePath,
            'title' => $request->title,
            'explanation' => $request->explanation,
            'id_posttest' => $request->id_posttest,
            'id_materi' => $request->id_materi,
            'imageUrl' => url('storage/images/' . $imageName), 
        ]);
        
        return response()->json(['data' => $badge], 201);
    }

    // Memperbarui badge
    public function update(Request $request, $id)
{
    // Temukan badge berdasarkan ID
    $badge = Badge::find($id);

    // Jika badge tidak ditemukan, kembalikan pesan error
    if (!$badge) {
        return response()->json(['error' => 'Badge not found'], 404);
    }

    // Validasi input menggunakan Validator
    $validator = Validator::make($request->all(), [
        'id_penggunaWeb' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'title' => 'required',
        'explanation' => 'required',
        'id_posttest' => 'required|numeric',
        'id_materi' => 'required|numeric',
    ]);

    // Jika validasi gagal, kembalikan pesan error
    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Jika ada file gambar yang diunggah, simpan ke dalam direktori public/storage/images
    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        Storage::delete($badge->image);

        // Simpan gambar baru
        $imagePath = $request->file('image')->store('public/images');
        $imageName = basename($imagePath); // Ambil nama file dari path gambar
        $badge->image = $imagePath;
        $badge->imageUrl = url('storage/images/' . $imageName); // Update URL gambar
    }

    // Update atribut lainnya
    $badge->id_penggunaWeb = $request->id_penggunaWeb;
    $badge->title = $request->title;
    $badge->explanation = $request->explanation;
    $badge->id_posttest = $request->id_posttest;
    $badge->id_materi = $request->id_materi;

    // Simpan perubahan
    $badge->save();

    // Kirim respons API bersama objek Badge yang telah diupdate
    return response()->json(['data' => $badge], 200);
}

    // Menghapus badge
    public function destroy($id)
    {
        try {
            $badge = Badge::findOrFail($id);
            $badge->delete();
            return response()->json(['message' => 'Badge deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete badge.'], 500);
        }
    }

    // Menampilkan badge berdasarkan id_posttest
public function getByPosttestId($id_posttest)
{
    $badges = Badge::where('id_posttest', $id_posttest)->get();
    
    // Periksa apakah badge ditemukan
    if ($badges->isEmpty()) {
        return response()->json(['message' => 'No badges found for the specified posttest id.'], 404);
    }

    return response()->json(['data' => $badges]);
}

}