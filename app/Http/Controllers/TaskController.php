<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Task::forUser(Auth::id());

        // Filtrowanie
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }

        $tasks = $query->orderBy('due_date')->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to-do,in progress,done',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $validated['user_id'] = Auth::id();

        DB::transaction(function () use ($validated) {
            $task = Task::create($validated);

            // Zapisz historię
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'created',
                'new_values' => $validated,
                'description' => 'Zadanie zostało utworzone',
            ]);
        });

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało utworzone.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task): View
    {
        $this->authorize('view', $task);

        $histories = $task->histories()->with('user')->orderBy('created_at', 'desc')->get();

        return view('tasks.show', compact('task', 'histories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to-do,in progress,done',
            'due_date' => 'required|date',
        ]);

        $oldValues = $task->toArray();

        DB::transaction(function () use ($task, $validated, $oldValues) {
            $task->update($validated);

            // Zapisz historię
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'updated',
                'old_values' => $oldValues,
                'new_values' => $validated,
                'description' => 'Zadanie zostało zaktualizowane',
            ]);
        });

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało zaktualizowane.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        DB::transaction(function () use ($task) {
            // Zapisz historię przed usunięciem
            TaskHistory::create([
                'task_id' => $task->id,
                'user_id' => Auth::id(),
                'action' => 'deleted',
                'old_values' => $task->toArray(),
                'description' => 'Zadanie zostało usunięte',
            ]);

            $task->delete();
        });

        return redirect()->route('tasks.index')->with('success', 'Zadanie zostało usunięte.');
    }

    /**
     * API endpoint dla AJAX
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $query = Task::forUser(Auth::id());

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        $tasks = $query->orderBy('due_date')->get();

        return response()->json($tasks);
    }
}
