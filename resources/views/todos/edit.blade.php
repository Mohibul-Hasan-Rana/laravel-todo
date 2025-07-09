@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4>Edit Todo</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('todos.update', $todo) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $todo->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $todo->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $todo->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" 
                               id="due_date" name="due_date" 
                               value="{{ old('due_date', $todo->due_date->format('Y-m-d\TH:i')) }}">
                        @error('due_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="completed" name="completed" 
                               value="1" {{ old('completed', $todo->completed) ? 'checked' : '' }}>
                        <label class="form-check-label" for="completed">
                            Mark as completed
                        </label>
                    </div>

                    @if($todo->reminder_sent)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Reminder email was sent on {{ $todo->reminder_sent_at->format('M d, Y \a\t H:i') }}
                        </div>
                    @endif

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('todos.show', $todo) }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Todo</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header">
                <h5>Current Todo Status</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            @if($todo->completed)
                                <span class="badge bg-success">Completed</span>
                            @elseif($todo->due_date < now())
                                <span class="badge bg-danger">Overdue</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </p>
                        <p><strong>Created:</strong> {{ $todo->created_at->format('M d, Y \a\t H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $todo->updated_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Time Remaining:</strong> 
                            @if($todo->completed)
                                <span class="text-success">Task Completed</span>
                            @elseif($todo->due_date < now())
                                <span class="text-danger">{{ $todo->due_date->diffForHumans() }}</span>
                            @else
                                <span class="text-info">{{ $todo->due_date->diffForHumans() }}</span>
                            @endif
                        </p>
                        <p><strong>Reminder Status:</strong> 
                            @if($todo->reminder_sent)
                                <span class="text-success">Sent</span>
                            @else
                                <span class="text-muted">Not sent</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection