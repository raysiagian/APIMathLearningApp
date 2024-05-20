<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MaterialVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MaterialVideoController extends Controller
{
    /**
 * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $id_unit = $request->query('id_unit');

        $query = MaterialVideo::query();

        if ($id_unit) {
            $query->where('id_unit', $id_unit);
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
            'id_unit' => 'required|exists:unit,id_unit',
            'video_Url' => 'required|string',
            'title' => 'required|string',
            'explanation' => 'required|string',
        ]);

        $materialvideo = MaterialVideo::create([
            'id_unit' => $request->id_unit,
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
            'id_unit' => 'required|exists:unit,id_unit',
            'video_Url' => 'required|string',
            'title' => 'required|string',
            'explanation' => 'required|string',

        ]);

        $materialvideo = MaterialVideo::find($id);

        // Jika materialvideo ditemukan, update data
        if ($materialvideo) {
            $materialvideo->id_unit = $request->id_unit;
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

    public function checkUserMaterialVideoStatus()
{
    // Mendapatkan pengguna yang sedang login
    $user = Auth::user();

    if (!$user) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Melakukan pengecekan apakah pengguna telah menyelesaikan material video atau tidak
    $materialVideo = MaterialVideo::where('id_unit', $user->id_unit)->first();

    if ($materialVideo && $materialVideo->is_completed) {
        return response()->json(['message' => 'User has completed the material video'], 200);
    } else {
        return response()->json(['message' => 'User has not completed the material video'], 404);
    }
}


}
