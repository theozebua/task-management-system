<?php

declare(strict_types=1);

namespace App\Controllers\Api\User;

use App\Controllers\BaseController;
use App\Entities\{PersonalAccessTokenEntity, UserEntity};
use App\Requests\Api\User\ChangePasswordRequest;
use App\Traits\Validation;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

use function request;
use function response;
use function unserialize;

class ChangePasswordController extends BaseController
{
    use ResponseTrait, Validation;

    public function handle(): ResponseInterface
    {
        /** @var PersonalAccessTokenEntity $accessToken */
        $accessToken = unserialize(request()->header('access-token')->getValue());

        if (!$this->validation(new ChangePasswordRequest())) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        (new $accessToken->tokenable_type)->update($accessToken->tokenable_id, [
            'password' => (new UserEntity(request()->getJSON(true)))->password,
        ]);

        return response()->setJSON([
            'status' => true,
        ]);
    }
}
