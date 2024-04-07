<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    // Register API
    public function register(Request $request)
    {
        // $user = Auth::user();

        // $token_name = $request->input('token_name', 'api-token');

        // $abilities = $request->input('abilities', [
        //     'order:create',
        //     'order:view',
        //     'WLR3:check_availability'
        // ]);

        // $token = $user->createToken($token_name, $abilities);

        // return $this->view($user, $request);

        // $request->validate([
        //     'name' => 'required',
        //     'email' => 'required|string|email|max:255|unique:user,email',
        //     'password' => 'required',
        //     'gender' => 'required',
        // ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Akun berhasil didaftarkan',
            'user' => $user, // Return the created user data
        ]);
    }

    public function checkEmailAvailability(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Check if email already exists
        $user = User::where('email', $request->email)->first();

        // Return response based on email availability
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

    // Login API
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'token' => $token,
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email atau kata sandi salah.',
            ], 401);
        }
    }

    public function index()
    {
        // Mengambil semua data level
        $users = User::all();

        // Mengembalikan data level sebagai respons JSON
        return response()->json(['data' => $users]);
    }


    // Get user profile API
    public function profile(Request $request)
    {
        $user = $request->user(); // Get authenticated user using middleware

        return response()->json([
            'status' => true,
            'message' => 'Profil pengguna',
            'user' => $user,
        ]);
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

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    
}
