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
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="fas fa-tasks fa-3x text-muted"></i>
                </div>
                <h4 class="text-muted">No todos found</h4>
                <p class="text-muted">Get started by creating your first todo!</p>
                <a href="{{ route('todos.create') }}" class="btn btn-primary">Create Todo</a>
            </div>
        </div>
    @endforelse
</div>

{{-- Better pagination with Bootstrap styling --}}
@if($todos->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing {{ $todos->firstItem() ?? 0 }} to {{ $todos->lastItem() ?? 0 }} of {{ $todos->total() }} results
                </small>
                @if($todos->hasPages())
                    <small class="text-muted">
                        Page {{ $todos->currentPage() }} of {{ $todos->lastPage() }}
                    </small>
                @endif
            </div>
            <div class="d-flex justify-content-center">
                {{ $todos->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endif

<!-- {{-- Alternative: Custom pagination info --}}
<div class="row mt-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Showing {{ $todos->firstItem() ?? 0 }} to {{ $todos->lastItem() ?? 0 }} of {{ $todos->total() }} results
            </small>
            @if($todos->hasPages())
                <small class="text-muted">
                    Page {{ $todos->currentPage() }} of {{ $todos->lastPage() }}
                </small>
            @endif
        </div>
    </div>
</div> -->
@endsection