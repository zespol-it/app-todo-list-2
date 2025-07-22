@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h1 class="card-title h4 text-success mb-3">Szczegóły zadania</h1>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong>Nazwa:</strong> {{ $task->name }}</li>
                        <li class="list-group-item"><strong>Opis:</strong> {{ $task->description ?? '-' }}</li>
                        <li class="list-group-item"><strong>Priorytet:</strong> <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning text-dark' : 'success') }}">{{ ucfirst($task->priority) }}</span></li>
                        <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in progress' ? 'warning text-dark' : 'secondary') }}">{{ ucfirst($task->status) }}</span></li>
                        <li class="list-group-item"><strong>Termin:</strong> {{ $task->due_date->format('Y-m-d') }}</li>
                    </ul>
                    <div class="d-flex gap-2 mb-3">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">Edytuj</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Na pewno usunąć?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Usuń</button>
                        </form>
                    </div>
                    <form action="{{ route('tasks.share', $task) }}" method="POST" class="mb-3">
                        @csrf
                        <button class="btn btn-outline-success btn-sm" type="submit">Wygeneruj link do udostępnienia</button>
                    </form>
                    @if(session('info'))<div class="alert alert-info py-2">{{ session('info') }}</div>@endif
                    @if(session('success'))<div class="alert alert-success py-2">{{ session('success') }}</div>@endif
                    @php
                        $shared = $task->sharedTasks()->valid()->latest()->first();
                    @endphp
                    @if($shared)
                        <div class="alert alert-primary">
                            <div class="mb-1"><strong>Twój link do udostępnienia zadania:</strong></div>
                            <div class="mb-1"><a href="{{ route('shared-tasks.show', $shared->token) }}" target="_blank">{{ route('shared-tasks.show', $shared->token) }}</a></div>
                            <div class="text-muted small">Link ważny do: {{ $shared->expires_at->format('Y-m-d H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h2 class="h5 text-success mb-3">Historia zmian</h2>
                    @forelse($histories as $history)
                        <div class="mb-3 border-bottom pb-2">
                            <div class="text-muted small mb-1">{{ $history->created_at->format('Y-m-d H:i') }} - {{ $history->user->name ?? 'Użytkownik' }}</div>
                            <div><strong>Akcja:</strong> {{ $history->action }}</div>
                            @if($history->old_values)
                                <div class="text-secondary small">Przed: {{ json_encode($history->old_values) }}</div>
                            @endif
                            @if($history->new_values)
                                <div class="text-secondary small">Po: {{ json_encode($history->new_values) }}</div>
                            @endif
                            @if($history->description)
                                <div class="text-secondary small">{{ $history->description }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="text-muted">Brak historii zmian.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 