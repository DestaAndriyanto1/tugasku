<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    // Menampilkan seluruh daftar tugas
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
    }

    // Menyimpan tugas baru
    public function store(Request $request)
    {
        Task::create([
            'title' => $request->title,
            'due_date' => $request->due_date,
        ]);

        return redirect('/tasks');
    }

    // Menandai tugas sebagai selesai
    public function complete(Task $task)
    {
        $task->update([
            'completed' => true,
            'completed_at' => now()
        ]);
    
        return redirect('/tasks');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Mengubah data tugas
    public function update(Request $request, Task $task)
    {
        if ($task->completed) {
            return redirect('/tasks');
        }
    
        $task->update([
            'title' => $request->title,
            'due_date' => $request->due_date
        ]);
    
        return redirect('/tasks');
    }

    // Menghapus tugas yang belum selesai
    public function destroy(Task $task)
    {
        if ($task->completed) {
            return redirect('/tasks');
        }
    
        $task->delete();
    
        return redirect('/tasks');
    }

    // Menampilkan tugas selesai berdasarkan rentang tanggal
    public function completed(Request $request)
    {
        $tasks = Task::where('completed', true)
        ->whereBetween('completed_at', [
            $request->start,
            $request->end
        ])
        ->get();

        return response(
            $tasks->pluck('title')->implode(', ')
        );
    }

    // Menampilkan laporan jumlah tugas per tanggal deadline
    public function report()
    {
        $report = Task::select(
            'due_date',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('due_date')
        ->orderBy('due_date')
        ->get();

        $output = '';

        foreach ($report as $row) {
            $output .= $row->due_date . ' : ' . $row->total . PHP_EOL;
        }

        return response($output);
    }
}