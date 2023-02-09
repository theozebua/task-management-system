<?php

declare(strict_types=1);

namespace App\Traits;

use App\Entities\PersonalAccessTokenEntity;
use App\Models\PersonalAccessTokenModel;
use CodeIgniter\HTTP\ResponseInterface;

use function hash;
use function preg_replace;
use function request;
use function str_contains;

trait TokenValidation
{
    public function validateToken(): PersonalAccessTokenEntity|ResponseInterface
    {
        $authorization = request()->header('Authorization');
        $token         = $authorization->getValue();

        if (!$authorization || !str_contains($token, 'Bearer ')) {
            return $this->failUnauthorized();
        }

        $plainTextToken = preg_replace('/Bearer \d+\|/', '', $token);

        /** @var PersonalAccessTokenEntity $accessToken */
        $accessToken = (new PersonalAccessTokenModel())->select(['id', 'tokenable_id', 'tokenable_type', 'token'])->where('token', hash('sha256', $plainTextToken))->first();

        if (!$accessToken) {
            return $this->failUnauthorized();
        }

        return $accessToken;
    }
}
