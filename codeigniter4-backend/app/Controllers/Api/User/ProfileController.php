<?php

declare(strict_types=1);

namespace App\Controllers\Api\User;

use App\Controllers\BaseController;
use App\Entities\PersonalAccessTokenEntity;
use CodeIgniter\HTTP\ResponseInterface;

use function request;
use function response;
use function unserialize;

class ProfileController extends BaseController
{
    public function handle(): ResponseInterface
    {
        /** @var PersonalAccessTokenEntity $accessToken */
        $accessToken = unserialize(request()->header('access-token')->getValue());

        return response()->setJSON([
            'status' => true,
            'user'   => (new $accessToken->tokenable_type)
                ->select(['id', 'name', 'email'])
                ->find($accessToken->tokenable_id),
        ]);
    }
}
