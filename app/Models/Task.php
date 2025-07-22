<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'priority',
        'status',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }

    public function sharedTasks(): HasMany
    {
        return $this->hasMany(SharedTask::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeDueBefore($query, $date)
    {
        return $query->where('due_date', '<=', $date);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', today());
    }

    public function scopeDueTomorrow($query)
    {
        return $query->whereDate('due_date', today()->addDay());
    }

    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && $this->status !== 'done';
    }

    public function isDueToday(): bool
    {
        return $this->due_date->isToday();
    }

    public function isDueTomorrow(): bool
    {
        return $this->due_date->isTomorrow();
    }
}
