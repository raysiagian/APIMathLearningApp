<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register API
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $userData = [
            'name' => $request -> name,
            'email' => $request -> email,
            'password' => Hash::make($request->password),
            'gender' => $request -> gender,
        ];

        $user = User::create($userData);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user'=>$user,
            'token'=> $token,
        ],201);
    }

        // Login API
        public function login(LoginRequest $request)
        {
            // Validasi permintaan
            $validatedData = $request->validated();
        
            $user = User::where('email', $validatedData['email'])->first();
        
            if (!$user || !Hash::check($validatedData['password'], $user->password)) {
                return response()->json([
                    'message' => 'Invalid credentials'
                ], 422);
            }
        
            $token = $user->createToken('auth_token')->plainTextToken;
        
            return response()->json([
                'user' => $user,
                'token' => $token,
            ], 200);
        }
        

    // Check email availability API
    public function checkEmailAvailability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $user = User::where('email', $request->email)->first();

        if ($user) {
            return response()->json([
                'status' => false,
                'message' => 'Email sudah terdaftar',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Email tersedia',
            ]);
        }
    }
    


    // Logout API
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    // Index API
    public function index()
    {
        $users = User::all();

        return response()->json(['data' => $users]);
    }

    // Get user profile API
    public function profile(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'message' => 'Profil pengguna',
            'user' => $user,
        ]);
    }

    // Get username API
    public function getUsername(Request $request)
    {
        // Retrieve the authenticated user
        $user = auth()->user();
    
        // Check if user is authenticated
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    
        // Retrieve the username
        $name = $user->name;
    
        return response()->json(['name' => $name], 200);
    }
    
    
}
