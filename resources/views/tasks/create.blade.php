@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title mb-4 h4 text-success">Dodaj zadanie</h1>
                    <form method="POST" action="{{ route('tasks.store') }}" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Nazwa zadania*</label>
                            <input type="text" name="name" value="{{ old('name') }}" required maxlength="255" class="form-control @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label">Opis</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Priorytet*</label>
                            <select name="priority" required class="form-select">
                                <option value="low" @selected(old('priority')=='low')>Niski</option>
                                <option value="medium" @selected(old('priority')=='medium')>Średni</option>
                                <option value="high" @selected(old('priority')=='high')>Wysoki</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status*</label>
                            <select name="status" required class="form-select">
                                <option value="to-do" @selected(old('status')=='to-do')>Do zrobienia</option>
                                <option value="in progress" @selected(old('status')=='in progress')>W trakcie</option>
                                <option value="done" @selected(old('status')=='done')>Zrobione</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Termin wykonania*</label>
                            <input type="date" name="due_date" value="{{ old('due_date') }}" required class="form-control @error('due_date') is-invalid @enderror">
                            @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 d-flex gap-2 mt-3">
                            <button class="btn btn-success px-4" type="submit">
                                <i class="bi bi-check-lg"></i> Zapisz
                            </button>
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-x-lg"></i> Anuluj
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 