<?php

namespace App\Controllers\Api\User;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Requests\Api\User\ChangePasswordRequest;
use App\Traits\{TokenValidation, Validation};
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

use function request;
use function response;

class ChangePasswordController extends BaseController
{
    use ResponseTrait, TokenValidation, Validation;

    public function handle(): ResponseInterface
    {
        $token = $this->validateToken();

        if ($token instanceof ResponseInterface) {
            return $token;
        }

        if (!$this->validation(new ChangePasswordRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        (new $token->tokenable_type)->update($token->tokenable_id, [
            'password' => (new UserEntity(request()->getJSON(true)))->password,
        ]);

        return response()->setJSON([
            'status' => true,
        ]);
    }
}
