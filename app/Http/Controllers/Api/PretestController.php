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
    public function index(Request $request){

        $id_level = $request->query('id_level');

        // Membuat query untuk mengambil semua data unit
        $query = Pretest::query();
    
        // Jika id_materi diberikan, filter unit berdasarkan id_materi
        if ($id_level) {
            $query->where('id_level', $id_level);
        }
    
        // Mengambil data unit sesuai dengan query yang telah dibuat
        $pretests = $query->get();
    
        // Mengembalikan data unit sebagai respons JSON
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
        $pretest = Pretest::create([
            'id_level' => $request->id_level,
            'score_pretest' => $request->score_pretest,
        ]);

        // Mengembalikan pretest yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Pretest created successfully', 'data' => $pretest]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Mengambil data pretest berdasarkan ID
        $pretest = Pretest::find($id);

        // Jika pretest ditemukan, kembalikan sebagai respons JSON
        return response()->json(['data' => $pretest]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
            $pretest->id_level = $request->id_level;
            $pretest->score_pretest = $request->score_pretest;
            

            $pretest->save();

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


    /**
 * Update the score_pretest for the specified pretest.
 */
public function updateFinalScore(Request $request, $id)
{
    try {
        // Validasi input
        $request->validate([
            'score_pretest' => 'required|integer',
        ]);

        // Mengambil data pretest berdasarkan ID pretest
        $pretest = Pretest::find($id);

        // Jika pretest ditemukan, update score_pretest
        if ($pretest) {
            $pretest->score_pretest = $request->score_pretest;
            $pretest->save(); // Simpan perubahan ke database

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $pretest]);
        }

        // Jika pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found for ID: ' . $id], 404);
    } catch (\Exception $e) {
        // Menangkap dan menampilkan kesalahan
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}

