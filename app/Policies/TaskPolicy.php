<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return $user->is_admin || $user->id === $task->assigned_to_id || $user->id === $task->created_by_id;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Task $task): bool
    {
        return $user->is_admin || $user->id === $task->assigned_to_id || $user->id === $task->created_by_id;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->is_admin;
    }
}
