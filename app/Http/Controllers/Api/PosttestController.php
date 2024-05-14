<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Posttest; // Mengubah namespace model yang digunakan
use Illuminate\Support\Facades\Auth;

class PosttestController extends Controller // Mengubah nama kelas kontroler

{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil semua data posttest
        $id_unit = $request->query('id_unit');

        // Membuat query untuk mengambil semua data unit
        $query = Posttest::query();
    
        // Jika id_materi diberikan, filter unit berdasarkan id_materi
        if ($id_unit) {
            $query->where('id_unit', $id_unit);
        }
    
        // Mengambil data unit sesuai dengan query yang telah dibuat
        $posttests = $query->get();
    
        // Mengembalikan data unit sebagai respons JSON
        return response()->json(['data' => $posttests]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([

            'id_unit' => 'required|exists:unit,id_unit',
            'score_posttest' => 'nullable|integer',
        ]);

        // Membuat record baru dalam database
        $posttest = Posttest::create([
            'id_unit' => $request->id_unit,
            'score_posttest' => $request->score_posttest,
        ]);

        // Mengembalikan posttest yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Pretest created successfully', 'data' => $posttest]);
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        // Mengambil data posttest berdasarkan ID
        $posttest = Posttest::find($id); // Mengubah model yang digunakan

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
            'id_unit' => 'required|exists:unit,id_unit',
            'score_posttest' => 'nullable|integer', // Mengubah nama field dari score_posttest menjadi score_posttest
        ]);

        // Mengambil data posttest berdasarkan ID
        $posttest = Posttest::find($id); // Mengubah model yang digunakan

        if ($posttest) {
            $posttest->id_unit = $request->id_unit;
            $posttest->score_posttest = $request->score_posttest;
            

            $posttest->save();

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
        $posttest = Posttest::find($id); // Mengubah model yang digunakan

        // Jika posttest ditemukan, hapus
        if ($posttest) {
            $posttest->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Posttest deleted successfully']);
        }

        // Jika posttest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Posttest not found'], 404);
    }




    public function updateFinalScore(Request $request, $id)
{
    try {
        // Validasi input
        $request->validate([
            'score_posttest' => 'required|integer',
        ]);

        // Mengambil data posttest berdasarkan ID posttest
        $posttest = Posttest::find($id);

        // Jika posttest ditemukan, update score_posttest
        if ($posttest) {
            $posttest->score_posttest = $request->score_posttest;
            $posttest->save(); // Simpan perubahan ke database

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $posttest]);
        }

        // Jika posttest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found for ID: ' . $id], 404);
    } catch (\Exception $e) {
        // Menangkap dan menampilkan kesalahan
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function checkUserPosttestStatus()
{
    // Mendapatkan pengguna yang sedang login
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Melakukan pengecekan apakah pengguna telah mengerjakan posttest atau tidak
    $posttest = Posttest::where('id_unit', $user->id_unit)->first();

    if ($posttest) {
        return response()->json(['message' => 'User has completed the posttest'], 200);
    } else {
        return response()->json(['message' => 'User has not completed the posttest'], 404);
    }
}


}

