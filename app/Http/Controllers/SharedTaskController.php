<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\SharedTask;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SharedTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Generuj link do udostępnienia zadania
     */
    public function create(Task $task): RedirectResponse
    {
        $this->authorize('view', $task);

        // Sprawdź czy już istnieje aktywny link
        $existingShare = SharedTask::where('task_id', $task->id)
            ->where('user_id', Auth::id())
            ->valid()
            ->first();

        if ($existingShare) {
            return redirect()->route('tasks.show', $task)
                ->with('info', 'Link już istnieje i jest aktywny.');
        }

        // Utwórz nowy link (ważny przez 7 dni)
        SharedTask::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Link do udostępnienia został wygenerowany.');
    }

    /**
     * Wyświetl udostępnione zadanie
     */
    public function show(string $token): View
    {
        $sharedTask = SharedTask::where('token', $token)
            ->valid()
            ->with('task')
            ->firstOrFail();

        return view('shared-tasks.show', compact('sharedTask'));
    }

    /**
     * Dezaktywuj link do udostępnienia
     */
    public function destroy(SharedTask $sharedTask): RedirectResponse
    {
        $this->authorize('delete', $sharedTask->task);

        $sharedTask->update(['is_active' => false]);

        return redirect()->route('tasks.show', $sharedTask->task)
            ->with('success', 'Link do udostępnienia został dezaktywowany.');
    }

    /**
     * Lista aktywnych linków użytkownika
     */
    public function index(): View
    {
        $sharedTasks = SharedTask::where('user_id', Auth::id())
            ->with('task')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('shared-tasks.index', compact('sharedTasks'));
    }
}
