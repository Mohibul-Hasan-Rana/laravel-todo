<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Http\Requests\TodoRequest;
use App\Services\EmailService;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function index()
    {
        $todos = Todo::with('emailLogs')->latest()->paginate(10);
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(TodoRequest $request)
    {
        $todo = Todo::create($request->validated());
        
        return redirect()->route('todos.index')
                        ->with('success', 'Todo created successfully!');
    }

    public function show(Todo $todo)
    {
        return view('todos.show', compact('todo'));
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());
        
        return redirect()->route('todos.index')
                        ->with('success', 'Todo updated successfully!');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        
        return redirect()->route('todos.index')
                        ->with('success', 'Todo deleted successfully!');
    }

    public function complete(Todo $todo)
    {
        $todo->update(['completed' => true]);
        
        // Send completion notification
        $this->emailService->sendCompletionNotification($todo);
        
        return redirect()->route('todos.index')
                        ->with('success', 'Todo marked as completed!');
    }
    
}