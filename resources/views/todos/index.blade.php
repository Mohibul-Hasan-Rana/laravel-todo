@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Todo List</h1>
    <a href="{{ route('todos.create') }}" class="btn btn-primary">Create New Todo</a>
</div>

<div class="row">
    @forelse($todos as $todo)
        <div class="col-md-6 mb-3">
            <div class="card {{ $todo->completed ? 'border-success' : ($todo->due_date < now() ? 'border-danger' : 'border-warning') }}">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $todo->title }}
                        @if($todo->completed)
                            <span class="badge bg-success">Completed</span>
                        @elseif($todo->due_date < now())
                            <span class="badge bg-danger">Overdue</span>
                        @endif
                    </h5>
                    <p class="card-text">{{ Str::limit($todo->description, 100) }}</p>
                    <p class="text-muted">
                        <small>Due: {{ $todo->due_date->format('M d, Y H:i') }}</small>
                    </p>
                    <p class="text-muted">
                        <small>Email: {{ $todo->email }}</small>
                    </p>
                    
                    <div class="btn-group" role="group">
                        <a href="{{ route('todos.show', $todo) }}" class="btn btn-sm btn-outline-primary">View</a>
                        <a href="{{ route('todos.edit', $todo) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        
                        @if(!$todo->completed)
                            <form method="POST" action="{{ route('todos.complete', $todo) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-success">Complete</button>
                            </form>
                        @endif
                        
                        <form method="POST" action="{{ route('todos.destroy', $todo) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p class="text-center">No todos found. <a href="{{ route('todos.create') }}">Create your first todo!</a></p>
        </div>
    @endforelse
</div>

{{ $todos->links() }}
@endsection