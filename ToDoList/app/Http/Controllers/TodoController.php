<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::orderBy('date', 'desc')->get()->groupBy('date');
        return view('index', compact('todos'));
    }

    public function filter($status)
    {
        $query = Todo::orderBy('date', 'desc');

        if ($status === 'completed') {
            $query->where('is_completed', true);
        } elseif ($status === 'incomplete') {
            $query->where('is_completed', false);
        }

        $todos = $query->get()->groupBy('date');

        return view('index', compact('todos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Todo::create([
            'text' => $request->text,
            'date' => $request->date,
            'is_completed' => false,
        ]);

        return redirect()->route('todo.index');
    }

    public function update(Request $request, $id)
{
    $todo = Todo::findOrFail($id);

    if ($request->has('text')) {
        $todo->text = $request->text;
    }

    $todo->is_completed = $request->has('is_completed');
    $todo->save();

    return redirect()->route('todo.index');
}


    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();

        return redirect()->route('todo.index');
    }
}
