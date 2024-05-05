<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaterialVideo;
use Illuminate\Http\Request;

class MaterialVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_level = $request->query('id_level');

        $query = MaterialVideo::query();

        if ($id_level) {
            $query->where('id_level', $id_level);
        }
    

        $materialvideos = $query->get();

        // Mengembalikan data materialvideos sebagai respons JSON
        return response()->json(['data' => $materialvideos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_level' => 'required|exists:level,id_level',
            'video_Url' => 'required|string',
            'title' => 'required|string',
            'explanation' => 'required|string',
        ]);

        $materialvideo = MaterialVideo::create([
            'id_level' => $request->id_level,
            'video_Url' => $request->video_Url,
            'title' => $request->title,
            'explanation' => $request->explanation,
        ]);

        // Mengembalikan materialvideo yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Material Video created successfully', 'data' => $materialvideo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $materialvideo = MaterialVideo::find($id);

        // Jika materialvideo tidak ditemukan, kembalikan pesan error
        return response()->json(['data' => $materialvideo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_level' => 'required|exists:level,id_level',
            'video_Url' => 'required|string',
            'title' => 'required|string',
            'explanation' => 'required|string',

        ]);

        $materialvideo = MaterialVideo::find($id);

        // Jika materialvideo ditemukan, update data
        if ($materialvideo) {
            $materialvideo->id_level = $request->id_level;
            $materialvideo->video_Url = $request->video_Url;
            $materialvideo->title = $request->title;
            $materialvideo->explanation = $request->explanation;

            // Mengembalikan materialvideo yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Material Video updated successfully', 'data' => $materialvideo]);
        }

        // Jika materialvideo tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Material Video not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $materialvideo = MaterialVideo::find($id);

        if ($materialvideo) {
            $materialvideo->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Material Video deleted successfully']);
        }

        // Jika materialvideo tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Material Video not found'], 404);
    }
}
