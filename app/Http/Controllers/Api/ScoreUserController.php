<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ScoreUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreUserController extends Controller
{
    public function index()
    {
        // Mendapatkan pengguna yang sedang terautentikasi
        $user = Auth::user();
        
        // Jika tidak ada pengguna yang terautentikasi, kembalikan pesan error
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        // Mengambil skor berdasarkan ID pengguna yang sedang login
        $scores = ScoreUser::where('id_user', $user->id)->get();
        
        return response()->json(['data' => $scores]);
    }

    public function show($id)
    {
        $score = ScoreUser::findOrFail($id);
        return response()->json(['data' => $score]);
    }

    public function update(Request $request, $id)
    {
        // Temukan data berdasarkan ID
        $score = ScoreUser::findOrFail($id);

        // Validasi input
        $request->validate([
            // Atur aturan validasi sesuai dengan kebutuhan
        ]);

        // Update data
        $score->update($request->all());

        return response()->json(['message' => 'Score updated successfully', 'data' => $score]);
    }

    public function destroy($id)
    {
        // Temukan data berdasarkan ID
        $score = ScoreUser::findOrFail($id);

        // Hapus data
        $score->delete();

        return response()->json(['message' => 'Score deleted successfully']);
    }
}