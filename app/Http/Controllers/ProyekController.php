<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\proyek;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ProyekController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = FacadesAuth::user();
        $data = proyek::where('user_id', $user->id)->get();

        return response()->json(['proyek' => $data]);
        // if ($data->isNotEmpty()) {
        //     // return ApiFormatter::createApi(200, true, $data);
        //     return response()->json(['proyek' => $data], 200);
        // } else {
        //     // return ApiFormatter::createApi(400, false);
        //     return response()->json(['message' => $data]);
        // }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'user_id' => 'required',
            'detail' => 'required',
            'manager' => 'required',
            'team' => 'required',
            // 'file' => 'required|file',
            'nilai' => 'required',
            'start' => 'required|date',
            'finish' => 'required|date'

        ]);

        $proyek = proyek::create($request->all());

        return response()->json(['message' => 'Proyek berhasil disimpan', 'proyek' => $proyek], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyek = proyek::find($id);

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        return response()->json(['proyek' => $proyek], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proyek = proyek::find($id);

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }
        $proyek->fill($request->all());
        $proyek->updated_at = now();
        $proyek->save();

        $proyek->update($request->all());

        return response()->json(['message' => 'Proyek berhasil diperbarui', 'proyek' => $proyek], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proyek = proyek::find($id);

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        $proyek->delete();

        return response()->json(['message' => 'Proyek berhasil dihapus'], 200);
    }
}
