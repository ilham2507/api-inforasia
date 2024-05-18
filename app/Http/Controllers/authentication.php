<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class authentication extends Controller
{
   public function login(Request $request)
   {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        $user = User::where('email', $request->email)->first();


        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['cek kembali email dan password anda.'],
            ]);

        }

        $token = $user->createToken('auth')->plainTextToken;
        return response()->json([
             "message" => "success",
             "data" => $user,
             "token" => $token
        ],200);
   }


    //    logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }


    //aktif
    public function aktif(Request $request)
    {
        if (Auth::check()) {
            return response()->json(['message' => 'user aktif']);
        } else {
            return response()->json(['message' => 'user nonaktif']);
        }
    }

    public function index(){
        echo "tes api";
    }
}
