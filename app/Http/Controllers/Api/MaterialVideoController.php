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
    public function index()
    {
        $materialvideos = MaterialVideo::all();

        // Mengembalikan data materialvideos sebagai respons JSON
        return response()->json(['data' => $materialvideos]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_level' => 'required|exists:levels,id_level',
            'video_Url' => 'required|string',
            'title' => 'required|string',
            'explanation' => 'required|string',
        ], [
            'id_level.exists' => 'The selected id_level does not exist.',
        ]);

        $materialvideo = MaterialVideo::create($request->all());

        // Mengembalikan materialvideo yang baru dibuat sebagai respons JSON
        return response()->json(['message' => 'Material Video created successfully', 'data' => $materialvideo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $materialvideo = MaterialVideo::find($id);

        // Jika materialvideo ditemukan, kembalikan sebagai respons JSON
        if ($materialvideo) {
            return response()->json(['data' => $materialvideo]);
        }

        // Jika materialvideo tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Material Video not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MaterialVideo $materialVideo)
    {
        $request->validate([
            'id_level' => 'required|exists:levels,id_level',
            'video_Url' => 'required|string',
            'title' => 'required|string',
            'explanation' => 'required|string',
        ], [
            'id_level.exists' => 'The selected id_level does not exist.',
        ]);

        // Jika materialvideo ditemukan, update data
        if ($materialVideo) {
            $materialVideo->update($request->all());

            // Mengembalikan materialvideo yang telah diperbarui sebagai respons JSON
            return response()->json(['message' => 'Material Video updated successfully', 'data' => $materialVideo]);
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
