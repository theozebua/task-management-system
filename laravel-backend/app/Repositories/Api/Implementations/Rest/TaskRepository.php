<?php

declare(strict_types=1);

namespace App\Repositories\Api\Implementations\Rest;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Api\Contracts\Rest\RepositoryContract;
use Illuminate\Support\Facades\Auth;

class TaskRepository implements RepositoryContract
{
    public function store(array $data): array
    {
        $data['user_id'] = Auth::id();
        $task            = Task::create($data);

        /** @var Task $task */
        return [
            'status' => true,
            'task'   => new TaskResource($task),
        ];
    }

    public function update(array $data, $model): array
    {
        $data['updated_at'] = now();

        /** @var Task $model */
        return [
            'status' => (bool) $model->update($data),
            'task'   => new TaskResource($model),
        ];
    }

    public function destroy($model): array
    {
        /** @var Task $model */
        return [
            'status'  => (bool) $model->delete(),
            'message' => 'Failed to delete the data.',
        ];
    }
}
