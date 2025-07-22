@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 display-6 fw-bold text-success">Moje zadania</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('tasks.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Szukaj</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Szukaj...">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Wszystkie</option>
                        <option value="to-do" @selected(request('status')=='to-do')>Do zrobienia</option>
                        <option value="in progress" @selected(request('status')=='in progress')>W trakcie</option>
                        <option value="done" @selected(request('status')=='done')>Zrobione</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Priorytet</label>
                    <select name="priority" class="form-select">
                        <option value="">Wszystkie</option>
                        <option value="low" @selected(request('priority')=='low')>Niski</option>
                        <option value="medium" @selected(request('priority')=='medium')>Średni</option>
                        <option value="high" @selected(request('priority')=='high')>Wysoki</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Termin</label>
                    <input type="date" name="due_date" value="{{ request('due_date') }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-success w-100" type="submit">
                        <i class="bi bi-funnel"></i> Filtruj
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Dodaj zadanie
        </a>
        <span class="text-muted">Liczba zadań: {{ $tasks->total() }}</span>
    </div>
    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-success">
                    <tr>
                        <th>Nazwa</th>
                        <th>Priorytet</th>
                        <th>Status</th>
                        <th>Termin</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                        <tr>
                            <td class="fw-semibold">{{ $task->name }}</td>
                            <td>
                                <span class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning text-dark' : 'success') }}">{{ ucfirst($task->priority) }}</span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in progress' ? 'warning text-dark' : 'secondary') }}">{{ ucfirst($task->status) }}</span>
                            </td>
                            <td>{{ $task->due_date->format('Y-m-d') }}</td>
                            <td class="d-flex gap-2">
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-success btn-sm">Podgląd</a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">Edytuj</a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Na pewno usunąć?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">Usuń</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Brak zadań.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $tasks->links() }}</div>
</div>
@endsection 