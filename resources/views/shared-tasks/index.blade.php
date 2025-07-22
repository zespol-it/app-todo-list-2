@extends('layouts.app')

@section('content')
<div class="container mx-auto py-4 max-w-2xl">
    <h1 class="text-2xl font-bold mb-4">Udostępnione linki do zadań</h1>
    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Nazwa zadania</th>
                <th class="p-2">Link</th>
                <th class="p-2">Ważny do</th>
                <th class="p-2">Akcje</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sharedTasks as $sharedTask)
                <tr>
                    <td class="p-2">{{ $sharedTask->task->name }}</td>
                    <td class="p-2 text-xs">
                        <a href="{{ route('shared-tasks.show', $sharedTask->token) }}" class="text-blue-600 underline" target="_blank">
                            {{ route('shared-tasks.show', $sharedTask->token) }}
                        </a>
                    </td>
                    <td class="p-2">{{ $sharedTask->expires_at->format('Y-m-d H:i') }}</td>
                    <td class="p-2">
                        <form action="{{ route('shared-tasks.destroy', $sharedTask) }}" method="POST" onsubmit="return confirm('Dezaktywować link?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 underline">Dezaktywuj</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="p-4 text-center">Brak aktywnych linków.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">{{ $sharedTasks->links() }}</div>
</div>
@endsection 