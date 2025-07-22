@extends('layouts.guest')

@section('content')
<div class="container mx-auto py-4 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Udostępnione zadanie</h1>
    <div class="bg-white rounded shadow p-4 mb-4">
        <div class="mb-2"><span class="font-semibold">Nazwa:</span> {{ $sharedTask->task->name }}</div>
        <div class="mb-2"><span class="font-semibold">Opis:</span> {{ $sharedTask->task->description ?? '-' }}</div>
        <div class="mb-2"><span class="font-semibold">Priorytet:</span> {{ ucfirst($sharedTask->task->priority) }}</div>
        <div class="mb-2"><span class="font-semibold">Status:</span> {{ ucfirst($sharedTask->task->status) }}</div>
        <div class="mb-2"><span class="font-semibold">Termin:</span> {{ $sharedTask->task->due_date->format('Y-m-d') }}</div>
        <div class="mt-4 text-xs text-gray-500">Link ważny do: {{ $sharedTask->expires_at->format('Y-m-d H:i') }}</div>
    </div>
    @if(!$sharedTask->isValid())
        <div class="text-red-600 font-semibold">Ten link jest już nieaktywny lub wygasł.</div>
    @endif
</div>
@endsection 