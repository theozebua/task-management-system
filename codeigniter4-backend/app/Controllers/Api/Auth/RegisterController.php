<?php

declare(strict_types=1);

namespace App\Controllers\Api\Auth;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Models\UserModel;
use App\Requests\Api\Auth\RegisterRequest;
use App\Traits\Validation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

use function request;
use function response;

class RegisterController extends BaseController
{
    use ResponseTrait, Validation;

    public function __construct(private UserModel $userModel = new UserModel())
    {
        // 
    }

    public function handle(): ResponseInterface
    {
        if (!$this->validation(new RegisterRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $user = $this->saveUser();

        return response()->setJSON([
            'status' => true,
            'user'   => $this->userResource($user),
            'token'  => $this->createAccessToken($user),
        ]);
    }

    private function saveUser(): UserEntity
    {
        return $this->userModel->find($this->userModel->insert(new UserEntity(request()->getJSON(true))));
    }

    private function userResource(UserEntity $user): array
    {
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
        ];
    }

    private function createAccessToken(UserEntity $user): string
    {
        return $this->userModel->createToken('access-token', [
            'tokenable_id'   => $user->id,
            'tokenable_type' => $this->userModel::class,
        ])->plainTextToken;
    }
}
