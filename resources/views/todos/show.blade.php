@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Todo Details</h4>
                <div>
                    @if($todo->completed)
                        <span class="badge bg-success fs-6">Completed</span>
                    @elseif($todo->due_date < now())
                        <span class="badge bg-danger fs-6">Overdue</span>
                    @else
                        <span class="badge bg-warning fs-6">Pending</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h3 class="mb-3">{{ $todo->title }}</h3>
                        
                        @if($todo->description)
                            <div class="mb-4">
                                <h6 class="text-muted">Description:</h6>
                                <p class="lead">{{ $todo->description }}</p>
                            </div>
                        @endif
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Email:</h6>
                                <p><i class="fas fa-envelope"></i> {{ $todo->email }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Due Date:</h6>
                                <p><i class="fas fa-calendar"></i> {{ $todo->due_date->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Created:</h6>
                                <p><i class="fas fa-clock"></i> {{ $todo->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Last Updated:</h6>
                                <p><i class="fas fa-edit"></i> {{ $todo->updated_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($todo->reminder_sent)
                            <div class="alert alert-info">
                                <i class="fas fa-bell"></i> Reminder email sent on {{ $todo->reminder_sent_at->format('M d, Y \a\t H:i') }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="card-title">Actions</h6>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('todos.edit', $todo) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i> Edit Todo
                                    </a>
                                    
                                    @if(!$todo->completed)
                                        <form method="POST" action="{{ route('todos.complete', $todo) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-success w-100">
                                                <i class="fas fa-check"></i> Mark Complete
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form method="POST" action="{{ route('todos.destroy', $todo) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger w-100" 
                                                onclick="return confirm('Are you sure you want to delete this todo?')">
                                            <i class="fas fa-trash"></i> Delete Todo
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('todos.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @if($todo->emailLogs->count() > 0)
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Email History</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>Sent At</th>
                                    <th>Attachments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todo->emailLogs as $log)
                                    <tr>
                                        <td>
                                            <span class="badge {{ $log->type === 'reminder' ? 'bg-warning' : 'bg-info' }}">
                                                {{ ucfirst($log->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $log->subject }}</td>
                                        <td>
                                            <span class="badge {{ $log->status === 'sent' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($log->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $log->sent_at ? $log->sent_at->format('M d, Y H:i') : '-' }}</td>
                                        <td>
                                            @if($log->attachments && count($log->attachments) > 0)
                                                <i class="fas fa-paperclip"></i> {{ count($log->attachments) }} file(s)
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection