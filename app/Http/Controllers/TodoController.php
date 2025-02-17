<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class TodoController extends Controller
{
    public function index( Request $request)
    {
        $query = Todo::query();

        if ($request->has('search') && !empty($request->search)) {
            $query->where('nama','like','%'.$request->search.'%');
        }

        $todos = $query->get();

        return view('index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'prioritas' => 'required|in:1,2,3,4,5',
        ]);
        
        Todo::create([
            'nama' => $request->nama,
            'status' => false,
            'prioritas' => $request->prioritas,
            'tgl_dicentang' => null,
        ]);
        
        return redirect()->route('index')->with('success', 'Data berhasil ditambahkan!');
    }
    
    public function update(Request $request, string $id)  
    {
        $request->validate([
            'nama' => 'required',
            'prioritas' => 'required|in:1,2,3,4,5',
        ]);

        $todo = Todo::findOrFail($id);
        $todo->update([
            'nama' => $request->nama,
            'prioritas' => $request->prioritas,
        ]);

        return redirect()->route('index')->with('success', 'Data berhasil diganti!');
    }

    public function updateStatus($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->status = !$todo->status;
        $todo->tgl_dicentang = $todo->status ? now() : null;
        $todo->save();

        return redirect()->route('index')->with('success', 'Status berhasil diubah!');
    }

    public function edit(string $id) 
    {
        $todo = Todo::findOrFail($id);
        $todos = Todo::all();
        return view('index', compact('todos','todo'));
    }

    public function destroy($id)
    {
        Todo::findOrFail($id)->delete();
        return redirect()->route('index')->with('success', 'Data berhasil dihapus!');
    }
}
