<?php

declare(strict_types=1);

namespace App\Controllers\Api\User;

use App\Controllers\BaseController;
use App\Entities\UserEntity;
use App\Traits\TokenValidation;
use CodeIgniter\HTTP\ResponseInterface;

use function response;

class ProfileController extends BaseController
{
    use TokenValidation;

    public function handle(): ResponseInterface
    {
        $token = $this->validateToken();

        if ($token instanceof ResponseInterface) {
            return $token;
        }

        /** @var UserEntity $user */
        $user = (new $token->tokenable_type)->select(['id', 'name', 'email'])->find($token->tokenable_id);

        return response()->setJSON([
            'status' => true,
            'user'   => $user,
        ]);
    }
}
