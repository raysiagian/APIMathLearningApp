<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LevelBonus;

class LevelBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data LevelBonus
        $levelbonuss = LevelBonus::all();

        // Mengembalikan data LevelBonus sebagai respons JSON
        return response()->json(['data' => $levelbonuss]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_unit_Bonus' => 'required|exists:unit_bonus,id_unit_Bonus',
            'level_number' => 'required|integer',
            'score_bonus' => 'nullable|integer',
        ]);

        // Membuat record baru dalam database
        $levelbonus = LevelBonus::create($request->all());

        // Mengembalikan LevelBonus yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Pretest created successfully', 'data' => $levelbonus], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data LevelBonus berdasarkan ID
        $levelbonus = LevelBonus::find($id);

        // Jika LevelBonus ditemukan, kembalikan sebagai respons JSON
        if ($levelbonus) {
            return response()->json(['data' => $levelbonus]);
        }

        // Jika LevelBonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_unit_Bonus' => 'required|exists:unit_bonus,id_unit_Bonus',
            'level_number' => 'required|integer',
            'score_bonus' => 'nullable|integer',
        ]);

        // Mengambil data LevelBonus berdasarkan ID
        $levelbonus = LevelBonus::find($id);

        // Jika LevelBonus ditemukan, update data
        if ($levelbonus) {
            $levelbonus->update($request->all());

            // Mengembalikan LevelBonus yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Pretest updated successfully', 'data' => $levelbonus]);
        }

        // Jika LevelBonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Pretest not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Mengambil data LevelBonus berdasarkan ID
        $levelbonus = LevelBonus::find($id);

        // Jika LevelBonus ditemukan, hapus
        if ($levelbonus) {
            $levelbonus->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Level Bonus deleted successfully']);
        }

        // Jika LevelBonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Level Bonus not found'], 404);
    }


    /**
 * Update the score_pretest for the specified LevelBonus.
 */
public function updateFinalScore(Request $request, $id)
{
    try {
        // Validasi input
        $request->validate([
            'score_bonus' => 'required|integer',
        ]);

        // Mengambil data LevelBonus berdasarkan ID LevelBonus
        $levelbonus = LevelBonus::find($id);

        // Jika LevelBonus ditemukan, update score_pretest
        if ($levelbonus) {
            $levelbonus->score_bonus = $request->score_bonus;
            $levelbonus->save(); // Simpan perubahan ke database

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Score updated successfully', 'data' => $levelbonus]);
        }

        // Jika LevelBonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Level Bonus not found for ID: ' . $id], 404);
    } catch (\Exception $e) {
        // Menangkap dan menampilkan kesalahan
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
