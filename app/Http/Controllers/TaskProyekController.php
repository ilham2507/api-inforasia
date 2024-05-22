<?php

namespace App\Http\Controllers;

use App\Models\penerima_proyek;
use App\Models\task_proyek;
use Illuminate\Http\Request;

class TaskProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $proyek_id = $request->query('proyek_id');

        if ($proyek_id) {
            $tasks = task_proyek::with('user')->where('proyek_id', $proyek_id)->get();
        } else {
            $tasks = task_proyek::all();
        }

        return response()->json(['tasks' => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'proyek_id' => 'required',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'tugas' => 'required',
            'catatan' => 'required',
            'start' => 'required',
            'deadline' => 'required',
            'status' => 'required',
            'nilai' => 'required'
        ]);

        $task = task_proyek::create([
            'proyek_id' => $request->proyek_id,
            'tugas' => $request->tugas,
            'catatan' => $request->catatan,
            'start' => $request->start,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'nilai' => $request->nilai,
        ]);

        $taskProyeks = [];
        foreach ($request->input('user_ids') as $userId) {
            $taskProyeks[] = penerima_proyek::create([
                'task_proyek_id' => $task->id,
                'user_id' => $userId,
            ]);
        }

        return response()->json(['message' => 'Task proyek berhasil disimpan', 'task' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = task_proyek::with('penerimaProyek')->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task proyek tidak ditemukan'], 404);
        }

        return response()->json(['task' => $task], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = task_proyek::find($id);

        $request->validate([
            'proyek_id' => 'required',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'tugas' => 'required',
            'catatan' => 'required',
            'start' => 'required|date',
            'deadline' => 'required|date',
            'status' => 'required',
            'nilai' => 'required'
        ]);

        $task->update([
            'proyek_id' => $request->proyek_id,
            'tugas' => $request->tugas,
            'catatan' => $request->catatan,
            'start' => $request->start,
            'deadline' => $request->deadline,
            'status' => $request->status,
            'nilai' => $request->nilai,
        ]);

        // Delete existing penerima_proyek records for the task
        penerima_proyek::where('task_proyek_id', $task->id)->delete();

        // Add new penerima_proyek records
        foreach ($request->input('user_ids') as $userId) {
            penerima_proyek::create([
                'task_proyek_id' => $task->id,
                'user_id' => $userId,
            ]);
        }

        return response()->json(['message' => 'Task proyek berhasil diperbarui', 'task' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = task_proyek::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task proyek tidak ditemukan'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task proyek berhasil dihapus'], 200);
    }
}
