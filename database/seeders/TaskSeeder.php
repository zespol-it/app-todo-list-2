<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        Task::factory()->count(5)->create([
            'user_id' => 1,
        ]);
        // Przykładowe zadania ręcznie
        Task::create([
            'user_id' => 1,
            'name' => 'Przykładowe zadanie 1',
            'description' => 'Opis przykładowego zadania 1',
            'priority' => 'medium',
            'status' => 'to-do',
            'due_date' => Carbon::now()->addDays(2),
        ]);
    }
} 