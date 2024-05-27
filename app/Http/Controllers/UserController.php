<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $users = User::with('role')->get();
        // dd($users);
        return response()->json(['users' => $users], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function getManager()
    {
        $user = User::where('role_id', 3)->OrderByDesc('id')->get();

        return response()->json(['users' => $user], 200);
    }

    public function getUserData()
    {
        $userId = auth()->id();
        $user = User::with('role')->find($userId);

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        return response()->json(['user' => $user], 200);
    }



    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'name' => 'required',
            'nip' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required',
            'password' => 'required|string|min:8',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            // 'foto_profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // $fileNameImage = time() . '.' . $request->foto_profile->extension();
        // $request->foto_profile->move(public_path('foto/'), $fileNameImage);

        $user = User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
            'email_verified_at' => now(),
            'alamat' => $request->alamat,
            'remember_token' =>  rand(10, 100),
            // 'foto_profile' => $fileNameImage,
        ]);

        $user->save();

        return response()->json(['message' => 'Pengguna berhasil disimpan', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $userId)
    {
        $user = User::with('role')->find($userId);

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }
        $request->validate([
            'role_id' => 'required',
            'name' => 'required',
            'nip' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'nullable|string|min:8',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            // 'foto_profile' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // if ($request->hasFile('image')) {
        //     $deleteimage = $user->foto_profile;
        //     if ($deleteimage) {
        //         File::delete(public_path('foto/') . '/' . $deleteimage);
        //     }

        //     $fileNameImage = time() . '.' . $request->foto_profile->extension();
        //     $request->foto_profile->move(public_path('foto/product/'), $fileNameImage);
        //     $validateData['foto_profile'] = $fileNameImage;
        // }

        // Check if password needs to be updated
        if ($request->has('password') && $request->password) {
            $user->password = Hash::make($request->password);
        }

        // Handle foto_profile update
        $user->update([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'username' => $request->username,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telp' => $request->no_telp,
            'email_verified_at' => now(),
            'alamat' => $request->alamat,
            'remember_token' =>  rand(10, 100),
            // 'foto_profile' => $fileNameImage,
        ]);

        return response()->json(['message' => 'Pengguna berhasil diperbarui', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Pengguna berhasil dihapus'], 200);
    }
}
