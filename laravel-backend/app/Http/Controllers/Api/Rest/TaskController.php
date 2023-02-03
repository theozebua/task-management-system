<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Rest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Rest\{StoreTaskRequest, UpdateTaskRequest};
use App\Http\Resources\{TaskCollection, TaskResource};
use App\Models\Task;
use App\Repositories\Api\Contracts\Rest\RepositoryContract;
use Illuminate\Http\{JsonResponse, Response};
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(private RepositoryContract $taskRepository)
    {
        $this->authorizeResource(Task::class);
    }

    public function index(): TaskCollection
    {
        return new TaskCollection(Task::whereUserId(Auth::id())->paginate(10));
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        return response()->json($this->taskRepository->store($request->validated()), Response::HTTP_CREATED);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        return response()->json($this->taskRepository->update($request->validated(), $task), Response::HTTP_OK);
    }

    public function destroy(Task $task): JsonResponse
    {
        return response()->json($this->taskRepository->destroy($task), Response::HTTP_NO_CONTENT);
    }
}
