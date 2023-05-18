<?php

declare(strict_types=1);

namespace App\Controllers\Api\Rest;

use App\Entities\{PersonalAccessTokenEntity, TaskEntity, UserEntity};
use App\Models\Task;
use App\Requests\Api\Rest\{CreateTaskRequest, UpdateTaskRequest};
use App\Traits\Validation;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Pager\Pager;
use CodeIgniter\RESTful\ResourceController;

/**
 * @property-read Task $model
 */
class TaskController extends ResourceController
{
    use Validation;

    protected $modelName = Task::class;

    private PersonalAccessTokenEntity $accessToken;

    public function __construct()
    {
        $this->accessToken = unserialize(request()->header('access-token')->getValue());
    }

    public function index(): ResponseInterface
    {
        $data       = $this->getTasksByAuthId()->paginate(10);
        $pager      = $this->model->pager;
        $pagerLinks = $this->setUpPaginationLinks($pager);

        return $this->respond(compact('data', 'pagerLinks'));
    }

    public function create()
    {
        if (!$this->validation(new CreateTaskRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        return $this->respondCreated([
            'status' => true,
            'task'   => $this->taskResource($this->model->find($this->model->insert($this->newUserEntity())))
        ]);
    }

    public function show($id = null): ResponseInterface
    {
        return $this->respond($this->getTasksByAuthId()->find($id));
    }

    public function update($id = null)
    {
        if (!$this->validation(new UpdateTaskRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        if (!$this->getTasksByAuthId()->find($id)) {
            return $this->failUnauthorized();
        }

        $this->model->update($id, $this->newUserEntity());

        return $this->respondUpdated([
            'status' => true,
            'task'   => $this->taskResource($this->model->find($id)),
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->getTasksByAuthId()->find($id)) {
            return $this->failUnauthorized();
        }

        $this->model->delete($id);

        return $this->respondNoContent();
    }

    private function getTasksByAuthId(): Task
    {
        return $this->model->where('user_id', $this->accessToken->tokenable_id);
    }

    private function newUserEntity(): UserEntity
    {
        return new UserEntity([
            'user_id' => $this->accessToken->tokenable_id,
            ...request()->getJSON(true),
        ]);
    }

    private function taskResource(TaskEntity $task): array
    {
        return [
            'id'          => $task->id,
            'title'       => $task->title,
            'description' => $task->description,
            'due_date'    => $task->due_date->humanize(),
            'priority'    => ucfirst(strtolower($task->priority->name)),
            'is_finished' => $task->is_finished,
            'created_at'  => $task->created_at->humanize(),
            'updated_at'  => $task->updated_at->humanize(),
        ];
    }

    private function setUpPaginationLinks(Pager $pager): array
    {
        return [
            'current_page'  => $pager->getCurrentPage(),
            'first_page'    => $pager->getFirstPage(),
            'last_page'     => $pager->getLastPage(),
            'next_page'     => $pager->getNextPageURI(),
            'previous_page' => $pager->getPreviousPageURI(),
            'total_page'    => $pager->getPageCount(),
            'has_more'      => $pager->hasMore(),
            'total_data'    => $pager->getTotal(),
        ];
    }
}
