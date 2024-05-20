<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LencanaUser;
use Illuminate\Support\Facades\DB; 

class LencanaPenggunaController extends Controller
{
    public function index($id_user = null)
    {
        if ($id_user) {
            $lencanaUsers = LencanaUser::where('id_user', $id_user)->get();
            
            if($lencanaUsers->isEmpty()) {
                return response()->json(['message' => 'Data not found'], 404);
            }
            
            return response()->json(['data' => $lencanaUsers], 200);
        } else {
            $lencanaUsers = LencanaUser::all();
            return response()->json(['data' => $lencanaUsers]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'id_user' => 'required|integer',
                'id_badge' => 'required|integer',
            ]);
    
            // Create a new instance of LencanaUser model
            $lencanaUser = new LencanaUser();
            $lencanaUser->id_user = $validatedData['id_user'];
            $lencanaUser->id_badge = $validatedData['id_badge'];
    
            // Save the LencanaUser instance to the database
            $lencanaUser->save();
    
            // Return a response indicating success
            return response()->json(['message' => 'Badge user saved successfully'], 200);
        } catch (\Exception $e) {
            // Return a response indicating failure
            return response()->json(['message' => 'Failed to save badge user: ' . $e->getMessage()], 500);
        }
    }

    public function getTotalBadgesUser()
    {
        try {
            // Subquery untuk mendapatkan id_LencanaPengguna terkecil untuk setiap id_user
            $subquery = LencanaUser::selectRaw('MIN(id_LencanaPengguna) as min_id')
                                        ->groupBy('id_user');
    
            // Ambil detail LencanaUser berdasarkan hasil subquery
            $badges = LencanaUser::whereIn('id_LencanaPengguna', $subquery)
                                      ->get();
    
            // Kelompokkan hasil berdasarkan id_user dan id_badge, dan hitung total badge untuk setiap user
            $totalBadges = $badges->groupBy(['id_user', 'id_badge'])->map(function ($userBadges) {
                return $userBadges->count();
            });
    
            return response()->json(['total_badges' => $totalBadges]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    
}   