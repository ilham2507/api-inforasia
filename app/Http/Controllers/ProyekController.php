<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\proyek;
use App\Models\task_proyek;
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
        $data = Proyek::where('user_id', $user->id)
            ->orWhereHas('taskProyek.penerimaProyek', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get();

        return response()->json(['proyek' => $data]);
    }

    public function recent()
    {
        $user = FacadesAuth::user();
        if ($user->role->name == 'karyawan') {
            $data = proyek::whereHas('taskProyek.penerimaProyek', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->OrderByDesc('id')->take(5)->get();
        } else {
            $data = proyek::OrderByDesc('id')->take(5)->get();
        }

        return response()->json(['proyek' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'detail' => 'required',
            'manager' => 'required',
            'start' => 'required|date',
            'finish' => 'required|date',
            'klien' => 'required',
        ]);

        $userId = auth()->user()->id;
        // Create the proyek
        $proyek = Proyek::create([
            'nama' => $request->nama,
            'user_id' => $userId,
            'detail' => $request->detail,
            'manager' => $request->manager,
            'nilai' => "0",
            'start' => $request->start,
            'finish' => $request->finish,
            'klien' => $request->klien,
        ]);

        // Add entries in task_proyek for each user_id
        // $taskProyeks = [];
        // foreach ($request->input('user_ids') as $userId) {
        //     $taskProyeks[] = task_proyek::create([
        //         'proyek_id' => $proyek->id,
        //         'user_id' => $userId,
        //     ]);
        // }

        return response()->json([
            'message' => 'Proyek berhasil disimpan',
            'proyek' => $proyek,
            // 'task_proyeks' => $taskProyeks,
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $proyek = proyek::with(['user', 'taskProyek', 'taskProyek.penerimaProyek.user'])->find($id);

        if (!$proyek) {
            return response()->json(['message' => 'Proyek tidak ditemukan'], 404);
        }

        return response()->json(['proyek' => $proyek], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'detail' => 'required',
            'manager' => 'required',
            // 'nilai' => 'required',
            'start' => 'required|date',
            'finish' => 'required|date',
            'klien' => 'required',
        ]);

        // Find the proyek by id
        $proyek = Proyek::findOrFail($id);

        $proyek->update([
            'nama' => $request->nama,
            'detail' => $request->detail,
            'manager' => $request->manager,
            // 'nilai' => $request->nilai,
            'start' => $request->start,
            'finish' => $request->finish,
            'klien' => $request->klien,
        ]);

        return response()->json([
            'message' => 'Proyek berhasil diperbarui',
            'proyek' => $proyek,
        ], 200);
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

    public function getProyek()
    {
        $user = auth()->user();
        if ($user->role->name == 'karyawan') {
            $completedProyekCount = proyek::whereHas('taskProyek.penerimaProyek', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('nilai', 100)->count();

            $onProgressProyekCount = proyek::whereHas('taskProyek.penerimaProyek', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('nilai', '!=', 100)->count();
        } else {
            $completedProyekCount = proyek::where('nilai', 100)->count();
            $onProgressProyekCount = proyek::where('nilai', '!=', 100)->count();
        }

        return response()->json([
            'totalProyekSelesai' => $completedProyekCount,
            'onProgress' => $onProgressProyekCount
        ]);
    }

    public function getProyekChart()
    {
        $user = auth()->user();
        if ($user->role->name == 'karyawan') {
            $projects = proyek::whereHas('taskProyek.penerimaProyek', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        } else {
            $projects = proyek::all();
        }

        $projectData = [];
        foreach ($projects as $project) {
            $projectData[] = [
                'projectName' => $project->nama,
                'value' => $project->nilai,
            ];
        }

        return response()->json($projectData);
    }
}
