<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class ApiController extends Controller
{
    // Register API

    public function register(Request $request){

        $request->validate([
            "name" => "required",
            'email' => 'required|string|email|max:255|unique:users,email',
            "password" => "required|confirmed",
            "gender" => "required",
        ]);

        User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "gender" => $request->gender,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Akun berhasil didaftarkan"
        ]);
        
    }

    public function login(Request $request){

        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", $request->email)->first();
        
        if(!empty($user)){
            // user exist
            if(Hash::check($request->password, $user->password)){

                $token = $user->createToken("tokenSaya")->plainTextToken;

                return response()-> json([
                    "status"=>true,
                    "message"=>"Login berhasil",
                    "token"=>$token,
                ]);
            }

            return response()-> json([
                "status"=>false,
                "message"=>"Password salah",
            ]);
        }

        return response()->json([
            "status"=> false,
            "message"=> "Akun tidak ditemukan",
        ]);
        
    }

    public function profile(){

        $data = auth()->user();

        return response()->json([
            "status"=> true,
            "message"=>"Profil",
            "user"=> $data,
        ]);
    }

    public function logout(){

        auth()->user()->tokens()->delete();

        return response()->json([
            "status"=> true,
            "message"=>"Logout"
        ]);
    }
}
