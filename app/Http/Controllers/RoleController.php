<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = role::all();
        return response()->json(['roles' => $roles], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',

        ]);

        $role = role::create($request->all());

        return response()->json(['message' => 'Role berhasil disimpan', 'role' => $role], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = role::find($id);

        if(!$role) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }

        return response()->json(['role' => $role], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = role::find($id);

        if(!$role) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }

        $role->fill($request->all());
        $role->updated_at = now(); // Atur updated_at secara manual
        $role->save();

        return response()->json(['message' => 'Role berhasil diperbarui', 'role' => $role], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = role::find($id);

        if(!$role) {
            return response()->json(['message' => 'Role tidak ditemukan'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Role berhasil dihapus'], 200);
    }
}
