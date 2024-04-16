<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'gender' => 'required',
        ]);

        if ($validator->fails()){
            return response()-> json([
                'success' => false,
                'message' => 'Ada kesalahan',
                'data'=> $validator->errors(),
            ]);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);   

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'berhasil register',
            'data' => $success,
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
    
    public function login(Request $request){
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $auth = Auth::user();
            $success ['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['email'] = $auth->email;
            
            return response()-> json([
                'success' => true,
                'message' => 'login berhasil',
                'data' => $success,
            ]);

        }else{
            return response()->json([
                'success' => false,
                'message' => 'email atau password salah',
                'data' => null,
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

     // Get username API
     public function getUsername(Request $request)
     {
         $user = $request->user(); // Get authenticated user using middleware
 
         return response()->json([
             'status' => true,
             'message' => 'Username retrieved successfully',
             'username' => $user->name, // Return the username of the logged-in user
         ]);
     }


}
