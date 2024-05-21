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
                    'message' => 'Email atau password anda salah'
                ], 422);
            }

            if ($user->is_active != 1) {
                return response()->json([
                    'message' => 'Akun anda tidak aktif'
                ], 403);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'is_active' => $user->is_active,  // Add is_active field to the response
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
    
    // Decrease lives API
    public function getLivesByUserId($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Asumsikan kolom `lives` menyimpan data dalam format JSON
        $lives = json_decode($user->lives, true);

        return response()->json([
            'status' => true,
            'lives' => $lives,
        ]);
    }

    // Update lives by user ID API
    public function updateLivesByUserId(Request $request, $id)
    {
        // Validasi permintaan
        $validator = Validator::make($request->all(), [
            'lives' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Temukan pengguna berdasarkan ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }

        // Update jumlah nyawa
        $user->lives = $request->lives;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Jumlah nyawa berhasil diperbarui',
            'user' => $user,
        ]);
    }

    
}
