<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WatchMaterialVideo;
use App\Models\MaterialVideo;
use Illuminate\Support\Facades\Auth;

class WatchMaterialVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkUserVideoStatus()
    {
        // Mendapatkan pengguna yang sedang login
        $id_user = Auth::id_user();


        // Melakukan pengecekan apakah pengguna telah mengerjakan materialvideo atau tidak
        $materialvideo = WatchMaterialVideo::where('id_unit', $id_user->id_unit)->first();

        if ($materialvideo) {
            return response()->json(['message' => 'User has completed the materialvideo'], 200);
        } else {
            return response()->json(['message' => 'User has not completed the materialvideo'], 404);
        }
    }

    public function markVideoCompleted(Request $request, $id)
    {
        try {
            // Get the currently authenticated user

            $id_user = Auth::id();

            $request->validate([
                'id_unit' => 'required|integer',
                'id_material_video' => 'required|integer',
            ]);

            $watchMaterialVideo = new WatchMaterialVideo();
            $watchMaterialVideo-> id_unit = $request->id_unit;
            $watchMaterialVideo->id_user = $id_user;
            $watchMaterialVideo->is_completed = $request->is_completed;
            $watchMaterialVideo-> id_material_video = $request->id_material_video;

            $watchMaterialVideo->save();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Video updated successfully', 'data' => $watchMaterialVideo]);
        } catch (\Exception $e) {
            // Menangkap dan menampilkan kesalahan
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function getWatchVideoByUnit($unitId)
    {
        $userId = Auth::id();
        $scores = WatchMaterialVideo::where('id_user', $userId)
                              ->where('id_unit', $unitId)
                              ->get();
        if ($scores->isEmpty()) {
            return response()->json(['message' => 'No data found'], 404);
        }
        return response()->json($scores);
    }

    public function getWatchVideoByUnitSmallIdVideo($unitId)
    {
        $userId = Auth::id();
        
        // Query untuk mengambil data dengan id_unit tertentu yang dimiliki oleh user yang login,
        // diurutkan berdasarkan id_ScorePreTest, dan hanya mengambil baris pertama.
        $score = WatchMaterialVideo::where('id_user', $userId)
                             ->where('id_unit', $unitId)
                             ->orderBy('id_WatchMaterialVideo', 'asc')
                             ->first();

        if ($score) {
            return response()->json($score);
        } else {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }
    

}
