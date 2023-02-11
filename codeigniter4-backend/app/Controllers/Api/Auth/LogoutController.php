<?php

declare(strict_types=1);

namespace App\Controllers\Api\Auth;

use App\Controllers\BaseController;
use App\Entities\PersonalAccessTokenEntity;
use App\Models\PersonalAccessToken;
use CodeIgniter\HTTP\ResponseInterface;

use function request;
use function response;
use function unserialize;

class LogoutController extends BaseController
{
    public function __construct(private PersonalAccessToken $personalAccessTokenModel = new PersonalAccessToken())
    {
        //
    }

    public function handle(): ResponseInterface
    {
        /** @var PersonalAccessTokenEntity $accessToken */
        $accessToken = unserialize(request()->header('access-token')->getValue());

        $this->personalAccessTokenModel
            ->where('tokenable_type', $accessToken->tokenable_type)
            ->delete($accessToken->tokenable_id);

        return response()->setStatusCode(response()::HTTP_NO_CONTENT);
    }
}
