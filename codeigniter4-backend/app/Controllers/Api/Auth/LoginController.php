<?php

declare(strict_types=1);

namespace App\Controllers\Api\Auth;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Models\User;
use App\Requests\Api\Auth\LoginRequest;
use App\Traits\Validation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class LoginController extends BaseController
{
    use ResponseTrait, Validation;

    public function __construct(private User $userModel = new User())
    {
        // 
    }

    public function handle(): ResponseInterface
    {
        if (!$this->validation(new LoginRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $user = $this->validateUser();

        return $user
            ? response()->setJSON($this->createAccessToken($user))
            : response()->setJSON($this->responseLoginFailed())->setStatusCode(response()::HTTP_UNAUTHORIZED);
    }

    private function validateUser(): UserEntity|false
    {
        [
            'email'    => $email,
            'password' => $password,
        ] = request()->getJSON(true);

        /** @var UserEntity $user */
        $user = $this->userModel->select(['id', 'email', 'password'])->where('email', $email)->first();

        return $user && password_verify($password, $user->password) ? $user : false;
    }

    private function responseLoginFailed(): array
    {
        return [
            'status'  => false,
            'message' => 'The provided credentials do not match our records.',
        ];
    }

    private function createAccessToken(UserEntity $user): array
    {
        return [
            'status' => true,
            'token'  => $this->userModel->createToken('access-token', [
                'tokenable_id'   => $user->id,
                'tokenable_type' => $this->userModel::class,
            ])->plainTextToken,
        ];
    }
}
