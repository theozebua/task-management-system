<?php

declare(strict_types=1);

namespace App\Repositories\Api\Implementations\Rest;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Repositories\Api\Contracts\Rest\RepositoryContract;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

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
        $this->validateModel($model, Task::class);

        $data['updated_at'] = now();

        /** @var Task $model */
        return [
            'status' => (bool) $model->update($data),
            'task'   => new TaskResource($model),
        ];
    }

    public function destroy($model): array
    {
        $this->validateModel($model, Task::class);

        /** @var Task $model */
        return [
            'status'  => (bool) $model->delete(),
            'message' => 'Failed to delete the data.',
        ];
    }

    private function validateModel(mixed $model, string $class): void
    {
        if (!$model instanceof $class) {
            throw new InvalidArgumentException(sprintf("%s is not an instance of %s", $model, $class));
        }
    }
}
