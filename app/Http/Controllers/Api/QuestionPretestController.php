<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionPretest;

class QuestionPretestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data pertanyaan pretest
        $questions = QuestionPretest::all();

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
            'id_pretest' => 'required|exists:pretest,id_pretest',
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
        ]);

        // Membuat record baru dalam database
        $question = QuestionPretest::create($request->all());

        // Mengembalikan pertanyaan pretest yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Question created successfully', 'data' => $question], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil data pertanyaan pretest berdasarkan ID
        $question = QuestionPretest::find($id);

        // Jika pertanyaan pretest ditemukan, kembalikan sebagai respons JSON
        if ($question) {
            return response()->json(['data' => $question]);
        }

        // Jika pertanyaan pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Question not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'id_pretest' => 'required|required|exists:pretest,id_pretest',
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
        ]);

        // Mengambil data pertanyaan pretest berdasarkan ID
        $question = QuestionPretest::find($id);

        // Jika pertanyaan pretest ditemukan, update data
        if ($question) {
            $question->update($request->all());

            // Mengembalikan pertanyaan pretest yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Question updated successfully', 'data' => $question]);
        }

        // Jika pertanyaan pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Question not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Mengambil data pertanyaan pretest berdasarkan ID
        $question = QuestionPretest::find($id);

        // Jika pertanyaan pretest ditemukan, hapus
        if ($question) {
            $question->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Question deleted successfully']);
        }

        // Jika pertanyaan pretest tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Question not found'], 404);
    }
}

