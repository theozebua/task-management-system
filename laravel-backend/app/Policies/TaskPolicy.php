<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\{Task, User};
use Illuminate\Auth\Access\{HandlesAuthorization, Response};
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->id === Auth::id();
    }

    public function view(User $user, Task $task): Response
    {
        return $user->id === Auth::id() && $user->id === $task->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function create(User $user): bool
    {
        return $user->id === Auth::id();
    }

    public function update(User $user, Task $task): Response
    {
        return $user->id === Auth::id() && $user->id === $task->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    public function delete(User $user, Task $task): Response
    {
        return $user->id === Auth::id() && $user->id === $task->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
