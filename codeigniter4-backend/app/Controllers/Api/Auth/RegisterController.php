<?php

declare(strict_types=1);

namespace App\Controllers\Api\Auth;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Models\User;
use App\Requests\Api\Auth\RegisterRequest;
use App\Traits\Validation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class RegisterController extends BaseController
{
    use ResponseTrait, Validation;

    public function __construct(private User $userModel = new User())
    {
        // 
    }

    public function handle(): ResponseInterface
    {
        if (!$this->validation(new RegisterRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        return $this->respondCreated([
            'status' => true,
            'user'   => $user = $this->saveUser(),
            'token'  => $this->createAccessToken($user),
        ]);
    }

    private function saveUser(): UserEntity
    {
        return $this->userModel->select(['id', 'name', 'email'])
            ->find($this->userModel->insert(new UserEntity(request()->getJSON(true))));
    }

    private function createAccessToken(UserEntity $user): string
    {
        return $this->userModel->createToken('access-token', [
            'tokenable_id'   => $user->id,
            'tokenable_type' => $this->userModel::class,
        ])->plainTextToken;
    }
}
