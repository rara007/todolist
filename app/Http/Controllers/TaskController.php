<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TaskController extends Controller
{
    /**
     * Display the To-Do list or promotion page based on login status.
     * Ini adalah method yang dipanggil oleh rute /tasks.
     */
    public function index()
    {
        // Periksa apakah ada pengguna yang sedang login
        if (Auth::check()) {
            // Jika pengguna SUDAH login, ambil hanya tugas yang dimiliki oleh pengguna tersebut
            $tasks = Auth::user()->tasks()->orderBy('due_date', 'asc')->get();
            // Kirim data tugas ke view 'tasks.index'
            return view('tasks.index', compact('tasks'));
        } else {
            // Jika pengguna TIDAK login, tampilkan halaman promosi
            return view('tasks.promo'); // Memanggil view resources/views/tasks/promo.blade.php
        }
    }

    /**
     * Show the form for creating a new resource.
     * Hanya dapat diakses oleh pengguna yang sudah login.
     */
    public function create()
    {
        return view('tasks.create'); // Memanggil view resources/views/tasks/create.blade.php
    }

    /**
     * Store a newly created resource in storage (CREATE Logic).
     * Hanya dapat dilakukan oleh pengguna yang sudah login.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        // Redirect kembali ke halaman daftar tugas (tasks.index)
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource (READ SINGLE).
     * Dapat diakses siapa saja.
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task')); // Memanggil view resources/views/tasks/show.blade.php
    }

    /**
     * Show the form for editing the specified resource (UPDATE Form).
     * Hanya dapat diakses oleh pemilik tugas yang sudah login.
     */
    public function edit(Task $task)
    {
        // Pastikan hanya pemilik tugas yang bisa mengedit
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }
        return view('tasks.edit', compact('task')); // Memanggil view resources/views/tasks/edit.blade.php
    }

    /**
     * Update the specified resource in storage (UPDATE Logic).
     */
    public function update(Request $request, Task $task)
    {
        // Pastikan hanya pemilik tugas yang bisa mengupdate
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'completed' => $request->has('completed'),
            'due_date' => $request->due_date,
        ]);

        // Redirect kembali ke halaman daftar tugas (tasks.index)
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Pastikan hanya pemilik tugas yang bisa menghapus
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $task->delete();
        // Redirect kembali ke halaman daftar tugas (tasks.index)
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }
}