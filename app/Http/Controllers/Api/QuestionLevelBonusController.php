<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionLevelBonus;

class QuestionLevelBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mengambil semua data pertanyaan level_bonus
        $id_level_bonus = $request->query('id_level_bonus');

        $query = QuestionLevelBonus::query();

        if ($id_level_bonus) {
            $query->where('id_level_bonus', $id_level_bonus); 
        }

        $questions = $query->get();

        // Mengembalikan data pertanyaan pretest sebagai respons JSON
        return response()->json(['data' => $questions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'id_level_bonus' => 'required|exists:level_bonus,id_level_bonus',
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'correct_index' => 'required|string',
        ]);

        // Membuat record baru dalam database
        $question = QuestionLevelBonus::create($request->all());

        // Mengembalikan pertanyaan level_bonus yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Question created successfully', 'data' => $question], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data pertanyaan level_bonus berdasarkan ID
        $question = QuestionLevelBonus::find($id);

        // Jika pertanyaan level_bonus ditemukan, kembalikan sebagai respons JSON
        if ($question) {
            return response()->json(['data' => $question]);
        }

        // Jika pertanyaan level_bonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Question not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_level_bonus' => 'required|required|exists:level_bonus,id_level_bonus',
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'correct_index' => 'required|string',
        ]);

        // Mengambil data pertanyaan level_bonus berdasarkan ID
        $question = QuestionLevelBonus::find($id);

        // Jika pertanyaan level_bonus ditemukan, update data
        if ($question) {
            $question->update($request->all());

            // Mengembalikan pertanyaan level_bonus yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Question updated successfully', 'data' => $question]);
        }

        // Jika pertanyaan level_bonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Question not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Mengambil data pertanyaan level_bonus berdasarkan ID
        $question = QuestionLevelBonus::find($id);

        // Jika pertanyaan level_bonus ditemukan, hapus
        if ($question) {
            $question->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Question deleted successfully']);
        }

        // Jika pertanyaan level_bonus tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Question not found'], 404);
    }
}
