<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        // Mengambil semua data role
        $role = Role::all();

        // Mengembalikan data role sebagai response
        return response()->json(['data' => $role]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            "role_name" => "required",
        ]);


        // Membuat record baru dalam database
        $role = Role::create([
            "role_name" => $request->role_name,
        ]);

        // Mengembalikan role yang baru dibuat sebagai response
        return response()->json(['message' => 'Role created successfully', 'data' => $role]);
    }

    public function show(string $id)
    {
        // Mengambil data role berdasarkan ID
        $role = Role::find($id);

        // Jika role ditemukan, kembalikan sebagai response
        if ($role) {
            return response()->json(['data' => $role]);
        }

        // Jika role tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Role not found'], 404);
    }

    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            "role_name" => "required",
        ]);

        // Mengambil data role berdasarkan ID
        $role = Role::find($id);

        // Jika role ditemukan, update data
        if ($role) {
            $role->role_name = $request->role_name;

            // Simpan perubahan
            $role->save();

            // Mengembalikan role yang telah diperbarui sebagai response
            return response()->json(['message' => 'Role updated successfully', 'data' => $role]);
        }

        // Jika role tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Role not found'], 404);
    }

    public function destroy(string $id)
    {
        // Mengambil data role berdasarkan ID
        $role = Role::find($id);

        // Jika role ditemukan, hapus
        if ($role) {
            $role->delete();

            // Mengembalikan pesan sukses
            return response()->json(['message' => 'Role deleted successfully']);
        }

        // Jika role tidak ditemukan, kembalikan pesan error
        return response()->json(['message' => 'Role not found'], 404);
    }


}
