<div style="font-family: Arial, sans-serif;">
    <h2>Przypomnienie o zadaniu</h2>
    <p>Cześć {{ $user->name }},</p>
    <p>Przypominamy, że zadanie <strong>{{ $task->name }}</strong> ma termin wykonania: <strong>{{ $task->due_date->format('Y-m-d') }}</strong>.</p>
    <p><strong>Opis:</strong> {{ $task->description ?? '-' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($task->status) }}</p>
    <p><strong>Priorytet:</strong> {{ ucfirst($task->priority) }}</p>
    <br>
    <p>Pozdrawiamy,<br>Zespół To-Do App</p>
</div> 