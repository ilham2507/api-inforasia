<?php

namespace App\Http\Controllers;

use App\Models\penerima_proyek;
use Illuminate\Http\Request;

class PenerimaProyekController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proyek_id = $request->query('proyek_id');

        if ($proyek_id){
            $penerimaProyeks = penerima_proyek::where('proyek_id', $proyek_id)->get();
        }else{
            $penerimaProyeks = penerima_proyek::all();
        }
        return response()->json(['penerimaProyeks' => $penerimaProyeks], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'proyek_id' => 'required',
            'nama_penerima' => 'required'

        ]);

        $penerima = penerima_proyek::create($request->all());

        return response()->json(['message' => 'penerima proyek berhasil disimpan', 'role' => $penerima], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penerimaProyek = penerima_proyek::find($id);

        if(!$penerimaProyek) {
            return response()->json(['message' => 'Penerima proyek tidak ditemukan'], 404);
        }

        return response()->json(['penerimaProyek' => $penerimaProyek], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penerimaProyek = penerima_proyek::find($id);

        if(!$penerimaProyek) {
            return response()->json(['message' => 'Penerima proyek tidak ditemukan'], 404);
        }

        $penerimaProyek->fill($request->all());
        $penerimaProyek->updated_at = now(); // Atur updated_at secara manual
        $penerimaProyek->save();

        return response()->json(['message' => 'Penerima proyek berhasil diperbarui', 'penerimaProyek' => $penerimaProyek], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penerimaProyek = penerima_proyek::find($id);

        if(!$penerimaProyek) {
            return response()->json(['message' => 'Penerima proyek tidak ditemukan'], 404);
        }

        $penerimaProyek->delete();

        return response()->json(['message' => 'Penerima proyek berhasil dihapus'], 200);
    }
}
