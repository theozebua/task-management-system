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
use InvalidArgumentException;
use ValueError;

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
        try {
            return response()->json($this->taskRepository->store($request->validated()), Response::HTTP_CREATED);
        } catch (ValueError $e) {
            return $this->returnFailedJsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        try {
            return response()->json($this->taskRepository->update($request->validated(), $task), Response::HTTP_OK);
        } catch (InvalidArgumentException $e) {
            return $this->returnFailedJsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (ValueError $e) {
            return $this->returnFailedJsonResponse($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Task $task): JsonResponse
    {
        try {
            return response()->json($this->taskRepository->destroy($task), Response::HTTP_NO_CONTENT);
        } catch (InvalidArgumentException $e) {
            return $this->returnFailedJsonResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function returnFailedJsonResponse(string $message, int $code): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
        ], $code);
    }
}
