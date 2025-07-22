<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/tasks', [
            'name' => 'Test zadanie',
            'priority' => 'medium',
            'status' => 'to-do',
            'due_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test zadanie',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->put('/tasks/'.$task->id, [
            'name' => 'Zmienione zadanie',
            'priority' => 'high',
            'status' => 'in progress',
            'due_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect('/tasks');
        $this->assertDatabaseHas('tasks', [
            'name' => 'Zmienione zadanie',
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $response = $this->delete('/tasks/'.$task->id);
        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
} 